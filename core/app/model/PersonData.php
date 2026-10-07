<?php

#[\AllowDynamicProperties]
class PersonData extends LbModel {
	public static $tablename = "person";

	public $id;
	public $code;
	public $name;
	public $lastname;
	public $dni_cif;
	public $email;
	public $phone;
	public $address;
	public $job_title;
	public $department_id;
	public $hire_date;
	public $salary;
	public $image;
	public $is_active;
	public $created_at;

	// Propiedades relacionales / dinámicas
	public $department_name;
	public $department_code;
	public $today_status_id;
	public $today_status_name;
	public $today_status_color;
	public $today_status_icon;
	public $today_status_badge;
	public $today_note;
	public $today_time_in;
	public $today_time_out;

	public function __construct(){
		$this->code = "EMP-" . rand(100, 999);
		$this->name = "";
		$this->lastname = "";
		$this->dni_cif = "";
		$this->email = "";
		$this->phone = "";
		$this->address = "";
		$this->job_title = "Colaborador";
		$this->department_id = null;
		$this->hire_date = date('Y-m-d');
		$this->salary = 0.00;
		$this->image = "";
		$this->is_active = 1;
		$this->created_at = date('Y-m-d H:i:s');
	}

	public function getFullname(): string {
		return trim($this->name . " " . $this->lastname);
	}

	public function getDepartment(): ?DepartmentData {
		return $this->department_id ? DepartmentData::getById($this->department_id) : null;
	}

	public static function getById($id){
		$db = static::getDb();
		$stmt = $db->prepare("SELECT p.*, d.name AS department_name, d.code AS department_code
		                      FROM " . static::$tablename . " p
		                      LEFT JOIN department d ON d.id = p.department_id
		                      WHERE p.id = :id LIMIT 1");
		$stmt->execute(['id' => $id]);
		$stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, static::class);
		return $stmt->fetch() ?: null;
	}

	public static function getAllActive(): array {
		$db = static::getDb();
		$stmt = $db->query("SELECT p.*, d.name AS department_name, d.code AS department_code
		                    FROM " . static::$tablename . " p
		                    LEFT JOIN department d ON d.id = p.department_id
		                    WHERE p.is_active = 1
		                    ORDER BY p.name ASC, p.lastname ASC");
		return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, static::class);
	}

	public static function getAllByDepartment($department_id): array {
		$db = static::getDb();
		$stmt = $db->prepare("SELECT p.*, d.name AS department_name, d.code AS department_code
		                      FROM " . static::$tablename . " p
		                      LEFT JOIN department d ON d.id = p.department_id
		                      WHERE p.department_id = :dept_id AND p.is_active = 1
		                      ORDER BY p.name ASC, p.lastname ASC");
		$stmt->execute(['dept_id' => $department_id]);
		return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, static::class);
	}

	public static function getAllWithAttendanceForDate(string $date, ?int $department_id = null): array {
		$db = static::getDb();
		$where = "WHERE p.is_active = 1";
		$params = ['d' => $date];

		if ($department_id) {
			$where .= " AND p.department_id = :dept_id";
			$params['dept_id'] = $department_id;
		}

		$sql = "SELECT p.*, d.name AS department_name, d.code AS department_code,
		               a.id AS attendance_id, a.status_id AS today_status_id, a.note AS today_note,
		               a.time_in AS today_time_in, a.time_out AS today_time_out,
		               st.name AS today_status_name, st.color AS today_status_color,
		               st.icon AS today_status_icon, st.badge_class AS today_status_badge
		        FROM " . static::$tablename . " p
		        LEFT JOIN department d ON d.id = p.department_id
		        LEFT JOIN assistance a ON a.person_id = p.id AND a.date_at = :d
		        LEFT JOIN assistance_status st ON st.id = a.status_id
		        {$where}
		        ORDER BY d.name ASC, p.name ASC, p.lastname ASC";

		$stmt = $db->prepare($sql);
		$stmt->execute($params);
		return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, static::class);
	}
}
?>
