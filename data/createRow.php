<?php

require_once('mysqlConnect.php');

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn){
	die("Connection failed: " . mysqli_connect_error());
}

$sql = "INSERT INTO Player_Data (firstname, lastname, email, phone)
VALUES ('Austin1', 'Violette1', 'imsocool@google.com', '94912345678')";

if(mysqli_query($conn, $sql)){
	echo "New row created successfully";
} else {
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);

?>