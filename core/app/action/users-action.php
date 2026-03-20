<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
		$p = new UserData();
		$continuar = true;
		if($_POST["email"]!=""){
			if(UserData::getByEmail($_POST["email"])!=null){ $continuar=false; }

		}
		if($continuar){
		$p->name = $_POST["name"];
		$p->username = $_POST["username"];
		$p->email = $_POST["email"];
		$p->password = sha1(md5($_POST["password"]));
		$p->kind = $_POST["kind_id"];
		$imag="";
		if(isset($_FILES["image"])){
			$image=new Upload($_FILES["image"]);
			if($image->uploaded){
				$image->Process("storage/images/");
				if($image->processed){
					$imag=$image->file_dst_name;
				}
			}
		}
		$p->image=$imag;
		$px = $p->add2();
		}else{
			Core::alert("El correo electronico ya esta en uso!");
		}

		Core::redir("./?view=users&opt=all");

}
else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){

		$p = UserData::getById($_POST["id"]);
		$p->name = $_POST["name"];
		$p->lastname = $_POST["lastname"];
		$p->username = $_POST["username"];
		$p->email = $_POST["email"];
		$p->password = $_POST["password"];
		$p->kind = $_POST["kind"];
		$p->status = isset($_POST["status"])?1:0;
		
		$p->update();

		if(isset($_FILES["image"])){
			$image=new Upload($_FILES["image"]);
			if($image->uploaded){
				$image->Process("storage/images/");
				if($image->processed){
					$p = UserData::getById($_POST["id"]);
					$p->image=$image->file_dst_name;
					$p->update_img();
				}
			}
		}

		if($_POST["password"]!=""){
		$p = UserData::getById($_POST["id"]);
		$p->password= sha1(md5($_POST["password"]));
		$p->update_passwd();

		}

		Core::redir("./?view=users&opt=edit&id=".$_POST["id"]);

}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
$p = UserData::getById($_GET["id"]);
$p->del();
Core::redir("./?view=users&opt=all");
}
?>