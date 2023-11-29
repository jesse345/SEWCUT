<?php
include('../../Model/db.php');
include("../Includes/head.includes.php");
session_start();
$user = getallrecord('reports');

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
                                <table class="table table-bordered mt-5 text-center">
                                    <thead>
                                        <tr>
                                            <th style="width:10%">#</th>
                                            <th style="width:15%">Report By</th>
                                            <th style="width:15%">Reported User</th>
                                            <th>Reason</th>
                                            <th>Created Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 0;
                                        while ($user1 = mysqli_fetch_assoc($user)):
                                            $user_details = mysqli_fetch_assoc(getrecord('user_details',''))
                                            $count++;
                                            ?>
                                            <tr>
                                                <td>
                                                    <?=$count?>
                                                </td>
                                                <td>
                                                    <?=$user1['user_id']?>
                                                </td>
                                                <td>
                                                    <?=$user1['seller_id']?>
                                                </td>
                                                <td>
                                                    <?=$user1['reason']?>
                                                </td>
                                                <td>
                                                    <?=$user1['created_at']?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="action-btns">
                                                        <a data-bs-toggle="modal"
                                                            data-bs-target="#DeleteModal<?= $user1['id'] ?>" class="btn btn-danger">Suspend</a>
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
                                                        <form  method="POST">
                                                            <div class="modal-body">
                                                                
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn btn-light-dark"
                                                                    data-bs-dismiss="modal"><i
                                                                        class="flaticon-cancel-12"></i>
                                                                    Discard</button>
                                                                <button class="btn btn btn-primary"
                                                                    name="DELETE">Delete</button>
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
