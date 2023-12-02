<?php
include('../../Model/db.php');
include("../Includes/head.includes.php");
session_start();
$user = getallrecord('reports');
$currentDateTime = time();

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
                            <div class="table-responsive">
                                <?php ?>                 
                                <table class="table table-bordered mt-5 text-center">
                                    <thead>
                                        <tr>
                                            <th style="width:10%">#</th>
                                            <th style="width:15%">Report By</th>
                                            <th style="width:15%">Reported User</th>
                                            <th>Reason</th>
                                            <th>Duration</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 0;
                                        while ($user1 = mysqli_fetch_assoc($user)):
                                            $report_by = mysqli_fetch_assoc(getrecord('user_details','id',$user1['user_id']));
                                            $reported_user = mysqli_fetch_assoc(getrecord('user_details','id',$user1['seller_id']));
                                            $count++;

                                           
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?=$count?>
                                                    </td>
                                                    <td>
                                                        <?=ucfirst($report_by['firstname']) . ' ' .ucfirst($report_by['lastname'])?>
                                                    </td>
                                                    <td>
                                                        <?=ucfirst($reported_user['firstname']) . ' ' .ucfirst($reported_user['lastname'])?>
                                                    </td>
                                                    <td>
                                                        <?=$user1['reason']?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($user1['suspension_date'] != '0000-00-00 00:00:00') {
                                                            // Get the current timestamp
                                                            $currentTime = time();

                                                            // Convert the suspension date to a timestamp
                                                            $suspensionTime = strtotime($user1['suspension_date']);

                                                            // Calculate the time difference
                                                            $timeDifference = $suspensionTime - $currentTime;

                                                            // Calculate remaining days, hours, minutes, and seconds
                                                            $remainingDays = floor($timeDifference / (24 * 3600));
                                                            $remainingHours = floor(($timeDifference % (24 * 3600)) / 3600);
                                                            $remainingMinutes = floor(($timeDifference % 3600) / 60);
                                                            $remainingSeconds = $timeDifference % 60;

                                                            // Display the time left
                                                            if ($remainingDays > 0) {
                                                                echo "Time Left: $remainingDays days, $remainingHours hours, $remainingMinutes minutes, $remainingSeconds seconds";
                                                            } else {
                                                                echo "Time Left: $remainingHours hours, $remainingMinutes minutes, $remainingSeconds seconds";
                                                            }
                                                        }
                                                        ?>

                                                    </td>
                                                    <td class="text-center">
                                                        <div class="action-btns">
                                                            <?php if($user1['suspension_date'] == '0000-00-00 00:00:00'){?>
                                                                <a data-bs-toggle="modal" data-bs-target="#DeleteModal<?= $user1['id'] ?>" class="btn btn-danger">Suspend</a>
                                                            <?php } ?>
                                                            <?php if($user1['suspension_date'] != '0000-00-00 00:00:00'){?>
                                                                <form action="../Controller/reportController.php" method="POST">
                                                                    <input type="hidden" name="id" value="<?=$user1['id']?>">
                                                                    <button name="REVERT" class="btn btn-info">Revert</button>
                                                                </form>
                                                            <?php } ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- Suspend -->
                                                <div class="modal fade" id="DeleteModal<?= $user1['id'] ?>" tabindex="-1"
                                                    role="dialog" aria-labelledby="DeleteLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="DeleteLabel">Suspend User
                                                                </h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <svg> ... </svg>
                                                                </button>
                                                            </div>
                                                            <form action="../Controller/reportController.php" method="POST">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="id" value="<?= $user1['id'] ?>">
                                                                <div class="form-check">
                                                                        <label class="form-check-label">
                                                                            <input type="radio" class="form-check-input" name="days" value="3">3 days
                                                                        </label>
                                                                        </div>
                                                                    <div class="form-check">
                                                                        <label class="form-check-label">
                                                                            <input type="radio" class="form-check-input" name="days" value="7"> 7 days
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <label class="form-check-label">
                                                                            <input type="radio" class="form-check-input" name="days" value="14"> 14 days
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <label class="form-check-label">
                                                                            <input type="radio" class="form-check-input" name="days" value="30"> 30 days
                                                                        </label>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn btn-light-dark"
                                                                        data-bs-dismiss="modal"><i
                                                                            class="flaticon-cancel-12"></i>
                                                                        Discard</button>
                                                                    <button class="btn btn btn-primary"
                                                                        name="REPORT">Report</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                           
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
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
