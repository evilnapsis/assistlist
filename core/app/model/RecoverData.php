<?php
class RecoverData {
	public static $tablename = "recover";


	public function RecoverData(){
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->password = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into recover (user_id,code,created_at) ";
		$sql .= "value (\"$this->user_id\",\"$this->code\",$this->created_at)";
		return Executor::doit($sql);
	}

	public static function deleteFromUserId($id){
		$sql = "delete from ".self::$tablename." where user_id=$id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

// partiendo de que ya tenemos creado un objecto RecoverData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set nick=\"$this->nick\",name=\"$this->name\",mail=\"$this->mail\",image=\"$this->image\",password=\"$this->password\",status_id=".$this->status->id.",usertype_id=".$this->usertype->id.",is_admin=$this->is_admin,is_verified=$this->is_verified,created_at=$this->created_at where id=$this->id";
		Executor::doit($sql);
	}

	public function used(){
		$sql = "update ".self::$tablename." set is_used=1 where id=$this->id";
		Executor::doit($sql);
	}


	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new RecoverData());
	}

	public static function getUnUsedByUserId($id){
		$sql = "select * from ".self::$tablename." where is_used=0 and user_id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new RecoverData());
	}


	public static function getLogin($email,$password){
		$sql = "select * from ".self::$tablename." where email=\"$email\" and password=\"$password\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new RecoverData());
	}


	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new RecoverData());

	}



	
	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new RecoverData());
	}


}

?>