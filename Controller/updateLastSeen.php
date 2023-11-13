<?php  

session_start();

# check if the user is logged in
if (isset($_SESSION['id'])) {
	
	# database connection file
	include '../Model/dbPDO.php';

	# get the logged in user's username from SESSION
	$id = $_SESSION['id'];

	$sql = "UPDATE user_s
	        SET last_seen = NOW() 
	        WHERE id = ?";
	$stmt = $connection->prepare($sql);
	$stmt->execute([$id]);

}else {
	header("Location: ../View/logout.php");
	exit;
}