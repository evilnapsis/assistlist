<?php

#[\AllowDynamicProperties]
class DepartmentData extends LbModel {
	public static $tablename = "department";

	public $id;
	public $code;
	public $name;
	public $description;
	public $manager_name;
	public $is_active;
	public $created_at;

	// Relacionales / Calculados
	public $total_employees = 0;

	public function __construct(){
		$this->code = "";
		$this->name = "";
		$this->description = "";
		$this->manager_name = "";
		$this->is_active = 1;
		$this->created_at = date('Y-m-d H:i:s');
	}

	public static function getById($id){
		return static::find($id);
	}

	public static function getAllActive(): array {
		$db = static::getDb();
		$stmt = $db->query("SELECT d.*, 
		                    (SELECT COUNT(*) FROM person p WHERE p.department_id = d.id AND p.is_active = 1) AS total_employees 
		                    FROM " . static::$tablename . " d 
		                    WHERE d.is_active = 1 
		                    ORDER BY d.name ASC");
		return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, static::class);
	}

	public static function getAll(): array {
		$db = static::getDb();
		$stmt = $db->query("SELECT d.*, 
		                    (SELECT COUNT(*) FROM person p WHERE p.department_id = d.id AND p.is_active = 1) AS total_employees 
		                    FROM " . static::$tablename . " d 
		                    ORDER BY d.id ASC");
		return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, static::class);
	}
}
?>
