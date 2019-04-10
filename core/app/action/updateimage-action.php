<?php
/**
* @author evilnapsis
* @brief Actualizar los datos de una imagen
**/
		$p = ImageData::getById($_POST["id"]);
		$p->title = $_POST["title"];
		$p->description = $_POST["description"];
		if(isset($_POST["is_public"])){ $p->is_public=1;}
		$p->user_id = 2;
		$p->update();


		Core::redir("./?view=editimage&id=".$_POST["id"]);
?>