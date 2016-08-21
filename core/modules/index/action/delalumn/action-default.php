<?php

$teams = AlumnTeamData::getAllByAlumnId($_GET["id"]);
foreach ($teams as $t) {
	$t->del();
}

$alumn = AlumnData::getById($_GET["id"]);
$alumn->del();

Core::redir("./?view=team&id=$_GET[tid]");
?>