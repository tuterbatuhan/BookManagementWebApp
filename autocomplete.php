
<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'batuhan_tuter');
define('DB_USER','batuhan.tuter'); 
define('DB_PASSWORD','lcknr6rq8');
#Connects the DataBase
$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error());

 	#Get the current value of book name text box and search it in the db
	$term=$_POST["term"];
	$_SESSION["searchbk"] = $term;

	$query=mysql_query("SELECT bname,author,publisher,year FROM book where bname like '%".$term."%' order by bname ");
	$data=array();
	
	while($row=mysql_fetch_array($query)){
		$data[]=array('value'=> $row["bname"],'author'=>$row["author"], 'publisher' =>  $row['publisher'], 'year' =>  $row['year']);
	}
	#Pass the found values to the addbook page
	echo json_encode($data);

?>
