<html>
<head>
	<script type="text/javascript"
	src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript"
	src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
	<link rel="stylesheet" type="text/css"
	href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" />
 	
	<script type="text/javascript">
	        $(document).ready(function(){
	            $("#bookName").autocomplete({
	                source:'http://dijkstra.ug.bcc.bilkent.edu.tr/~batuhan.tuter/autocomplete.php',
			select:function(evt, ui)
			{
				// when a book name is selected, populate related fields in this form
				this.form.author.value = ui.item.author;
				this.form.publisher.value = ui.item.publisher;
				this.form.year.value = ui.item.year;
			} 
	            });
	        });
	</script>	
</head>

<?php
error_reporting(E_ALL); 
session_start();

define('DB_HOST', 'localhost');
define('DB_NAME', 'batuhan_tuter');
define('DB_USER','batuhan.tuter'); 
define('DB_PASSWORD','lcknr6rq8');
echo "Welcome To Add Book Page! <br><br>";
#Connects the DataBase
$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error());

#Book Search
?>
You can type a book name to search!
<br><br>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
     	Book Name : <input type="text" id="bookName" name="bookName" /><br>
	Author: <input type="text" id="author" name="author" /><br>
	Publisher: <input type="text" id="publisher" name="publisher" /><br>
	Year: <input type="text" id="year" name="year" /><br>
	Stock: <input type="text" id="stock" name="stock" /><br><br>
	<input type="submit" name="submit" value="Add/Set"/>
</form>
<?php
if($_POST["bookName"] != '' && $_POST["author"] != '' && $_POST["publisher"] != '' && $_POST["year"] != '' && $_POST["stock"] != '')
{
	$bookName = $_POST["bookName"];
	$author = $_POST["author"];
	$publisher = $_POST["publisher"];
	$year = $_POST["year"];
	$stock = $_POST["stock"];
	
	$query = mysql_query("SELECT max(bid) as bid FROM book");
	$row = mysql_fetch_array($query); 
	$maxBid = $row["bid"];

	$qry = "SELECT bid FROM book where bname = '$bookName' and author= '$author' and publisher = '$publisher' and year = '$year'";
	$result = mysql_query($qry);
	$row = mysql_fetch_array($result);
	$bidofBook = $row["bid"];
	
	$sid = $_SESSION['sid']; 

	#If book does not exists, adds the book the the book_branch and has tables
	if($bidofBook == "")
	{
		$newBid = ++$maxBid;
		mysql_query("insert into book (bid,bname,author,publisher,year) values ('$newBid','$bookName','$author','$publisher','$year')");
		mysql_query("insert into has (bid,sid,stock) values ('$newBid','$sid','$stock')");
		echo "Book is inserted in to the Store!";
	}
	#If book exists, change the stock variable
	else
	{
		mysql_query("update has set stock='$stock' where bid='$bidofBook' and sid='$sid'");
		echo "Book Stock has set <br><br>";
	}
		
}
?>
<form method="POST" action="http://dijkstra.ug.bcc.bilkent.edu.tr/~batuhan.tuter/manager.php">
	<input type="submit" value="Back"/>
</form>
<br>
<form method="POST" action="http://dijkstra.ug.bcc.bilkent.edu.tr/~batuhan.tuter/signin.php">
	<input type="submit" value="LogOut"/>
</form>

</html>
