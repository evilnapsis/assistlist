<?php
namespace App\Controller;

use App\Service\AttendanceService;
use AssistanceData;
use AssistanceStatusData;
use DepartmentData;
use PersonData;
use Request;
use Session;
use ViewEngine;

class AttendanceController {
    private AttendanceService $attendanceService;

    public function __construct() {
        $this->attendanceService = new AttendanceService();
    }

    public function take(): void {
        $date = Request::get('date', date('Y-m-d'));
        $departmentId = Request::get('department_id') ? (int)Request::get('department_id') : null;

        $employees = PersonData::getAllWithAttendanceForDate($date, $departmentId);
        $departments = DepartmentData::getAllActive();
        $statuses = AssistanceStatusData::getAllActive();
        $stats = AssistanceData::getStatsForDate($date);

        ViewEngine::render('attendance/take.html.twig', [
            'date'           => $date,
            'selected_dept'  => $departmentId,
            'employees'      => $employees,
            'departments'    => $departments,
            'statuses'       => $statuses,
            'stats'          => $stats,
        ]);
    }

    public function save(): void {
        $date = Request::post('date', date('Y-m-d'));
        $records = Request::post('attendance', []);
        $userId = $_SESSION['user_id'] ?? null;

        if (is_array($records) && !empty($records)) {
            $saved = $this->attendanceService->saveBatchAttendance($records, $date, $userId);
            Session::flash('success', "Se guardaron correctamente las asistencias de {$saved} empleados para el día {$date}.");
        } else {
            Session::flash('info', 'No se enviaron datos de asistencia.');
        }

        $baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        $redirectUrl = $baseFolder . '/attendance/take?date=' . urlencode($date);
        if ($dept = Request::post('department_id')) {
            $redirectUrl .= '&department_id=' . (int)$dept;
        }
        header('Location: ' . $redirectUrl);
        exit;
    }

    public function markAllPresent(): void {
        $date = Request::post('date', date('Y-m-d'));
        $deptId = Request::post('department_id') ? (int)Request::post('department_id') : null;
        $userId = $_SESSION['user_id'] ?? null;

        $count = $this->attendanceService->markAllPresent($date, $deptId, $userId);
        Session::flash('success', "¡Listo! Se marcaron {$count} empleados como 'Presente' para la fecha {$date}.");

        $baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        $redirectUrl = $baseFolder . '/attendance/take?date=' . urlencode($date);
        if ($deptId) {
            $redirectUrl .= '&department_id=' . $deptId;
        }
        header('Location: ' . $redirectUrl);
        exit;
    }
}
?>
