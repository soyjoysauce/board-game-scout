<?php

require_once('mysqlConnect.php');

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn){
	die('Connection Failed: ' . mysqli_connect_error());
}

// create sql table
$sql = "CREATE TABLE Player_Data (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50),
phone VARCHAR(30)
)";

if(mysqli_query($conn, $sql)){
	echo "Table Player_Data was created successfully";
} else {
	echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);

?>