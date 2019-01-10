<?php

    session_start();

    if ($_SESSION['Email']) {

        echo "You are logged in! ";

    } else {

        echo "You are logged out.";

        header("location: Signup-login.php");
    }



?>