<?php

if(!empty($_POST)){
	$found = AssistanceData::getByPD($_POST["person_id"],$_POST["date_at"]);
	if($found==null && $_POST["kind_id"]!=""){
	$assis = new AssistanceData();
	$assis->person_id = $_POST["person_id"];
	$assis->kind_id = $_POST["kind_id"];
	$assis->date_at = $_POST["date_at"];
	$assis->user_id = $_SESSION["user_id"];
	$assis->add();
	}else if($found=!null&&$_POST["kind_id"]!=""){
	$found = AssistanceData::getByPD($_POST["person_id"],$_POST["date_at"]);
	
	$found->kind_id = $_POST["kind_id"];
	$found->update();

	}else if($_POST["kind_id"]==""){
	$found = AssistanceData::getByPD($_POST["person_id"],$_POST["date_at"]);
		$found->del();
	}
}

?>