<?php

// Generating hash of the password "userpassword"
$hash = password_hash("userpassword", PASSWORD_DEFAULT);

echo $hash;
echo "<br><br>";


// Using password_verify() from php to check if "userpassword" matches the hash.
if (password_verify('userpassword', $hash)) {

    echo 'Password is valid!';

} else {

    echo 'Invalid password.';
}

?>