<?php
namespace App\Controller;

use App\Service\AttendanceService;
use DepartmentData;
use Request;
use ViewEngine;

class ReportController {
    private AttendanceService $attendanceService;

    public function __construct() {
        $this->attendanceService = new AttendanceService();
    }

    public function index(): void {
        $startDate = Request::get('start_date', date('Y-m-01'));
        $endDate = Request::get('end_date', date('Y-m-d'));
        $deptId = Request::get('department_id') ? (int)Request::get('department_id') : null;

        if ($startDate > $endDate) {
            $tmp = $startDate;
            $startDate = $endDate;
            $endDate = $tmp;
        }

        $reportData = \AssistanceData::getRangeReportData($startDate, $endDate, $deptId);
        $departments = DepartmentData::getAllActive();

        ViewEngine::render('reports/index.html.twig', [
            'start_date'           => $startDate,
            'end_date'             => $endDate,
            'selected_dept'        => $deptId,
            'departments'          => $departments,
            'days'                 => $reportData['days'],
            'employees'            => $reportData['employees'],
            'statuses'             => $reportData['statuses'],
            'matrix'               => $reportData['matrix'],
            'employee_summaries'   => $reportData['employee_summaries'],
            'global_status_counts' => $reportData['global_status_counts'],
            'total_present'        => $reportData['total_present'],
            'total_absent'         => $reportData['total_absent'],
            'total_late'           => $reportData['total_late'],
            'total_records'        => $reportData['total_records']
        ]);
    }

    public function monthly(): void {
        $year = (int)Request::get('year', date('Y'));
        $month = (int)Request::get('month', date('n'));
        $deptId = Request::get('department_id') ? (int)Request::get('department_id') : null;

        $data = $this->attendanceService->getMonthlyMatrix($year, $month, $deptId);
        $departments = DepartmentData::getAllActive();

        ViewEngine::render('reports/monthly.html.twig', [
            'year'          => $year,
            'month'         => $month,
            'selected_dept' => $deptId,
            'days_in_month' => $data['days_in_month'],
            'employees'     => $data['employees'],
            'matrix'        => $data['matrix'],
            'statuses'      => $data['statuses'],
            'departments'   => $departments
        ]);
    }

    public function exportCsv(): void {
        $startDate = Request::get('start_date', date('Y-m-01'));
        $endDate = Request::get('end_date', date('Y-m-d'));
        $deptId = Request::get('department_id') ? (int)Request::get('department_id') : null;

        $reportData = \AssistanceData::getRangeReportData($startDate, $endDate, $deptId);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="reporte_asistencia_' . $startDate . '_al_' . $endDate . '.csv"');

        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));

        $header = ['Codigo', 'Colaborador', 'Departamento', 'Cargo'];
        foreach ($reportData['days'] as $day) {
            $header[] = $day['date'];
        }
        $header[] = 'Total Presentes';
        $header[] = 'Total Faltas';
        $header[] = 'Total Tardanzas';
        $header[] = '% Asistencia';
        fputcsv($out, $header);

        foreach ($reportData['employees'] as $emp) {
            $row = [
                $emp->code,
                $emp->name . ' ' . $emp->lastname,
                $emp->department_name,
                $emp->job_title
            ];
            foreach ($reportData['days'] as $day) {
                $d = $day['date'];
                if (isset($reportData['matrix'][$emp->id][$d])) {
                    $row[] = $reportData['matrix'][$emp->id][$d]['status_name'];
                } else {
                    $row[] = 'Sin registrar';
                }
            }
            $sum = $reportData['employee_summaries'][$emp->id] ?? [];
            $row[] = $sum['total_present'] ?? 0;
            $row[] = $sum['total_absent'] ?? 0;
            $row[] = $sum['total_late'] ?? 0;
            $row[] = ($sum['rate'] ?? 0) . '%';
            fputcsv($out, $row);
        }
        fclose($out);
        exit;
    }
}
?>
