<?php
	require_once('phpscripts/config.php');
	//confirm_logged_in();

	if (isset($_POST['submit'])) {
    $fname = trim($_POST['fname']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);
    $result = createUser($fname, $username, $password, $email);

    if ($result) {
        sendEmail($email, $username,$password);
        redirect_to("admin_index.php");
    } else {
        $message = "There was a problem setting up this user.";
    }
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Welcome to your admin panel</title>
</head>
<body>
	<h1>Welcome comapny name to your create user page</h1>

  <?php if(!empty($message)){echo $message;} ?>
  	<form action="admin_createuser.php" method="post">
      <label>First Name</label>
      <input type="text" name="fname" value=""><br></br>

      <label>Username</label>
      <input type="text" name="username" value=""><br></br>

      <label>Password</label>
			<p>Generated Password is: <code><b><?php echo randomPassword(); ?></b></code><br>Please copy and paste into
        the following field</p>
      <input type="password" name="password" value=""><br></br>

      <label>Email</label>
      <input type="text" name="email" value=""><br></br>

      <label>User Level</label>
      <select name="userlvl">
        <option value="">Please select a user level</option>
        <option value="2">Web Admin</option>
        <option value="1">Web Master</option>
      </select><br><br>
      <input type="submit" name="submit" value="Create user"><br><br>

    </form>
</body>
</html>
