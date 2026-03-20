<?php
class PersonData
{
	public static $tablename = "person";

	public $id;
	public $title;
	public $name;
	public $lastname;
	public $address;
	public $phone;
	public $email;
	public $image;
	public $password;
	public $is_public;
	public $created_at;
	public $user_id;
	public $c1_fullname;
	public $c1_address;
	public $c1_phone;
	public $c1_note;
	public $last_active_at;
	public $c2_fullname;
	public $c2_address;
	public $c2_phone;
	public $c2_note;
	public $is_active;

	public function __construct()
	{
		$this->title = "";
		$this->email = "";
		$this->image = "";
		$this->password = "";
		$this->is_public = "0";
		$this->created_at = "NOW()";
	}



	public function add()
	{
		$sql = "insert into " . self::$tablename . " (name,lastname,address,phone,email,user_id,created_at,c1_fullname,c1_address,c1_phone,c1_note) ";
		$sql .= "value (\"$this->name\",\"$this->lastname\",\"$this->address\",\"$this->phone\",\"$this->email\",$this->user_id,$this->created_at,\"$this->c1_fullname\",\"$this->c1_address\",\"$this->c1_phone\",\"$this->c1_note\")";
		return Executor::doit($sql);
	}

	public static function delById($id)
	{
		$sql = "delete from " . self::$tablename . " where id=$id";
		Executor::doit($sql);
	}
	public function del()
	{
		$sql = "delete from " . self::$tablename . " where id=$this->id";
		Executor::doit($sql);
	}
	// partiendo de que ya tenemos creado un objecto PersonData previamente utilizamos el contexto
	public function update_active()
	{
		$sql = "update " . self::$tablename . " set last_active_at=NOW() where id=$this->id";
		$this->last_active_at = date("Y-m-d H:i:s"); // Update current object too
		Executor::doit($sql);
	}


	public function update()
	{
		$sql = "update " . self::$tablename . " set name=\"$this->name\",lastname=\"$this->lastname\",address=\"$this->address\",phone=\"$this->phone\",email=\"$this->email\",c1_fullname=\"$this->c1_fullname\",c1_address=\"$this->c1_address\",c1_phone=\"$this->c1_phone\",c1_note=\"$this->c1_note\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id)
	{
		$sql = "select * from " . self::$tablename . " where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0], new PersonData());
	}


	public static function getAll()
	{
		$sql = "select * from " . self::$tablename . " order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new PersonData());
	}

	public static function count()
	{
		$sql = "select count(*) as c from " . self::$tablename;
		$query = Executor::doit($sql);
		return $query[0]->fetch_assoc()["c"];
	}


	public static function getAllUnActive()
	{
		$sql = "select * from client where last_active_at<=date_sub(NOW(),interval 3 second)";
		$query = Executor::doit($sql);
		return Model::many($query[0], new PersonData());
	}


	public function getUnreads()
	{
		return MessageData::getUnreadsByClientId($this->id);
	}


	public static function getLike($q)
	{
		$sql = "select * from " . self::$tablename . " where title like '%$q%' or email like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0], new PersonData());
	}


}

?>