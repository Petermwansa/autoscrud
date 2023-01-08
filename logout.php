<?php
//this is the simple code for logout ;)
    session_start();
    session_destroy();
    header("Location: login.php");
?>
