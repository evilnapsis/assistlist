<?php

unset($_SESSION["user_id"]);
session_destroy();

Core::redir("./");

?>