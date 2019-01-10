<?php

    //Set cookie to be logged in all time
    setcookie("customerId", "1234", time() + 60 * 60 + 24); //* 365 for full year

    //Delete cookie
   // setcookie("customerId", "", time() - 60 * 60); //To update cooking change sign from -ve to +ve for future

    //Update the value of cookie
    $_COOKIE["customerId"] = "test";

    echo $_COOKIE["customerId"];



?>