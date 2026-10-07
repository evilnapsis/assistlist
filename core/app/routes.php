<?php
/**
 * AssistList 2 - FastRoute Routing Configuration
 */

use App\Controller\AuthController;
use App\Controller\HomeController;
use App\Controller\AttendanceController;
use App\Controller\DepartmentController;
use App\Controller\PersonController;
use App\Controller\StatusController;
use App\Controller\ReportController;
use App\Controller\UserController;

return function(FastRoute\RouteCollector $r) {
    // Autenticación
    $r->addRoute('GET', '/login', [AuthController::class, 'showLogin']);
    $r->addRoute('POST', '/login', [AuthController::class, 'login']);
    $r->addRoute('GET', '/logout', [AuthController::class, 'logout']);

    // Dashboard
    $r->addRoute('GET', '/', [HomeController::class, 'index']);

    // Toma de Asistencia
    $r->addRoute('GET', '/attendance/take', [AttendanceController::class, 'take']);
    $r->addRoute('POST', '/attendance/save', [AttendanceController::class, 'save']);
    $r->addRoute('POST', '/attendance/mark-all-present', [AttendanceController::class, 'markAllPresent']);

    // Departamentos
    $r->addRoute('GET', '/departments', [DepartmentController::class, 'index']);
    $r->addRoute('GET', '/departments/new', [DepartmentController::class, 'new']);
    $r->addRoute('POST', '/departments/create', [DepartmentController::class, 'create']);
    $r->addRoute('GET', '/departments/{id:\d+}/edit', [DepartmentController::class, 'edit']);
    $r->addRoute('POST', '/departments/{id:\d+}/update', [DepartmentController::class, 'update']);
    $r->addRoute('GET', '/departments/{id:\d+}/delete', [DepartmentController::class, 'delete']);

    // Colaboradores / Empleados
    $r->addRoute('GET', '/employees', [PersonController::class, 'index']);
    $r->addRoute('GET', '/employees/new', [PersonController::class, 'new']);
    $r->addRoute('POST', '/employees/create', [PersonController::class, 'create']);
    $r->addRoute('GET', '/employees/{id:\d+}', [PersonController::class, 'show']);
    $r->addRoute('GET', '/employees/{id:\d+}/edit', [PersonController::class, 'edit']);
    $r->addRoute('POST', '/employees/{id:\d+}/update', [PersonController::class, 'update']);
    $r->addRoute('GET', '/employees/{id:\d+}/delete', [PersonController::class, 'delete']);

    // Estados de Asistencia (assistance_status)
    $r->addRoute('GET', '/status', [StatusController::class, 'index']);
    $r->addRoute('GET', '/status/new', [StatusController::class, 'new']);
    $r->addRoute('POST', '/status/create', [StatusController::class, 'create']);
    $r->addRoute('GET', '/status/{id:\d+}/edit', [StatusController::class, 'edit']);
    $r->addRoute('POST', '/status/{id:\d+}/update', [StatusController::class, 'update']);

    // Reportes
    $r->addRoute('GET', '/reports', [ReportController::class, 'index']);
    $r->addRoute('GET', '/reports/monthly', [ReportController::class, 'monthly']);
    $r->addRoute('GET', '/reports/export-csv', [ReportController::class, 'exportCsv']);

    // Usuarios del Sistema
    $r->addRoute('GET', '/users', [UserController::class, 'index']);
    $r->addRoute('GET', '/users/new', [UserController::class, 'new']);
    $r->addRoute('POST', '/users/create', [UserController::class, 'create']);
    $r->addRoute('GET', '/users/{id:\d+}/edit', [UserController::class, 'edit']);
    $r->addRoute('POST', '/users/{id:\d+}/update', [UserController::class, 'update']);
};
?>
