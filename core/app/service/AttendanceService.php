<?php
namespace App\Service;

use AssistanceData;
use AssistanceStatusData;
use DepartmentData;
use PersonData;

/**
 * Clase AttendanceService
 * Servicio de lógica de negocio para asistencias, métricas y reportes
 */
class AttendanceService {

    public function getTodaySummary(): array {
        $today = date('Y-m-d');
        $stats = AssistanceData::getStatsForDate($today);
        $deptStats = AssistanceData::getDepartmentAttendanceStatsForDate($today);

        return [
            'date'              => $today,
            'stats'             => $stats,
            'department_stats'  => $deptStats,
            'departments'       => DepartmentData::getAllActive(),
            'statuses'          => AssistanceStatusData::getAllActive()
        ];
    }

    public function markAllPresent(string $date, int|string|null $department_id = null, int|string|null $user_id = null): int {
        $deptId = $department_id !== null && $department_id !== '' ? (int)$department_id : null;
        $uid = $user_id !== null && $user_id !== '' ? (int)$user_id : null;
        return AssistanceData::markAllPresent($date, $deptId, $uid);
    }

    public function saveSingleAttendance(int|string $person_id, int|string $status_id, string $date, string $note = '', int|string|null $user_id = null, ?string $time_in = null): bool {
        $pid = (int)$person_id;
        $sid = (int)$status_id;
        $uid = $user_id !== null && $user_id !== '' ? (int)$user_id : null;
        return AssistanceData::setAttendance($pid, $sid, $date, $note, $uid, $time_in);
    }

    public function saveBatchAttendance(array $attendanceData, string $date, ?int $user_id = null): int {
        $count = 0;
        foreach ($attendanceData as $personId => $info) {
            $statusId = isset($info['status_id']) && $info['status_id'] !== '' && $info['status_id'] !== '0' 
                ? (int)$info['status_id'] 
                : null;
            $note = trim($info['note'] ?? '');
            $timeIn = !empty($info['time_in']) ? $info['time_in'] : null;

            if ($statusId !== null && $statusId > 0) {
                if ($this->saveSingleAttendance((int)$personId, $statusId, $date, $note, $user_id, $timeIn)) {
                    $count++;
                }
            } else {
                AssistanceData::deleteByPersonAndDate((int)$personId, $date);
            }
        }
        return $count;
    }

    public function getMonthlyMatrix(int $year, int $month, int|string|null $department_id = null): array {
        $deptId = $department_id !== null && $department_id !== '' ? (int)$department_id : null;
        $daysInMonth = (int)cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $employees = $deptId ? PersonData::getAllByDepartment($deptId) : PersonData::getAllActive();
        $statuses = AssistanceStatusData::getAllActive();
        $statusMap = [];
        foreach ($statuses as $st) {
            $statusMap[$st->id] = $st;
        }

        $startDate = sprintf('%04d-%02d-01', $year, $month);
        $endDate = sprintf('%04d-%02d-%02d', $year, $month, $daysInMonth);

        $db = \Database::getPdo();
        $sql = "SELECT person_id, status_id, date_at, time_in, note 
                FROM assistance 
                WHERE date_at BETWEEN :start AND :end";
        $stmt = $db->prepare($sql);
        $stmt->execute(['start' => $startDate, 'end' => $endDate]);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $matrix = [];
        foreach ($rows as $r) {
            $day = (int)date('j', strtotime($r['date_at']));
            $matrix[$r['person_id']][$day] = [
                'status_id'   => $r['status_id'],
                'status_name' => $statusMap[$r['status_id']]->name ?? '',
                'color'       => $statusMap[$r['status_id']]->color ?? '#6c757d',
                'badge_class' => $statusMap[$r['status_id']]->badge_class ?? 'bg-secondary',
                'icon'        => $statusMap[$r['status_id']]->icon ?? 'bi-circle',
                'note'        => $r['note'],
                'time_in'     => $r['time_in']
            ];
        }

        return [
            'year'          => $year,
            'month'         => $month,
            'days_in_month' => $daysInMonth,
            'employees'     => $employees,
            'matrix'        => $matrix,
            'statuses'      => $statuses
        ];
    }
}
?>
