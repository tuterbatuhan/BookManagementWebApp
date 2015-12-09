<?php session_start();
define('DB_HOST', 'localhost');
define('DB_NAME', 'batuhan_tuter');
define('DB_USER','batuhan.tuter'); 
define('DB_PASSWORD','lcknr6rq8');
$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error());

#Decrement the stock of the desired book
if(isset($_POST['decrement']))
{
	$decrement_id = $_POST['decrement'];
	mysql_query("Update has set stock=stock-1 where stock>0 and bid = " .$decrement_id);
	$_SESSION['sold'] = 'Book has sold!';
       
}
#Delete a book if it's stock is zero
$result = mysql_query("select * from has where stock!=0 and bid = " .$decrement_id);
$numrows = mysql_num_rows($result);
if($numrows == "0")
{
	mysql_query("delete from has where stock=0 ");
	$_SESSION['sold-empty'] = 'This Book is no more available!';
}

header('Location: http://dijkstra.ug.bcc.bilkent.edu.tr/~batuhan.tuter/manager.php');
?>
