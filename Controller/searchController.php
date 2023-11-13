<?php
session_start();

# check if the user is logged in
if (isset($_SESSION['id'])) {
    # check if the key is submitted
    if (isset($_POST['key'])) {
        # database connection file
        include '../Model/dbPDO.php';


        # creating simple search algorithm :) 
        $key = "%{$_POST['key']}%";

        $sql = "SELECT * FROM user_details WHERE firstname LIKE ? OR lastname LIKE ?";
        $stmt = $connection->prepare($sql);
        $stmt->execute([$key, $key]);

        if ($stmt->rowCount() > 0) {
            $users = $stmt->fetchAll();

            foreach ($users as $user) {
                if ($user['id'] == $_SESSION['id'])
                    continue;
                ?>
                <li class="p-2 border-bottom mb-1" style="background-color: #eee;">
                    <a href="chat.php?user=<?php echo $user['id'] ?>" class="d-flex justify-content-between" name="view_messages">
                        <div class="d-flex flex-row">
                            <img src="../img/<?php echo $user['user_img'] ?>" alt="avatar"
                                class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                            <div class="pt-1">
                                <input type="hidden" name="user_id" value="'.$row['user_id'].'">
                                <p class="fw-bold mb-0">
                                    <?php echo $user['firstname'] . ' ' . $user['lastname'] ?>
                                </p>
                                <p class="small text-muted">Lorem ipsum dolor sit amet ...</p>
                            </div>
                        </div>
                    </a>
                </li>
            <?php }
        } else { ?>
            <div class="alert alert-info text-center">
                <i class="fa fa-user-times d-block fs-big"></i>
                The user "
                <?= htmlspecialchars($_POST['key']) ?>"
                is not found.
            </div>
        <?php }
    }

} else {
    header("Location: ../Includes/logout.php");
    exit;
}
