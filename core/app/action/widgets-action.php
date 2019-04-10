<?php

if(isset($_GET["opt"])){
	if($_GET["opt"]=="add"){
		$cat = new WidgetData();
		$cat->title = $_POST["title"];
		$cat->func = $_POST["func"];
		$cat->params = $_POST["params"];
		$cat->ord = $_POST["ord"];
		$cat->add();
		Core::redir("./?view=widgets");
	}
	else if($_GET["opt"]=="update"){
		$cat = WidgetData::getById($_POST["id"]);
		$cat->title = $_POST["title"];
		$cat->func = $_POST["func"];
		$cat->params = $_POST["params"];
		$cat->status = $_POST["status"];
		$cat->ord = $_POST["ord"];
		$cat->update();
		Core::redir("./?view=widgets");		
	}
	else if($_GET["opt"]=="del"){
		$cat = WidgetData::getById($_GET["id"]);
		$cat->del();
		Core::redir("./?view=widgets");
	}
}


?>