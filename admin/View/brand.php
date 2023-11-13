<?php
include('../../Model/db.php');
include("../Includes/head.includes.php");
session_start();
$user = getallrecord('brands');

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
                               <button class="btn btn-info float-end mt-3 mb-3" data-bs-toggle="modal"
                                                            data-bs-target="#add_modal">Add Brand</button>
                                <table class="table table-bordered mt-5 text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width:10%">#</th>
                                            <th scope="col">Category</th>
                                            <th class="text-center" scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 0;
                                        while ($user1 = mysqli_fetch_assoc($user)):
                                            $count++;
                                            ?>
                                            <tr>
                                                <td>
                                                    <?=$count?>
                                                </td>
                                                <td>
                                                    <?=$user1['brand_name']?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="action-btns">
                                                        <a data-bs-toggle="modal"
                                                            data-bs-target="#EditModal<?= $user1['id'] ?>"
                                                            class="action-btn btn-edit bs-tooltip me-2" title="Edit">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" class="feather feather-edit-2">
                                                                <path
                                                                    d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                                </path>
                                                            </svg>
                                                        </a>
                                                        <a data-bs-toggle="modal"
                                                            data-bs-target="#DeleteModal<?= $user1['id'] ?>"
                                                            class="action-btn btn-delete bs-tooltip" data-placement="top"
                                                            title="Delete">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" class="feather feather-trash-2">
                                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                                <path
                                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                </path>
                                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- Edit -->
                                            <div class="modal fade" id="EditModal<?= $user1['id'] ?>" tabindex="-1"
                                                role="dialog" aria-labelledby="EditModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="EditModalLabel">Edit Brand</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <svg> ... </svg>
                                                            </button>
                                                        </div>
                                                        <form action="../Controller/brandController.php" method="POST">
                                                            <div class="modal-body">
                                                                <div class="row mb-4">
                                                                    <div class="col">
                                                                        <input type="hidden" name="id" value="<?= $user1['id'] ?>">
                                                                        <label >Category</label>
                                                                        <input type="text" name="brand_name"
                                                                            class="form-control"
                                                                            value="<?= $user1['brand_name'] ?>">
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn btn-light-dark"
                                                                    data-bs-dismiss="modal"><i
                                                                        class="flaticon-cancel-12"></i>
                                                                    Close</button>
                                                                <button class="btn btn btn-primary"
                                                                    name="UPDATE">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Delete -->
                                            <div class="modal fade" id="DeleteModal<?= $user1['id'] ?>" tabindex="-1"
                                                role="dialog" aria-labelledby="DeleteLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="DeleteLabel">Delete Brand
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <svg> ... </svg>
                                                            </button>
                                                        </div>
                                                        <form action="../Controller/brandController.php" method="POST">
                                                            <div class="modal-body">
                                                                <p class="modal-text">
                                                                    <center>
                                                                        <input type="hidden" name="id"
                                                                            value="<?= $user1['id'] ?>">
                                                                        <h4>Are you sure you want to delete this record?
                                                                        </h4>
                                                                    </center>
                                                                </p>
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
         <div class="modal fade" id="add_modal" tabindex="-1"
            role="dialog" aria-labelledby="EditModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="EditModalLabel">Add Brand</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close">
                            <svg> ... </svg>
                        </button>
                    </div>
                    <form action="../Controller/brandController.php" method="POST">
                        <div class="modal-body">
                            <div class="row mb-4">
                                <div class="col">
                                    <label for="">Brand</label>
                                    <input type="text" name="brand"
                                        class="form-control"
                                        >
                                </div>
                                
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn btn-light-dark"
                                data-bs-dismiss="modal"><i
                                    class="flaticon-cancel-12"></i>
                                Close</button>
                            <button class="btn btn btn-primary"
                                name="ADD">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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
