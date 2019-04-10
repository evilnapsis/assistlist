<?php
/**
* @author evilnapsis
* @brief Actualizar una pagina
**/
		$p = PostData::getById($_POST["id"]);
		$p->title = $_POST["title"];
		$p->content = $_POST["content"];
		if(isset($_POST["is_public"])){ $p->is_public=1;}else{ $p->is_public=0;}
		if(isset($_POST["accept_comments"])){ $p->accept_comments=1;}else{ $p->accept_comments=0;}
		if(isset($_POST["show_image"])){ $p->show_image=1;}else{ $p->show_image=0;}
		$p->update();

		Core::redir("./?view=editpage&id=".$_POST["id"]);
?>