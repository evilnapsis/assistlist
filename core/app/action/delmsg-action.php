<?php
/**
* @author evilnapsis
* @brief Eliminar un post
**/
		CommentData::delById($_GET["id"]);
		Core::redir("./?view=msgs");
?>