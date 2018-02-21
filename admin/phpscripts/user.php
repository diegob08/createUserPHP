<?php

function createUser($fname, $username, $password, $email)
{
    include('connect.php');
    //Encrypted the password using MD5
    $userString = "INSERT INTO tbl_user(user_fname,user_name,user_pass,user_email) VALUES('{$fname}', '{$username}', MD5('{$password}'), '{$email}')";
    $userQuery = mysqli_query($link, $userString);
    mysqli_close($link);
    return $userQuery;
}


//reducing here a function to be less lines of code
function randomPassword ($length = 10) {
    $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr( str_shuffle( $characters ),1, $length );
    return $password;
}

function sendEmail($email, $username, $password)
{

    $to = $email;
    $subject = "Welcome to the best movies platform";
    $body = "Username: " . $username . "\r\n";
    $body .= "Password: " . $password . "\r\n";
    $body .= "Login URL: http://localhost/admin/admin_createuser.php"; //would work with any email configured
    $headers = 'From: noreply@test.com' . "\r\n";

    echo $body;
    mail($to, $subject, $body, $headers);
}
?>
