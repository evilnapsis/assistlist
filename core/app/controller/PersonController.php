<?php
namespace App\Controller;

use AssistanceData;
use DepartmentData;
use PersonData;
use Request;
use Session;
use ViewEngine;

class PersonController {

    public function index(): void {
        $departmentId = Request::get('department_id') ? (int)Request::get('department_id') : null;
        $employees = $departmentId ? PersonData::getAllByDepartment($departmentId) : PersonData::getAllActive();
        $departments = DepartmentData::getAllActive();

        ViewEngine::render('persons/index.html.twig', [
            'employees'     => $employees,
            'departments'   => $departments,
            'selected_dept' => $departmentId
        ]);
    }

    public function new(): void {
        $departments = DepartmentData::getAllActive();
        ViewEngine::render('persons/new.html.twig', [
            'departments' => $departments
        ]);
    }

    public function create(): void {
        $name = trim(Request::post('name', ''));
        $lastname = trim(Request::post('lastname', ''));
        $code = trim(Request::post('code', ''));
        $email = trim(Request::post('email', ''));
        $phone = trim(Request::post('phone', ''));
        $jobTitle = trim(Request::post('job_title', 'Colaborador'));
        $deptId = Request::post('department_id') ? (int)Request::post('department_id') : null;
        $dni = trim(Request::post('dni_cif', ''));
        $address = trim(Request::post('address', ''));
        $hireDate = Request::post('hire_date') ?: date('Y-m-d');
        $salary = (float)Request::post('salary', 0);

        if (empty($name) || empty($lastname)) {
            Session::flash('error', 'El nombre y apellido son obligatorios.');
            $baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
            header('Location: ' . $baseFolder . '/employees/new');
            exit;
        }

        if (empty($code)) {
            $code = 'EMP-' . rand(100, 999);
        }

        $p = new PersonData();
        $p->code = $code;
        $p->name = $name;
        $p->lastname = $lastname;
        $p->dni_cif = $dni;
        $p->email = $email;
        $p->phone = $phone;
        $p->address = $address;
        $p->job_title = $jobTitle;
        $p->department_id = $deptId;
        $p->hire_date = $hireDate;
        $p->salary = $salary;
        $p->is_active = 1;
        $p->save();

        Session::flash('success', "Empleado '{$p->getFullname()}' registrado con éxito.");
        $baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        header('Location: ' . $baseFolder . '/employees');
        exit;
    }

    public function show(array $vars): void {
        $id = (int)($vars['id'] ?? 0);
        $emp = PersonData::getById($id);
        if (!$emp) {
            Session::flash('error', 'Empleado no encontrado.');
            $baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
            header('Location: ' . $baseFolder . '/employees');
            exit;
        }

        $history = AssistanceData::getHistoryByPerson($id, 30);

        ViewEngine::render('persons/show.html.twig', [
            'emp'     => $emp,
            'history' => $history
        ]);
    }

    public function edit(array $vars): void {
        $id = (int)($vars['id'] ?? 0);
        $emp = PersonData::getById($id);
        if (!$emp) {
            Session::flash('error', 'Empleado no encontrado.');
            $baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
            header('Location: ' . $baseFolder . '/employees');
            exit;
        }

        $departments = DepartmentData::getAllActive();

        ViewEngine::render('persons/edit.html.twig', [
            'emp'         => $emp,
            'departments' => $departments
        ]);
    }

    public function update(array $vars): void {
        $id = (int)($vars['id'] ?? 0);
        $emp = PersonData::getById($id);
        if (!$emp) {
            Session::flash('error', 'Empleado no encontrado.');
            $baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
            header('Location: ' . $baseFolder . '/employees');
            exit;
        }

        $emp->code = trim(Request::post('code', $emp->code));
        $emp->name = trim(Request::post('name', $emp->name));
        $emp->lastname = trim(Request::post('lastname', $emp->lastname));
        $emp->dni_cif = trim(Request::post('dni_cif', ''));
        $emp->email = trim(Request::post('email', ''));
        $emp->phone = trim(Request::post('phone', ''));
        $emp->address = trim(Request::post('address', ''));
        $emp->job_title = trim(Request::post('job_title', $emp->job_title));
        $emp->department_id = Request::post('department_id') ? (int)Request::post('department_id') : null;
        $emp->hire_date = Request::post('hire_date') ?: $emp->hire_date;
        $emp->salary = (float)Request::post('salary', $emp->salary);
        $emp->is_active = (int)Request::post('is_active', 1);
        $emp->save();

        Session::flash('success', "Empleado '{$emp->getFullname()}' actualizado con éxito.");
        $baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        header('Location: ' . $baseFolder . '/employees');
        exit;
    }

    public function delete(array $vars): void {
        $id = (int)($vars['id'] ?? 0);
        $emp = PersonData::getById($id);
        if ($emp) {
            $emp->is_active = 0;
            $emp->save();
            Session::flash('info', "El colaborador '{$emp->getFullname()}' fue desactivado.");
        }
        $baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        header('Location: ' . $baseFolder . '/employees');
        exit;
    }
}
?>
