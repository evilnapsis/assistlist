<?php
/**
* @author evilnapsis
* @brief Eliminar un post
**/
		PostData::delById($_GET["id"]);
		Core::redir("./?view=posts");
?>