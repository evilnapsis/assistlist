<?php
namespace App\Controller;

use DepartmentData;
use Request;
use Session;
use ViewEngine;

class DepartmentController {

    public function index(): void {
        $departments = DepartmentData::getAll();
        ViewEngine::render('departments/index.html.twig', [
            'departments' => $departments
        ]);
    }

    public function new(): void {
        ViewEngine::render('departments/new.html.twig');
    }

    public function create(): void {
        $name = trim(Request::post('name', ''));
        $code = strtoupper(trim(Request::post('code', '')));
        $manager = trim(Request::post('manager_name', ''));
        $desc = trim(Request::post('description', ''));

        if (empty($name) || empty($code)) {
            Session::flash('error', 'El código y nombre del departamento son obligatorios.');
            $baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
            header('Location: ' . $baseFolder . '/departments/new');
            exit;
        }

        $dept = new DepartmentData();
        $dept->code = $code;
        $dept->name = $name;
        $dept->manager_name = $manager;
        $dept->description = $desc;
        $dept->is_active = 1;
        $dept->save();

        Session::flash('success', "Departamento '{$name}' creado con éxito.");
        $baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        header('Location: ' . $baseFolder . '/departments');
        exit;
    }

    public function edit(array $vars): void {
        $id = (int)($vars['id'] ?? 0);
        $dept = DepartmentData::getById($id);
        if (!$dept) {
            Session::flash('error', 'Departamento no encontrado.');
            $baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
            header('Location: ' . $baseFolder . '/departments');
            exit;
        }

        ViewEngine::render('departments/edit.html.twig', [
            'dept' => $dept
        ]);
    }

    public function update(array $vars): void {
        $id = (int)($vars['id'] ?? 0);
        $dept = DepartmentData::getById($id);
        if (!$dept) {
            Session::flash('error', 'Departamento no encontrado.');
            $baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
            header('Location: ' . $baseFolder . '/departments');
            exit;
        }

        $dept->code = strtoupper(trim(Request::post('code', $dept->code)));
        $dept->name = trim(Request::post('name', $dept->name));
        $dept->manager_name = trim(Request::post('manager_name', ''));
        $dept->description = trim(Request::post('description', ''));
        $dept->is_active = (int)Request::post('is_active', 1);
        $dept->save();

        Session::flash('success', "Departamento '{$dept->name}' actualizado correctamente.");
        $baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        header('Location: ' . $baseFolder . '/departments');
        exit;
    }

    public function delete(array $vars): void {
        $id = (int)($vars['id'] ?? 0);
        $dept = DepartmentData::getById($id);
        if ($dept) {
            $dept->is_active = 0;
            $dept->save();
            Session::flash('info', "El departamento '{$dept->name}' ha sido desactivado.");
        }
        $baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        header('Location: ' . $baseFolder . '/departments');
        exit;
    }
}
?>
