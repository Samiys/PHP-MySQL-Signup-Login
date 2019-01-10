<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "root";

if (array_key_exists('Email', $_POST) OR array_key_exists('Password', $_POST)) {

// Create connection
$conn = mysqli_connect($servername, $username, $password, 'users');
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$username = mysqli_real_escape_string($conn, $_POST['Email']);
$password = mysqli_real_escape_string($conn, $_POST['Password']);

    if ($_POST['Email'] == '') {

        echo "Email address is required";

    } else if ($_POST['Password'] == '') {

        echo "Password is required";

    } else {

        $query = "SELECT * FROM `user` WHERE Email = '" . $username . "'";

        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) >= 1) {

            echo "That email address already exists.";

        } else {

            $query = "INSERT INTO user (Email, Password) VALUES ('$username', '$password')";

            //Another Method of INSERTING
            /*$query = "INSERT INTO `user` (`Email`, `Password`) VALUES ('".mysqli_real_escape_string($conn, $_POST['Email'])."',
            '".mysqli_real_escape_string($conn, $_POST['Password'])."')";*/

            if (mysqli_query($conn, $query)) {

                $_SESSION['Email'] = $_POST['Email'];

                header("location: session.php");

            } else {

                //This will show where the error is
                echo "Error: " . $query . "<br>" . mysqli_error($conn);

                echo "<p>There was a problem signing you up - please try again later.</p>";

            }
        }
    }

}

?>

<form method="post">

 <input name="Email" type="text" placeholder="Email address">
    <input name="Password" type="password" placeholder="Password">

        <input type="submit" value="Sign up">

</form>