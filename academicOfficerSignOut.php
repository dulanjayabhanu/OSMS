<?php
    session_start();
    if(isset($_SESSION["officer"])){
        $_SESSION["officer"] = null;
        session_destroy();
        echo("success");
    }

?>