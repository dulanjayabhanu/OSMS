<?php
    session_start();
    if(isset($_SESSION["adminUser"])){
        $_SESSION["adminUser"] = null;
        session_destroy();
        echo("success");
    }

?>