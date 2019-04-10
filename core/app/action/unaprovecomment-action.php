<?php
/**
* @author evilnapsis
* @brief Aprobar comentarios
**/
		$cat = CommentData::getById($_GET["id"]);
		$cat->unaprove();
		Core::redir("./?view=comments");
?>