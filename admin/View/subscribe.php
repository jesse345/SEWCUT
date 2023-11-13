<?php
include('../../Model/db.php');
include("../Includes/head.includes.php");
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>

<body class="alt-menu">
    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->

    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container " id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <?php include("../Includes/sidebar.includes.php"); ?>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content" style="margin-top:5px;">
            <div class="layout-px-spacing">
                <div class="middle-content container-xxl p-0">
                    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing mt-5">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <div class="table-responsive">
                                    <h2>Pending</h2>
                                    <table class="table table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">User ID</th>
                                                <th scope="col">Type</th>
                                                <th>Status</th>
                                                <th>Amount</th>
                                                <th>Receipt</th>
                                                <th scope="col">Date Created</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $record = getrecord('subscription', 'status', 'Pending');
                                            while ($subscription_record = mysqli_fetch_assoc($record)): ?>
                                                <tr>
                                                    <td>
                                                        <?= $subscription_record['user_id'] ?>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-info"><?= $subscription_record['type'] ?></button>
                                                    </td>
                                                    <td>
                                                         <span class="badge badge-light-success"><?= $subscription_record['status'] ?></span>
                                                    </td>
                                                    <td>
                                                             <?= $subscription_record['amount'] ?>
                                                    </td>
                                                    <td>
                                                        <img src="../../<?= $subscription_record['receipt_img'] ?>" class="img-responsive" style="height:150px;width:200px;" alt="">
                                                    </td>
                                                    <td>
                                                        <?= $subscription_record['created_at'] ?>
                                                    </td>
                                                    <form action="../Controller/subscriptionController.php" method="POST">
                                                        <input type="hidden" name="type" value="<?= $subscription_record['type'] ?>">
                                                        <input type="hidden" name="subscription_id" value=" <?= $subscription_record['id'] ?>">
                                                        <td>
                                                            <button type="submit" name="REJECT" style="background-color:transparent;border:none;"><span class="badge badge-light-danger">Rejected</span></button>
                                                            <button type="submit" name="ACCEPT" style="background-color:transparent;border:none;"><span class="badge badge-light-success">Accept</span></button>
                                                        </td>
                                                    </form>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="widget-content widget-content-area mt-5">
                                <div class="table-responsive">
                                    <h2>Approve</h2>
                                    <table class="table table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">User ID</th>
                                                <th scope="col">Type</th>
                                                <th>Status</th>
                                                <th scope="col">Date Created</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $record = getrecord('subscription', 'status', 'Approve');
                                            while ($subscription_record = mysqli_fetch_assoc($record)): ?>
                                                <tr>
                                                    <td>
                                                        <?= $subscription_record['user_id'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $subscription_record['type'] ?>
                                                    </td>
                                                    <td>
                                                         <span class="badge badge-light-success"><?= $subscription_record['status'] ?></span>
                                                    </td>
                                                    <td>
                                                        <?= $subscription_record['created_at'] ?>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area mt-5">
                                <div class="table-responsive">
                                    <h2>Reject</h2>
                                    <table class="table table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">User ID</th>
                                                <th scope="col">Type</th>
                                                <th>Status</th>
                                                <th scope="col">Date Created</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $record = getrecord('subscription', 'status', 'Reject');
                                            while ($subscription_record = mysqli_fetch_assoc($record)): ?>
                                                <tr>
                                                   
                                                    <td>
                                                        <?= $subscription_record['user_id'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $subscription_record['type'] ?>
                                                    </td>
                                                    <td>
                                                         <span class="badge badge-light-danger"><?= $subscription_record['status'] ?>ed</span>
                                                    </td>
                                                    <td>
                                                        <?= $subscription_record['created_at'] ?>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>   
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <!--  BEGIN FOOTER  -->
            <!--  END CONTENT AREA  -->
        </div>
        <!--  END CONTENT AREA  -->
    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="../src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../src/plugins/src/mousetrap/mousetrap.min.js"></script>
    <script src="../src/plugins/src/waves/waves.min.js"></script>
    <script src="../layouts/collapsible-menu/app.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="../src/plugins/src/apex/apexcharts.min.js"></script>
    <script src="../src/assets/js/dashboard/dash_2.js"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
</body>
</html>
