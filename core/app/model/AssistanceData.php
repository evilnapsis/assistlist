<?php

#[\AllowDynamicProperties]
class AssistanceData extends LbModel {
	public static $tablename = "assistance";

	public $id;
	public $person_id;
	public $status_id;
	public $date_at;
	public $time_in;
	public $time_out;
	public $note;
	public $user_id;
	public $created_at;

	// Relacionales / Calculados
	public $person_name;
	public $person_lastname;
	public $person_code;
	public $job_title;
	public $department_name;
	public $status_name;
	public $status_color;
	public $status_icon;
	public $status_badge;

	public function __construct(){
		$this->person_id = null;
		$this->status_id = 1; // Presente por defecto
		$this->date_at = date('Y-m-d');
		$this->time_in = date('H:i:s');
		$this->time_out = null;
		$this->note = "";
		$this->user_id = null;
		$this->created_at = date('Y-m-d H:i:s');
	}

	public function getPerson(): ?PersonData {
		return $this->person_id ? PersonData::getById($this->person_id) : null;
	}

	public function getStatus(): ?AssistanceStatusData {
		return $this->status_id ? AssistanceStatusData::getById($this->status_id) : null;
	}

	public static function getById($id){
		return static::find($id);
	}

	public static function getByPersonAndDate($person_id, $date): ?AssistanceData {
		$db = static::getDb();
		$stmt = $db->prepare("SELECT * FROM " . static::$tablename . " WHERE person_id = :p AND date_at = :d LIMIT 1");
		$stmt->execute(['p' => $person_id, 'd' => $date]);
		$stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, static::class);
		return $stmt->fetch() ?: null;
	}

	public static function deleteByPersonAndDate(int $person_id, string $date): bool {
		$db = static::getDb();
		$stmt = $db->prepare("DELETE FROM " . static::$tablename . " WHERE person_id = :p AND date_at = :d");
		return $stmt->execute(['p' => $person_id, 'd' => $date]);
	}

	public static function setAttendance(int $person_id, int $status_id, string $date, string $note = '', ?int $user_id = null, ?string $time_in = null): bool {
		$db = static::getDb();
		$sql = "INSERT INTO " . static::$tablename . " (person_id, status_id, date_at, time_in, note, user_id, created_at)
		        VALUES (:person_id, :status_id, :date_at, :time_in, :note, :user_id, NOW())
		        ON DUPLICATE KEY UPDATE 
		            status_id = VALUES(status_id),
		            note = VALUES(note),
		            time_in = COALESCE(VALUES(time_in), time_in),
		            user_id = VALUES(user_id)";
		$stmt = $db->prepare($sql);
		return $stmt->execute([
			'person_id' => $person_id,
			'status_id' => $status_id,
			'date_at'   => $date,
			'time_in'   => $time_in ?? date('H:i:s'),
			'note'      => $note,
			'user_id'   => $user_id
		]);
	}

	public static function markAllPresent(string $date, ?int $department_id = null, ?int $user_id = null): int {
		$db = static::getDb();
		$presentStatus = AssistanceStatusData::getByCode('present');
		$presentId = $presentStatus ? $presentStatus->id : 1;

		$employees = PersonData::getAllActive();
		$count = 0;
		foreach ($employees as $emp) {
			if ($department_id && $emp->department_id != $department_id) {
				continue;
			}
			self::setAttendance($emp->id, $presentId, $date, 'Marcado masivo puntual', $user_id, '09:00:00');
			$count++;
		}
		return $count;
	}

	public static function getStatsForDate(string $date): array {
		$db = static::getDb();
		$totalEmployees = (int)$db->query("SELECT COUNT(*) FROM person WHERE is_active = 1")->fetchColumn();

		$stmt = $db->prepare("SELECT st.id, st.code, st.name, st.color, st.icon, st.counts_as_present,
		                             COUNT(a.id) AS total_count
		                      FROM assistance_status st
		                      LEFT JOIN assistance a ON a.status_id = st.id AND a.date_at = :d
		                      WHERE st.is_active = 1
		                      GROUP BY st.id, st.code, st.name, st.color, st.icon, st.counts_as_present
		                      ORDER BY st.order_num ASC");
		$stmt->execute(['d' => $date]);
		$statuses = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$markedCount = 0;
		$presentCount = 0;
		$absentCount = 0;
		$lateCount = 0;

		foreach ($statuses as $s) {
			$markedCount += (int)$s['total_count'];
			if ($s['code'] === 'present') {
				$presentCount += (int)$s['total_count'];
			} elseif ($s['code'] === 'late') {
				$lateCount += (int)$s['total_count'];
			} elseif ($s['code'] === 'absent') {
				$absentCount += (int)$s['total_count'];
			}
		}

		$unmarkedCount = max(0, $totalEmployees - $markedCount);
		$attendancePercentage = $totalEmployees > 0 ? round((($presentCount + $lateCount) / $totalEmployees) * 100, 1) : 0;

		return [
			'date'                  => $date,
			'total_employees'       => $totalEmployees,
			'marked_count'          => $markedCount,
			'unmarked_count'        => $unmarkedCount,
			'present_count'         => $presentCount,
			'late_count'            => $lateCount,
			'absent_count'          => $absentCount,
			'attendance_percentage' => $attendancePercentage,
			'status_breakdown'      => $statuses
		];
	}

	public static function getDepartmentAttendanceStatsForDate(string $date): array {
		$db = static::getDb();
		$sql = "SELECT d.id, d.name AS department_name, d.code AS department_code,
		               COUNT(p.id) AS total_employees,
		               SUM(CASE WHEN a.status_id = 1 THEN 1 ELSE 0 END) AS present_count,
		               SUM(CASE WHEN a.status_id = 2 THEN 1 ELSE 0 END) AS late_count,
		               SUM(CASE WHEN a.status_id = 3 THEN 1 ELSE 0 END) AS absent_count
		        FROM department d
		        LEFT JOIN person p ON p.department_id = d.id AND p.is_active = 1
		        LEFT JOIN assistance a ON a.person_id = p.id AND a.date_at = :d
		        WHERE d.is_active = 1
		        GROUP BY d.id, d.name, d.code
		        ORDER BY d.name ASC";
		$stmt = $db->prepare($sql);
		$stmt->execute(['d' => $date]);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function getHistoryByPerson(int $person_id, int $limit = 30): array {
		$db = static::getDb();
		$stmt = $db->prepare("SELECT a.*, st.name AS status_name, st.color AS status_color, 
		                             st.icon AS status_icon, st.badge_class AS status_badge
		                      FROM " . static::$tablename . " a
		                      INNER JOIN assistance_status st ON st.id = a.status_id
		                      WHERE a.person_id = :p
		                      ORDER BY a.date_at DESC LIMIT " . (int)$limit);
		$stmt->execute(['p' => $person_id]);
		return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, static::class);
	}

	public static function getLast30DaysPresence(): array {
		$db = static::getDb();
		$sql = "SELECT d.date_val AS date,
		               DATE_FORMAT(d.date_val, '%d/%m') AS formatted_date,
		               COALESCE(COUNT(a.id), 0) AS present_count
		        FROM (
		            SELECT CURDATE() - INTERVAL (a.a + (10 * b.a)) DAY AS date_val
		            FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a
		            CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2) AS b
		            WHERE (a.a + (10 * b.a)) < 30
		        ) d
		        LEFT JOIN assistance a ON a.date_at = d.date_val 
		            AND a.status_id IN (SELECT id FROM assistance_status WHERE counts_as_present = 1)
		        GROUP BY d.date_val
		        ORDER BY d.date_val ASC";
		$stmt = $db->query($sql);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function getDepartmentAttendanceComparison(string $date): array {
		$db = static::getDb();
		$sql = "SELECT d.id, d.name AS department_name, d.code AS department_code,
		               COUNT(DISTINCT p.id) AS total_employees,
		               COUNT(DISTINCT CASE WHEN st.counts_as_present = 1 THEN a.id END) AS present_count,
		               COUNT(DISTINCT CASE WHEN st.code = 'absent' THEN a.id END) AS absent_count,
		               COUNT(DISTINCT CASE WHEN st.code = 'late' THEN a.id END) AS late_count,
		               COUNT(DISTINCT CASE WHEN a.id IS NULL THEN p.id END) AS null_count
		        FROM department d
		        INNER JOIN person p ON p.department_id = d.id AND p.is_active = 1
		        LEFT JOIN assistance a ON a.person_id = p.id AND a.date_at = :d
		        LEFT JOIN assistance_status st ON st.id = a.status_id
		        WHERE d.is_active = 1
		        GROUP BY d.id, d.name, d.code
		        ORDER BY d.name ASC";
		$stmt = $db->prepare($sql);
		$stmt->execute(['d' => $date]);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function getRangeReportData(string $startDate, string $endDate, int|string|null $departmentId = null): array {
		$db = static::getDb();
		$deptId = $departmentId !== null && $departmentId !== '' ? (int)$departmentId : null;
		
		$days = [];
		$current = new \DateTime($startDate);
		$end = new \DateTime($endDate);
		while ($current <= $end) {
			$days[] = [
				'date'       => $current->format('Y-m-d'),
				'day_num'    => $current->format('d'),
				'day_name'   => $current->format('D'),
				'is_weekend' => in_array((int)$current->format('N'), [6, 7], true)
			];
			$current->modify('+1 day');
		}

		$whereEmp = "WHERE p.is_active = 1";
		$paramsEmp = [];
		if ($deptId) {
			$whereEmp .= " AND p.department_id = :dept_id";
			$paramsEmp['dept_id'] = $deptId;
		}
		$stmtEmp = $db->prepare("SELECT p.*, d.name AS department_name, d.code AS department_code
		                         FROM person p
		                         LEFT JOIN department d ON d.id = p.department_id
		                         {$whereEmp}
		                         ORDER BY d.name ASC, p.name ASC, p.lastname ASC");
		$stmtEmp->execute($paramsEmp);
		$employees = $stmtEmp->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, PersonData::class);

		$statuses = AssistanceStatusData::getAllActive();
		$statusMap = [];
		foreach ($statuses as $st) {
			$statusMap[$st->id] = $st;
		}

		$whereAss = "WHERE a.date_at BETWEEN :start_d AND :end_d";
		$paramsAss = ['start_d' => $startDate, 'end_d' => $endDate];
		if ($deptId) {
			$whereAss .= " AND p.department_id = :dept_id";
			$paramsAss['dept_id'] = $deptId;
		}
		$sqlAss = "SELECT a.*, st.name AS status_name, st.code AS status_code, st.color AS status_color, 
		                  st.icon AS status_icon, st.badge_class AS status_badge, st.counts_as_present
		           FROM assistance a
		           INNER JOIN person p ON p.id = a.person_id
		           INNER JOIN assistance_status st ON st.id = a.status_id
		           {$whereAss}";
		$stmtAss = $db->prepare($sqlAss);
		$stmtAss->execute($paramsAss);
		$records = $stmtAss->fetchAll(PDO::FETCH_ASSOC);

		$attendanceMatrix = [];
		$globalStatusCounts = [];
		foreach ($statuses as $st) {
			$globalStatusCounts[$st->id] = [
				'id'               => $st->id,
				'code'             => $st->code,
				'name'             => $st->name,
				'color'            => $st->color,
				'icon'             => $st->icon,
				'count'            => 0
			];
		}

		$totalPresent = 0;
		$totalAbsent = 0;
		$totalLate = 0;

		foreach ($records as $r) {
			$pId = (int)$r['person_id'];
			$dAt = $r['date_at'];
			$attendanceMatrix[$pId][$dAt] = $r;

			$sId = (int)$r['status_id'];
			if (isset($globalStatusCounts[$sId])) {
				$globalStatusCounts[$sId]['count']++;
			}
			if ((int)$r['counts_as_present'] === 1) {
				$totalPresent++;
			}
			if ($r['status_code'] === 'absent') {
				$totalAbsent++;
			} elseif ($r['status_code'] === 'late') {
				$totalLate++;
			}
		}

		$employeeSummaries = [];
		$totalDaysCount = count($days);
		foreach ($employees as $emp) {
			$empPres = 0;
			$empAbs = 0;
			$empLate = 0;
			$empMarked = 0;

			foreach ($days as $day) {
				$d = $day['date'];
				if (isset($attendanceMatrix[$emp->id][$d])) {
					$rec = $attendanceMatrix[$emp->id][$d];
					$empMarked++;
					if ((int)$rec['counts_as_present'] === 1) $empPres++;
					if ($rec['status_code'] === 'absent') $empAbs++;
					if ($rec['status_code'] === 'late') $empLate++;
				}
			}

			$employeeSummaries[$emp->id] = [
				'total_present' => $empPres,
				'total_absent'  => $empAbs,
				'total_late'    => $empLate,
				'total_marked'  => $empMarked,
				'total_days'    => $totalDaysCount,
				'rate'          => $totalDaysCount > 0 ? round(($empPres / $totalDaysCount) * 100, 1) : 0
			];
		}

		return [
			'days'                 => $days,
			'employees'            => $employees,
			'statuses'             => $statuses,
			'matrix'               => $attendanceMatrix,
			'employee_summaries'   => $employeeSummaries,
			'global_status_counts' => array_values($globalStatusCounts),
			'total_present'        => $totalPresent,
			'total_absent'         => $totalAbsent,
			'total_late'           => $totalLate,
			'total_records'        => count($records)
		];
	}
}
?>
