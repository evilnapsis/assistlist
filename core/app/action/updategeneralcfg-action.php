<?php
/**
* @author evilnapsis
* @brief Actualizar la configuracion General
**/
		foreach ($_POST as $k => $v) {
			$key = ConfigData::getByKey($k);
			$key->description = $v;
			$key->update();
		}
		Core::redir("./?view=generalcfg");
?>