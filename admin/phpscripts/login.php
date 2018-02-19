<?php
function logIn($username, $password, $ip)
{
    require_once('connect.php');
    $username = mysqli_real_escape_string($link, $username);
    $password = mysqli_real_escape_string($link, $password);
    $password = md5($password);
    $userQuery = "SELECT * FROM tbl_user WHERE user_name='{$username}'";
    $user = mysqli_query($link, $userQuery);

    //adding attempts and date
    if (mysqli_num_rows($user)) {
        $selectUser = mysqli_fetch_array($user, MYSQLI_ASSOC);
        $id = $selectUser['user_id'];
        $user_attempt = $selectUser['user_attempt'];//from da
        if ($user_attempt >= 3) { //maximum number of attemps
            return 'locked';
        }
        if ($selectUser['user_pass'] === $password) {
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $selectUser['user_fname'];
            $_SESSION['user_date'] = $selectUser['user_date'];

            $update = "UPDATE tbl_user SET user_ip='{$ip}' WHERE user_id={$id}";
            $updatequery = mysqli_query($link, $update);
            //date and time of LAST login
            $lastTime = "UPDATE tbl_user SET user_date = NOW()  WHERE user_id = {$id}";
            $showTime = mysqli_query($link, $lastTime);
            //user attempt sql
            $resetAttemptQuery = "UPDATE tbl_user SET user_attempt = 0 WHERE user_id = {$id}";
            $resetAttempt = mysqli_query($link, $resetAttemptQuery);
            redirect_to("admin_index.php");
        } else {
            $user_attempt = 3 - $user_attempt - 1;
            $IncreaseAttemptQuery = "UPDATE tbl_user SET user_attempt = user_attempt + 1 WHERE user_id={$id}";
            $resetAttempt = mysqli_query($link, $IncreaseAttemptQuery);

            $message = "Username and or password is incorrect. <br> Please make sure your caplock key is turned off.";
            if ($user_attempt > 0) {
                $message .= "You have {$user_attempt} times more before get locked.";
            } else {
                $message = 'locked';
            }
        }
    } else {
        $message = 'username does not exist!';
    }

    return $message;
    mysqli_close($link);
}

?>
