<?php

$error = "";

    //Getting logout key to logout user.
    if (array_key_exists("logout", $_GET)) {

        unset($_SESSION);
        setcookie("id", "", time() - 60 *60);
        $_COOKIE["id"] = "";

        //If session and cookie ids exists then keep user logged in and redirect to "loggedinpage".
    } else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR array_key_exists("id", $_COOKIE) AND $_COOKIE['id']) {

        header("Location: loggedinpage.php");
    }

    if (array_key_exists("submit", $_POST)) {

    $servername = "localhost";
    $username = "root";
    $password = "root";

    if (array_key_exists('email', $_POST) OR array_key_exists('password', $_POST)) {

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, 'secretdi');
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    $username = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    //Email and Password verification
    if ($_POST['email'] == '') {

        session_start();

    $error .= "Email address is required";

    } else if ($_POST['password'] == '') {

    $error .= "password is required";
    }

    //Errors in verification
    if ($error!= "") {

    $error = "<p>There were error(s) in your form:</p>".$error;

    } else {

        if ($_POST['signUp'] == '1') {


            //Verifying if Email already exists
            $query = "SELECT * FROM `users` WHERE email = '" . $username . "'";

            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) >= 1) {

                echo "That email address already exists.";

            } else {

                //Inserting new email and password in database.
                $query = "INSERT INTO `users` (`email`, `password`) VALUES ('$username', '$password')";

                //Verifying the insertion.
                if (mysqli_query($conn, $query)) {

                    //Creating hash for password.
                    $query = "UPDATE `users` SET password = '" . md5(md5(mysqli_insert_id($conn)) . $_POST['password']) . "' WHERE id = " . mysqli_insert_id($conn) . " LIMIT 1";

                    mysqli_query($conn, $query);

                    //Creating session for staying logged in.
                    $_SESSION['id'] = mysqli_insert_id($conn);

                    if ($_POST['stayLoggedIn'] == '1') {

                        //Setting cookie to hold data
                        setcookie("id", mysqli_insert_id($conn), time() + 60 * 60 * 24 * 365);

                    }

                    header("Location: loggedinpage.php");


                } else {

                    //This will show where the error is.
                    echo "Error: " . $query . "<br>" . mysqli_error($conn);

                    //Verifying if there is a problem.
                    echo "<p>There was a problem signing you up - please try again later.</p>";
                }

            }
        } else {

            //Doing query to match entered email with the saved email data.
             $query = "SELECT * FROM users WHERE email = '$username'";

             $result = mysqli_query($conn, $query);

             //Fetching related array from $result and storing in $row.
             $row = mysqli_fetch_array($result);

             if (isset($row) ) {

                 //Matching the password entered with the password stored.
                 $hashedPassword = md5(md5($row['id']).$_POST['password']);

                 if ($hashedPassword == $row['password']) {

                     $_SESSION['id'] = $row['id'];

                     if ($_POST['stayLoggedIn'] == '1') {

                         //Setting cookie to hold data
                         setcookie("id", $row['id'], time() + 60 * 60 * 24 * 365);


                     }
                     //Redirecting to "loggedinpage" page.
                     header("Location: loggedinpage.php");

                 } else {

                     echo $error = "The email/password combination not found";
                 }

             } else {

                  echo $error = "The email/password combination not found";
             }
        }
    }

}

?>


<div id="error" <?php echo $error ?> </div>


<form method="post">

    <input type="email" name="email" placeholder="Your Email">

    <input type="password" name="password" placeholder="Password">

    <input type="checkbox" name="stayLoggedIn" value=1>

    <input type="hidden" name="signUp" value="1">

    <input type="submit" name="submit" value="Sign Up!">

</form>

<form method="post">

    <input type="email" name="email" placeholder="Your Email">

    <input type="password" name="password" placeholder="Password">

    <input type="checkbox" name="stayLoggedIn" value=1>

    <input type="hidden" name="signUp " value="0">

    <input type="submit" name="submit" value="Log In !">

</form>
