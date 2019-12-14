<?php
	$hn="localhost";
	$un="dbadmin";
	$pw="1234567890";
	$db="login";
    $conn = new mysqli($hn, $un, $pw, $db); 
    if($conn->connect_error) 
        die($conn->connect_error);
?>