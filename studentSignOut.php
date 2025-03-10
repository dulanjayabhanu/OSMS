<?php
    session_start();
    if(isset($_SESSION["student"])){
        $_SESSION["student"] = null;
        session_destroy();
        echo("success");
    }

?>