<?php

function createUser($fname, $username, $password, $email, $userlvl){
  include('connect.php');
  $userString = "INSERT INTO tbl_user VALUES(NULL, '{$fname}', '{$username}', '{$password}', '{$email}', NULL, '{$userlvl}', 'no')";
    //echo $userString;
    $userQuery = mysqli_query($link, $userString);
    if($userQuery){
      redirect_to("admin_index.php");
    }else{
  $message = "There was a problem setting up this user.";

  return $message;
}
  mysqli_close($link);
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
