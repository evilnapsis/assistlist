<?php
/**
* @author evilnapsis
* @brief Eliminar una pagina
**/
		PostData::delById($_GET["id"]);
		Core::redir("./?view=pages");
?>