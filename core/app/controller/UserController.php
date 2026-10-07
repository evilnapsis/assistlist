<?php
namespace App\Controller;

use Request;
use Session;
use UserData;
use ViewEngine;

class UserController {

    public function index(): void {
        $users = UserData::getAll();
        ViewEngine::render('users/index.html.twig', [
            'users' => $users
        ]);
    }

    public function new(): void {
        ViewEngine::render('users/new.html.twig');
    }

    public function create(): void {
        $name = trim(Request::post('name', ''));
        $lastname = trim(Request::post('lastname', ''));
        $username = trim(Request::post('username', ''));
        $email = trim(Request::post('email', ''));
        $password = trim(Request::post('password', ''));
        $isAdmin = (int)Request::post('is_admin', 0);

        if (empty($username) || empty($password) || empty($email)) {
            Session::flash('error', 'Usuario, correo y contraseña son obligatorios.');
            $baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
            header('Location: ' . $baseFolder . '/users/new');
            exit;
        }

        $u = new UserData();
        $u->name = $name;
        $u->lastname = $lastname;
        $u->username = $username;
        $u->email = $email;
        $u->password = password_hash($password, PASSWORD_DEFAULT);
        $u->is_admin = $isAdmin;
        $u->is_active = 1;
        $u->save();

        Session::flash('success', "Usuario '{$username}' creado correctamente.");
        $baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        header('Location: ' . $baseFolder . '/users');
        exit;
    }

    public function edit(array $vars): void {
        $id = (int)($vars['id'] ?? 0);
        $user = UserData::getById($id);
        if (!$user) {
            Session::flash('error', 'Usuario no encontrado.');
            $baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
            header('Location: ' . $baseFolder . '/users');
            exit;
        }

        ViewEngine::render('users/edit.html.twig', [
            'user' => $user
        ]);
    }

    public function update(array $vars): void {
        $id = (int)($vars['id'] ?? 0);
        $user = UserData::getById($id);
        if (!$user) {
            Session::flash('error', 'Usuario no encontrado.');
            $baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
            header('Location: ' . $baseFolder . '/users');
            exit;
        }

        $user->name = trim(Request::post('name', $user->name));
        $user->lastname = trim(Request::post('lastname', $user->lastname));
        $user->email = trim(Request::post('email', $user->email));
        $user->is_admin = (int)Request::post('is_admin', 0);
        $user->is_active = (int)Request::post('is_active', 1);

        $newPass = trim(Request::post('password', ''));
        if (!empty($newPass)) {
            $user->password = password_hash($newPass, PASSWORD_DEFAULT);
        }

        $user->save();

        Session::flash('success', "Usuario '{$user->username}' actualizado con éxito.");
        $baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        header('Location: ' . $baseFolder . '/users');
        exit;
    }
}
?>
