<?php
namespace App\Controller;

use AssistanceStatusData;
use Request;
use Session;
use ViewEngine;

class StatusController {

    public function index(): void {
        $statuses = AssistanceStatusData::getAll();
        ViewEngine::render('status/index.html.twig', [
            'statuses' => $statuses
        ]);
    }

    public function new(): void {
        ViewEngine::render('status/new.html.twig');
    }

    public function create(): void {
        $name = trim(Request::post('name', ''));
        $code = strtolower(trim(Request::post('code', '')));
        $color = trim(Request::post('color', '#198754'));
        $icon = trim(Request::post('icon', 'bi-check-circle-fill'));
        $badgeClass = trim(Request::post('badge_class', 'bg-success'));
        $countsAsPresent = (int)Request::post('counts_as_present', 1);
        $orderNum = (int)Request::post('order_num', 1);

        if (empty($name) || empty($code)) {
            Session::flash('error', 'El nombre y código son requeridos.');
            $baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
            header('Location: ' . $baseFolder . '/status/new');
            exit;
        }

        $s = new AssistanceStatusData();
        $s->name = $name;
        $s->code = $code;
        $s->color = $color;
        $s->icon = $icon;
        $s->badge_class = $badgeClass;
        $s->counts_as_present = $countsAsPresent;
        $s->order_num = $orderNum;
        $s->is_active = 1;
        $s->save();

        Session::flash('success', "Estado de asistencia '{$name}' creado con éxito.");
        $baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        header('Location: ' . $baseFolder . '/status');
        exit;
    }

    public function edit(array $vars): void {
        $id = (int)($vars['id'] ?? 0);
        $status = AssistanceStatusData::getById($id);
        if (!$status) {
            Session::flash('error', 'Estado no encontrado.');
            $baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
            header('Location: ' . $baseFolder . '/status');
            exit;
        }

        ViewEngine::render('status/edit.html.twig', [
            'status' => $status
        ]);
    }

    public function update(array $vars): void {
        $id = (int)($vars['id'] ?? 0);
        $status = AssistanceStatusData::getById($id);
        if (!$status) {
            Session::flash('error', 'Estado no encontrado.');
            $baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
            header('Location: ' . $baseFolder . '/status');
            exit;
        }

        $status->name = trim(Request::post('name', $status->name));
        $status->color = trim(Request::post('color', $status->color));
        $status->icon = trim(Request::post('icon', $status->icon));
        $status->badge_class = trim(Request::post('badge_class', $status->badge_class));
        $status->counts_as_present = (int)Request::post('counts_as_present', 1);
        $status->order_num = (int)Request::post('order_num', $status->order_num);
        $status->is_active = (int)Request::post('is_active', 1);
        $status->save();

        Session::flash('success', "Estado '{$status->name}' actualizado correctamente.");
        $baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        header('Location: ' . $baseFolder . '/status');
        exit;
    }
}
?>
