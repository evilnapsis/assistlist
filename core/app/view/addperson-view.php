<?php

if(count($_POST)>0){
	$user = new PersonData();
	$user->name = $_POST["name"];
	$user->lastname = $_POST["lastname"];
	$user->address = $_POST["address"];
	$user->email = $_POST["email"];
	$user->phone = $_POST["phone"];

	$user->c1_fullname = $_POST["c1_fullname"];
	$user->c1_address = $_POST["c1_address"];
	$user->c1_phone = $_POST["c1_phone"];
	$user->c1_note = $_POST["c1_note"];

	$user->user_id = $_SESSION["user_id"];


	$u = $user->add();


print "<script>window.location='index.php?view=persons';</script>";


}


?>