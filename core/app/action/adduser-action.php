<?php
/**
* @author evilnapsis
* @brief Agregar un usuario
**/
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
					$image=$image->file_dst_name;
				}
			}
		}
		$p->image=$imag;
		$px = $p->add2();
		}else{
			Core::alert("El correo electronico ya esta en uso!");
		}

		Core::redir("./?view=users");
?>