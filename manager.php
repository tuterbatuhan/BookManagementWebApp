
<?php 
session_start();

define('DB_HOST', 'localhost');
define('DB_NAME', '**********');
define('DB_USER','***********'); 
define('DB_PASSWORD','********');

#Alerts the user that the book is sold
if(isset($_SESSION['sold']))
{
	echo "<script>alert('" .$_SESSION['sold']. "');</script>";
	unset($_SESSION['sold']);	
}
#Alerts the user that the book no longer exists
if(isset($_SESSION['sold-empty']))
{
	echo "<script>alert('" .$_SESSION['sold-empty']. "');</script>";
	unset($_SESSION['sold-empty']);
}

#Connects the DataBase
$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error());

$mid =  $_SESSION['mid'];
$mname = $_SESSION['mname'];
$password = $_SESSION['password'];

echo "WELCOME ". $mname."...  <br><br>";
$query = mysql_query("SELECT *  FROM store_branch where mid = $mid") or die(mysql_error());
$row = mysql_fetch_array($query) or die(mysql_error());

$sid = $row['sid'];
$_SESSION['sid'] = "$sid";
$sname = $row['sname'];
$address = $row['address'];
$city = $row['city'];
$size = $row['size'];

?>

<b>Bookstore Branch Information:</b><br><br>
<table border='1'>
	<tr>
		<td><b>Store Id</b></td>
		<td><b>Store Name</b></td>
		<td><b>Manager Id</b></td>
		<td><b>Address</b></td>
		<td><b>City</b></td>
		<td><b>Size</b></td>
	</tr>
	<tr>
		<td><?php echo $sid?></td>
		<td><?php echo$sname?></td>
		<td><?php echo$mid?></td>
		<td><?php echo$address?></td>
		<td><?php echo$city?></td>
		<td><?php echo$size?></td>
	</tr>
</table>
<br><br>
<b>Available Books:</b><br>
<?php
#Available book information
$query = mysql_query("SELECT * FROM book NATURAL JOIN has where has.sid = $sid") or die(mysql_error());
echo "<br><table border='1'";
echo "<tr><td><b>Book Id</b><td><b>Book Name</b></td><td><b>Author</b></td><td><b>Publisher</b></td>";
echo "<td><b>Year</b></td><td><b>Store Id</b></td><td><b>Stock</b></td><td><b>Sell Button</b></td></tr>";  
while($row = mysql_fetch_array($query))
{
	echo "<tr>";
	$bid = $row['bid'];
	echo "<td>" .$bid. "</td>";
	echo "<td>" .$row['bname']. "</td>";
	echo "<td>" .$row['author']. "</td>";
	echo "<td>" .$row['publisher']. "</td>";
	echo "<td>" .$row['year']. "</td>";
	echo "<td>" .$row['sid']. "</td>";
	echo "<td>" .$row['stock']. "</td>";
	echo "<td>";
	echo "<form method='POST' action='http://dijkstra.ug.bcc.bilkent.edu.tr/~batuhan.tuter/decrement.php'>";
	echo "<input type='hidden' name='decrement' value = ' " .$bid. "' />";
	echo "<input type='submit' value = 'SOLD'/> </form>";
	echo "</td>";
	echo "</tr>";
}
$bid = $row['bid'];
echo "</table>";
?>
<br>
<form method="POST" action="http://dijkstra.ug.bcc.bilkent.edu.tr/~batuhan.tuter/addbook.php">
<input type="submit" value="Add Book"/></form>
<form method="POST" action="http://dijkstra.ug.bcc.bilkent.edu.tr/~batuhan.tuter/scan.php">
<input type="submit" value="Scan"/>
</form>
<br>
<form method="POST" action="http://dijkstra.ug.bcc.bilkent.edu.tr/~batuhan.tuter/signin.php">
	<input type="submit" value="LogOut"/>
</form>

