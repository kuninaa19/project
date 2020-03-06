<?php
	session_start();
include_once ('../db.php');


$num = $_GET['board'];

	$sql = "SELECT * FROM review_reply WHERE reviewNum = $num order by created asc";

    $result = mysqli_query($conn, $sql) or die("Error :	" . mysqli_error());
    
	$resultArray = array();

	while($row = mysqli_fetch_array($result)){
	     array_push($resultArray,
        array('id' => $row[0], 'nickname' => $row[2], 'reply' => $row[3], 'created' => $row[4], 'user_id' => $row[5]));
	}

	echo json_encode($resultArray);

?>