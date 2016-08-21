<?php

if(!empty($_POST)){
	$user = new UserData();
	$user->name = $_POST["name"];
	$user->lastname = $_POST["lastname"];
	$user->username = $_POST["username"];
	$user->password = sha1(md5($_POST["password"]));
	$user->add();
	Core::alert("Registro Exitoso!, ya puedes a iniciar sesion con tu nombre de usuario y password.");
	Core::redir("./");
}


?>