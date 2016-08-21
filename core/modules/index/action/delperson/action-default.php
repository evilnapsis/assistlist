<?php
$user = PersonData::getById($_GET["id"]);
$user->del();
print "<script>window.location='index.php?view=persons';</script>";

?>