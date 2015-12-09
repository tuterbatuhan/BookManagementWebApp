<?php
session_start();
#Connect DB
define('DB_HOST', '********');
define('DB_NAME', '********');
define('DB_USER','********'); 
define('DB_PASSWORD','********');
echo "Welcome To Search Book Page! <br><br>";

$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error());

#Scanning All Books
echo "<br>All Books: ";
$query = mysql_query("SELECT * FROM book") or die(mysql_error());
echo "<table border='1'";
echo "<tr><td><b>Book Id</b><td><b>Book Name</b></td><td><b>Author</b></td><td><b>Publisher</b></td>";
echo "<td><b>Year</b></td><td><b>Info Button</b></td></tr>";  
while($row = mysql_fetch_array($query))
{
	echo "<tr>";
	$bid = $row['bid'];
	echo "<td>" .$bid. "</td>";
	echo "<td>" .$row['bname']. "</td>";
	echo "<td>" .$row['author']. "</td>";
	echo "<td>" .$row['publisher']. "</td>";
	echo "<td>" .$row['year']. "</td>";
	echo "<td>";
	echo "<form method='POST' action=''>";
	echo "<input type='hidden' name='info' value = '" .$bid. "' />";
	echo "<input type='submit' value = 'Get Info'/> </form>";
	echo "</td>";
	echo "</tr>";
}
$bid = $row['bid'];
echo "</table>";
?>

<br>Search Book:
<form method="POST" action="">
	Book Name: <input type="text" name="bkName" size="40"><br>
	Author: <input type="text" name="bkAuthor" size="40"><br>
	Publisher: <input type="text" name="bkPublisher" size="40"><br>
	City: 
	<select name="Make" onchange="document.getElementById('selected_text').value=this.options[this.selectedIndex].text"/>
		<option value="0">Select One</option>	
		<option value="1">Any</option>	
		<?php  
			#Find all cities in the DB
			$query = mysql_query("SELECT distinct city FROM store_branch") or die(mysql_error());	
			$counter=1;
			while($row = mysql_fetch_array($query))
			{
				$counter++;
				echo "<option value=".$counter.">".$row['city']."</option>";
			}  	 
		?>
	</select>
	<span style="color:red;font-style:italic;">(Dont Forget to choose!)</span><br><br>
	<input type="hidden" name="selected_text" id="selected_text" value="" />
	<input type="submit"  name="search" value="Search"/>
</form>

<?php

if(isset($_POST['search']))
{
	$bkName = $_POST['bkName'];
	$bkAuthor = $_POST['bkAuthor'];
	$bkPublisher = $_POST['bkPublisher'];
	$bkCity = $_POST['selected_text']; // get the selected city
	$makerValue = $_POST['Make'];
	#If city is chosen Any, search according to the all cities
	if($bkCity=="Any")
	{
		$qry = "SELECT distinct bname,author,publisher,city FROM book NATURAL JOIN has NATURAL JOIN store_branch WHERE bname like '%$bkName%' and author like '%$bkAuthor%' and publisher like '%$bkPublisher%'";
		$query = mysql_query($qry) or die(mysql_error());
		echo "<table border='1'";
		echo "<tr><td><b>Book Name</b><td><b>Author</b></td><td><b>Publisher</b></td><td><b>City</b></td></tr>";
		while($row = mysql_fetch_array($query))
		{
			echo "<tr>";
			echo "<td>" .$row['bname']. "</td>";
			echo "<td>" .$row['author']. "</td>";
			echo "<td>" .$row['publisher']. "</td>";
			echo "<td>" .$row['city']. "</td>";
			echo "</tr>";
		}
			echo "</table>";	
	}
	#Search according to chosen city
	else
	{
		$qry = "SELECT distinct bname,author,publisher,city FROM book NATURAL JOIN has NATURAL JOIN store_branch WHERE bname like '%$bkName%' and author like '%$bkAuthor%' and publisher like '%$bkPublisher%' and city = '$bkCity'";
		$query = mysql_query($qry) or die(mysql_error());
		echo "<table border='1'";
		echo "<tr><td><b>Book Name</b><td><b>Author</b></td><td><b>Publisher</b></td><td><b>City</b></td></tr>";
		while($row = mysql_fetch_array($query))
		{
			echo "<tr>";
			echo "<td>" .$row['bname']. "</td>";
			echo "<td>" .$row['author']. "</td>";
			echo "<td>" .$row['publisher']. "</td>";
			echo "<td>" .$row['city']. "</td>";
			echo "</tr>";
		}
			echo "</table>";
	}
}
#Info of the selected book
if(isset($_POST['info']))
{
	echo "Selected book information: <br><br>";
	$bookId = $_POST['info'];
	$qry = "SELECT sname,city,stock FROM book NATURAL JOIN has NATURAL JOIN store_branch WHERE bid = '$bookId' ";
	$query = mysql_query($qry) or die(mysql_error());
	echo "<table border='1'";
	echo "<tr><td><b>Store Name</b><td><b>City</b></td><td><b>Stock</b></td></tr>";
	while($row = mysql_fetch_array($query))
	{
		echo "<tr>";
		echo "<td>" .$row['sname']. "</td>";
		echo "<td>" .$row['city']. "</td>";
		echo "<td>" .$row['stock']. "</td>";
		echo "</tr>";
	}
	echo "</table>";
}
?>
<br>
<form method="POST" action="http://dijkstra.ug.bcc.bilkent.edu.tr/~batuhan.tuter/manager.php">
	<input type="submit" value="Back"/>
</form>
<form method="POST" action="http://dijkstra.ug.bcc.bilkent.edu.tr/~batuhan.tuter/signin.php">
	<input type="submit" value="LogOut"/>
</form>
