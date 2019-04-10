<?php
/**
* @author evilnapsis
* @brief Eliminar una imagen
**/
		ImageData::delById($_GET["id"]);
		Core::redir("./?view=galery");
?>