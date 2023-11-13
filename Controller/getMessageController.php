<?php

session_start();


if (isset($_SESSION['id'])) {

	if (isset($_POST['id_2'])) {

		# database connection file
		include("../Model/dbPDO.php");
		$user = getUser($_POST['id_2'], $connection);
		$id_1 = $_SESSION['id'];
		$id_2 = $_POST['id_2'];
		$opend = 0;


		$sql = "SELECT * FROM chats
	        WHERE to_id=?
	        AND   from_id= ?
	        ORDER BY id ASC";
		$stmt = $connection->prepare($sql);
		$stmt->execute([$id_1, $id_2]);

		if ($stmt->rowCount() > 0) {
			$chats = $stmt->fetchAll();

			# looping through the chats
			foreach ($chats as $chat) {
				if ($chat['opened'] == 0) {

					$opened = 1;
					$chat_id = $chat['id'];

					$sql2 = "UPDATE chats
	    		         SET opened = ?
	    		         WHERE id = ?";
					$stmt2 = $connection->prepare($sql2);
					$stmt2->execute([$opened, $chat_id]);

					?>

					<div class="d-flex justify-content-start">
						<p class="small mb-1">
							<?php echo ucfirst($user['firstname']) . ' ' . ucfirst($user['lastname']) ?>
						</p>
					</div>
					<div class="d-flex flex-row justify-content-start">
						<img src="<?php echo $user['user_img'] ?>" alt="avatar 1" style="width: 45px; height: 100%;">
						<div>
							<p class="small p-2 ms-3 mb-3 text-white rounded-3 bg-primary">
								<?php echo $chat['message'] ?>
						</div>
					</div>
					<?php
				}
			}
		}

	}
} else {
	header("Location: ../../index.php");
	exit;
}
