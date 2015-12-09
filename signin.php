<!--This Management System is writen by Batuhan Tüter-->
<html>
<head>
<title>Book Store Management</title>
<link rel="stylesheet" type="text/css" href="style-sign.css">
</head>
<body id="body-color" >
<div id="Sign-In" style="margin: auto;margin-top:100px;
    width: 40%;
    border:3px solid #73AD21;
    padding: 10px;">

<fieldset><legend>Welcome. Please Enter Your Credentials</legend>

<form method="POST" action="">
User <br><input type="text" name="user" size="40"><br>
Password <br><input type="password" name="pass" size="40"><br>
<input id="button" type="submit" name="submit" value="Log-In">

</form>
</fieldset>
</div>

<?php session_start(); 
#Connet DB
define('DB_HOST', 'localhost');
define('DB_NAME', '******');
define('DB_USER','********'); 
define('DB_PASSWORD','*******');

$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error());
#False Login
if(isset($_SESSION['false']))
{
	echo $_SESSION['false'];
	unset($_SESSION['false']);
}
#Form Validation
if(isset($_POST['submit']))
{
	if(!empty($_POST['user']) && !empty($_POST['pass']))  //Input Validation
	{
		$query = mysql_query("SELECT *  FROM manager where mname = '$_POST[user]' AND password = '$_POST[pass]'");
		$row = mysql_fetch_array($query);
		$num_results = mysql_num_rows($query); 
		if($num_results<=0)
		{
			#False Login
			$_SESSION['false']="SORRY!<br>False Log-In. Please Retry...";
			header("Location: http://dijkstra.ug.bcc.bilkent.edu.tr/~batuhan.tuter/signin.php");
		}
		if(!empty($row['mname']) AND !empty($row['password']))
		{
			#True Login
			$_SESSION['mid'] = $row['mid'];
			$_SESSION['mname'] = $row['mname'];
			$_SESSION['password'] = $row['password'];	
			header("Location: http://dijkstra.ug.bcc.bilkent.edu.tr/~batuhan.tuter/manager.php");	
		}		
	}
	else
	{
		#Missing Credentials
		echo "SORRY!<br>You did not enter a user name or password. Please Retry...";
	}
}
?>
</body>
</html> 
