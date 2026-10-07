<?php
namespace App\Service;

/**
 * Clase AuthService
 * Servicio de autenticación para AssistList 2
 */
class AuthService {
    public function login(string $username, string $password): bool {
        $user = \UserData::getLogin($username, $password);
        
        if ($user) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->getFullname() ?: $user->username;
            $_SESSION['username'] = $user->username;
            $_SESSION['is_admin'] = (int)$user->is_admin;
            return true;
        }
        
        return false;
    }

    public function logout(): void {
        \Session::init();
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['username']);
        unset($_SESSION['is_admin']);
        session_destroy();
    }

    public static function check(): bool {
        return isset($_SESSION['user_id']);
    }

    public static function user(): ?\UserData {
        if (!self::check()) return null;
        return \UserData::getById($_SESSION['user_id']);
    }
}
?>
