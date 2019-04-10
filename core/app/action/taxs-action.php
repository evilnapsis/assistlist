<?php

if(isset($_GET["opt"])){
	if($_GET["opt"]=="addcat"){
		$cat = new TaxData();
		$cat->name = $_POST["name"];
		$cat->kind=1;
		$cat->tax_id="NULL";
		$cat->add();
		Core::redir("./?view=categories");
	}
	else if($_GET["opt"]=="updatecat"){
		$cat = TaxData::getById($_POST["id"]);
		$cat->name = $_POST["name"];
		$cat->update();
		Core::redir("./?view=categories");		
	}
	else if($_GET["opt"]=="delcat"){
		$cat = TaxData::getById($_GET["id"]);
		$cat->del();
		Core::redir("./?view=categories");
	}
}


?>