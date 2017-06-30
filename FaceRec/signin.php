<?php
  $uname="";
  $userid="";
  $password="";
  $message="";
  $t1=empty($_POST['userid']);
  $t2=empty($_POST['password']);
  $con=mysql_connect('localhost','root','admin');
  mysql_select_db("criminal_db",$con);
if (isset($_POST['signin'])) {
    $userid=$_POST['userid'];
  $password=$_POST['password'];
  if(!$t1&&!$t2){
  $result=@mysql_query("SELECT * FROM admins");
  while ($row=mysql_fetch_array($result)) {
    if($row['username']==$userid&&$row['password']==$password){
    session_start();
    $_SESSION['uname']=$row['username'];
    header("Location:homepage.php");
  }
  else
    {$message="unauthorized user!!";}
  }
  
}
elseif ($t1&&!$t2) {
  $message="Please enter the User Id before logging in";
}
elseif (!$t1&&$t2) {
  $message="Please enter the Password before logging in";
}
elseif($t1&&$t2)
 {
  $message="Please fill all the details before logging in";
 }
}

?>

<html>
<head>
	<title>Sign In</title>
<style>
	#center{
	position:absolute;
	top:28%;
	height:50%;
	width:40%;
	left:30%;
	background-image: url('images/formbg.jpg');
	background-size: cover;
	background-position:100% center;
	background-repeat:no-repeat;
	}

	#right{
	position:absolute;
	top:3%;
	height:50%;
	width:20%;
	left:75%;
	}
</style>
</head>
<body>
	<div id="right">
	<a href="index.php"><img src="images/homepage.jpg"></a>
	</div>

	<div id="center">	
	<center>
	<h1><font color="red">Please enter the following details to sign in</font></h1>
	<form name="form_details" method="post" action="signin.php">
	<table>
	<tr>
	<td>User ID:</td><td><input type="text" name="userid"></td>
	</tr>
	<tr>
	<td>Password:</td><td><input type="password" name="password"></td>
	</tr>
	</table><br>
	<input type="submit" name="signin" value="Sign In"><br>
	<h3><?php echo $message;?></h3>
	</form>
	</center>
	</div>

</body>
</html>