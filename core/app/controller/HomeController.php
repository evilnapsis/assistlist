<?php
namespace App\Controller;

use App\Service\AttendanceService;
use AssistanceData;
use PersonData;
use ViewEngine;

class HomeController {
    private AttendanceService $attendanceService;

    public function __construct() {
        $this->attendanceService = new AttendanceService();
    }

    public function index(): void {
        $summary = $this->attendanceService->getTodaySummary();
        $today = date('Y-m-d');
        $employeesToday = PersonData::getAllWithAttendanceForDate($today);

        // 1. Gráfica 1: Últimos 30 días (solo asistencias presentes)
        $last30 = AssistanceData::getLast30DaysPresence();
        $last30Labels = array_column($last30, 'formatted_date');
        $last30Values = array_map('intval', array_column($last30, 'present_count'));

        // 2. Gráfica 2: Barras por colores de presentes y faltas por departamento
        $deptComp = AssistanceData::getDepartmentAttendanceComparison($today);
        $deptLabels = array_column($deptComp, 'department_name');
        $deptPresents = array_map('intval', array_column($deptComp, 'present_count'));
        $deptAbsents = array_map('intval', array_column($deptComp, 'absent_count'));
        $deptLates = array_map('intval', array_column($deptComp, 'late_count'));

        // 3. Gráfica 3: Empleados con asistencia vs Sin definir (NULL)
        $markedCount = (int)$summary['stats']['marked_count'];
        $unmarkedCount = (int)$summary['stats']['unmarked_count'];

        // Desglose por estados para gráfica de dona general
        $chartLabels = [];
        $chartColors = [];
        $chartData = [];
        foreach ($summary['stats']['status_breakdown'] as $sb) {
            $chartLabels[] = $sb['name'];
            $chartColors[] = $sb['color'];
            $chartData[] = (int)$sb['total_count'];
        }

        ViewEngine::render('home/index.html.twig', [
            'summary'             => $summary,
            'employees_today'     => $employeesToday,
            'last30_labels_json'  => json_encode($last30Labels),
            'last30_data_json'    => json_encode($last30Values),
            'dept_labels_json'    => json_encode($deptLabels),
            'dept_presents_json'  => json_encode($deptPresents),
            'dept_absents_json'   => json_encode($deptAbsents),
            'dept_lates_json'     => json_encode($deptLates),
            'null_chart_data_json'=> json_encode([$markedCount, $unmarkedCount]),
            'chart_labels_json'   => json_encode($chartLabels),
            'chart_colors_json'   => json_encode($chartColors),
            'chart_data_json'     => json_encode($chartData),
        ]);
    }
}
?>
