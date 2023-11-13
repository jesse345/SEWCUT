<?php
session_start();

# check if the user is logged in
if (isset($_SESSION['id'])) {
	if (isset($_POST['message']) && isset($_POST['to_id'])) {
		# database connection file
		include '../Model/dbPDO.php';
		$user = getUser($_SESSION['id'], $connection);

		# get data from XHR request and store them in var
		$message = $_POST['message'];
		$to_id = $_POST['to_id'];


		# get the logged in user's username from the SESSION
		$from_id = $_SESSION['id'];

		$sql = "INSERT INTO 
	       chats (from_id, to_id, message) 
	       VALUES (?, ?, ?)";
		$stmt = $connection->prepare($sql);
		$res = $stmt->execute([$from_id, $to_id, $message]);

		# if the message inserted
		if ($res) {
			/**
					   check if this is the first
					   conversation between them
					   **/
			$sql2 = "SELECT * FROM conversations
               WHERE (user_1=? AND user_2=?)
               OR    (user_2=? AND user_1=?)";
			$stmt2 = $connection->prepare($sql2);
			$stmt2->execute([$from_id, $to_id, $from_id, $to_id]);

			// setting up the time Zone
			// It Depends on your location or your P.c settings
			define('TIMEZONE', 'Africa/Addis_Ababa');
			date_default_timezone_set(TIMEZONE);

			$time = date("h:i:s a");

			if ($stmt2->rowCount() == 0) {
				# insert them into conversations table 
				$sql3 = "INSERT INTO 
			         conversations(user_1, user_2)
			         VALUES (?,?)";
				$stmt3 = $connection->prepare($sql3);
				$stmt3->execute([$from_id, $to_id]);
			}
			?>
			<div class="d-flex justify-content-end">
				<p class="small float-right">
					<?php echo ucfirst($user['firstname']) . ' ' . ucfirst($user['lastname']) ?>
				</p>
			</div>
			<div class="d-flex flex-row justify-content-end mb-4 pt-1">
				<div>
					<p class="small p-2 me-3 mb-3 text-white rounded-3 bg-primary">
						<?php echo $message ?>
					</p>
				</div>
				<img src="<?php echo $user['user_img'] ?>" alt="avatar 1" style="width: 45px; height: 100%;">
			</div>


			<?php
		}
	}
} else {
	header("Location: ../View/logout.php");
	exit;
}
