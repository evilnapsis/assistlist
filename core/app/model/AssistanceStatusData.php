<?php

#[\AllowDynamicProperties]
class AssistanceStatusData extends LbModel {
	public static $tablename = "assistance_status";

	public $id;
	public $code;
	public $name;
	public $color;
	public $badge_class;
	public $icon;
	public $counts_as_present;
	public $is_active;
	public $order_num;

	public function __construct(){
		$this->code = "present";
		$this->name = "Presente";
		$this->color = "#198754";
		$this->badge_class = "bg-success";
		$this->icon = "bi-check-circle-fill";
		$this->counts_as_present = 1;
		$this->is_active = 1;
		$this->order_num = 1;
	}

	public static function getById($id){
		return static::find($id);
	}

	public static function getByCode(string $code){
		$db = static::getDb();
		$stmt = $db->prepare("SELECT * FROM " . static::$tablename . " WHERE code = :code LIMIT 1");
		$stmt->execute(['code' => $code]);
		$stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, static::class);
		return $stmt->fetch() ?: null;
	}

	public static function getAllActive(): array {
		$db = static::getDb();
		$stmt = $db->query("SELECT * FROM " . static::$tablename . " WHERE is_active = 1 ORDER BY order_num ASC, id ASC");
		return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, static::class);
	}

	public static function getAll(): array {
		$db = static::getDb();
		$stmt = $db->query("SELECT * FROM " . static::$tablename . " ORDER BY order_num ASC, id ASC");
		return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, static::class);
	}
}
?>
