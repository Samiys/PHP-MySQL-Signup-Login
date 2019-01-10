<?php

 session_start();

 if (array_key_exists("id", $_COOKIE)) {

        $_SESSION['id'] = $_COOKIE['id'];

}

 if (array_key_exists("id", $_SESSION)) {

     echo "Logged In! <a href='notes-api.php?logout=1'>Log out</a>";

 } else {

     header("location: notes-api.php");

 }


?>
