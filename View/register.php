<?php
include("../Model/db.php");
session_start();
$address = sizeOrColor('address');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("../layouts/head.layout.php") ?>
    <title>Homepage</title>
    <style>
        .center-container {
            display: flex;
            justify-content: center;
            /* Center horizontally */
            align-items: center;
            /* Center vertically */
            height: 50vh;
            /* Set the container's height to 100% of the viewport height for vertical centering */
        }

        /* Additional styling for the form (optional) */
        .center-container form {
            text-align: center;
            /* Center form elements horizontally */
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <?php include("../layouts/header_layout1.php"); ?>
        <main class="main">
            <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17"
                style="background-image: url('../assets/images/backgrounds/login-bg.jpg')">
                <div class="container">
                    <div class="form-box">
                        <div class="tab-pane fade show active" id="register-2" role="tabpanel"
                            aria-labelledby="register-tab-2">
                            <h3>Register</h3>
                            <form action="../Controller/userController.php" method="POST">
                                <div class="form-group">
                                    <label>Firstname</label>
                                    <input type="text" class="form-control" name="firstname" required>
                                </div>
                                <div class="form-group">
                                    <label>Lastname</label>
                                    <input type="text" class="form-control" name="lastname" required>
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                                <div class="form-group">
                                    <label>Retype Password</label>
                                    <input type="password" class="form-control" name="repassword" required>
                                </div>
                                <div class="form-group">
                                    <label>Contact Number</label>
                                    <input type="text" class="form-control" name="contact_number" required>
                                </div>
                                <div class="form-group">
                                     <label>Address</label>
                                    <select name="address" class="form-control" required>
                                        <option value="" selected>Select Address</option>
                                        <?php while($add = mysqli_fetch_assoc($address)): ?>
                                        <option value="<?php echo $add['id']?>"><?php echo $add['address']?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label>Gcash Name</label>
                                    <input type="text" class="form-control" name="gcash_name" required>
                                </div>
                                <div class="form-group">
                                    <label>Gcash Number</label>
                                    <input type="text" class="form-control" name="gcash_number" required>
                                </div>
                                <div class="form-footer">
                                    <a href="#termsAndCondition-Modal" data-toggle="modal" class="btn btn-outline-primary-2" >
                                        <span>SIGN UP</span>
                                        <i class="icon-long-arrow-right"></i>
                                    </a>
                                    <div class="custom-control custom-checkbox">
                                        <a href="#termsAndCondition-Modal1" data-toggle="modal"> Terms And Conditions</a></label>
                                    </div>
                                </div>
                                <div class="modal fade" id="termsAndCondition-Modal" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog custom-modal add-modal" role="document" style="max-width:1100px;">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <p>Terms And Conditions</p>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true"><i class="icon-close"></i></span>
                                                </button>
                                            </div>
                                           <div class="modal-body" style="margin-right:5%;margin-left:5%;margin-top:5%;">
                                                <h2 class="title-sm">Validity of contract</h2>
                                                <p>By accessing, browsing, or using, making purchase via SEWCUTS's website, the following agreement between the customer (you) with a minimum age of 16 and the Shop SEWCUT is legally binding until further notice.</p><br>
                                                <p>As soon as the order has been placed by you, it is your responsibility to provide a functioning address and check the order confirmation thoroughly for possible errors. You must contact us immediately in case you wish to change or correct any details in your order. Once a custom-made garment has been cut (i.e. production has started), no further changes can be applied. For other types of agreements, please contact us before completing your purchase. Upon the receipt of the goods through the customer, the contract is regarded as concluded.</p>
                                                <h2 class="title-sm">Modification to Terms and Condition</h2>
                                                <p>SEWCUT may, without notice to you, at any time revise these Terms & Conditions and any other information contained in the website by updating the information. We may also make improvements or changes in the products, services, or programs described on this site at any time without notice. It is your responsibility to check these Terms and Conditions each time before using the Site. The amended Terms and Conditions are effective from the date they are published on the Site. Your continued access and use of the Site and our service following the posting of changes will mean that you unconditionally accept and agree to the latest version of the Terms and Conditions.</p><br>
                                                <h2 class="title-sm">Delivery</h2>
                                                <p>During the order process, the customer will be informed about the estimated delivery time for the order. This estimate is based on the current production queue and the actual time it usually takes to send an order from our tailor shop (in CEBU) to your address.</p><br>
                                                <p>The delivery time cannot be guaranteed, as it is only a calculated estimation. We are always working hard constantly monitoring the manufacturing process and final delivery to deliver your order as soon as possible. SEWCUT cannot be held responsible for losses, inconveniences, costs, or other damages resulting from late deliveries.</p><br>
                                                <p>As soon as the order is shipped, you will receive possible tracking number tracking the time the order is handed over to your local dispatcher.</p><br>
                                                <h2 class="title-sm">Complaint</h2>
                                                <p>You have a right to withdraw from the agreement at any time before the expiry of a period of 14 days from the day on which you receive the goods without giving a reason. You must return any goods supplied at your own expense if you cancel the contract. Any consumer's specifications including shirts, suits, coats, dresses are excluded from the right of withdrawal (even if they are ordered as a standard size).</p><br>
                                                <p>You have the right to email a complaint on your product within one (1) year of delivery. You should report any defect as soon as possible or as soon as the error should have been discovered. It is the buyer's responsibility to verify that the error was there originally or is the result of a production error. Included from damage under this warranty are the following: wrong design, faded color, shrinking (without our noticing), bubbling. You have to inform us if the product is defective with an appropriate delay. </p>
                                                <h2 class="title-sm">Tolerances</h2>
                                                <p>SEWCUJT's custom-made products are always made to the measurements stated by you. If you choose body measurements, the measurements are adjusted according to the fit selected by you (slim/tapered, normal/regular, or loose fit).</p><br>
                                                <p>SEWCUT cannot guarantee that a garment in a standard size will have a perfect fit and therefore recommend you use your personal measurements instead. The number of buttons may vary depending on the shirt's size or can be provided by you upon your request. Otherwise, our experienced tailors will choose the best solution for each unique garment. Sometimes buttons are there for special reasons. Please note that in some cases visible chalk marks or marks from ironing can be left on the garment which usually disappear without any extra treatment during the first wash. Garments made from different rolls of fabric may differ slightly in shade of colour due to normal variations in the dyeing process. Should any other problems occur, please contact us so we can find a solution together.</p><br>
                                                <p>The shown garment is a visualization only. The final product may vary somewhat in construction and colour. The perception of colours can vary from display to display. Therefore, the images do not reference an exact colour but have a guiding function only. We will try our best to visualize the fabrics the best for you.</p><br>
                                                <h2 class="title-sm">No refunds</h2>
                                                <p>Unfortunately SEWCUT does not refund The customer if the delivered product isn't to their liking. it is the customer's responsibility to state the correct measurements in profiles.</p>
                                                <h2 class="title-sm">Personal information</h2>
                                                <p>SEWCUT is responsible for the integrity of the personal information given by our customers. Your personal information is only used for internal purposes and neither your personal details nor your E-mail address will be given to third parties. Read more about our privacy policy here.</p><br>
                                                <p>While SEWCUT takes reasonable steps to safeguard and to prevent unauthorized access to your personal information, SEWCUT is responsible for the acts of those who gain unauthorized access, and SEWCUT does not warranty, express, implied or otherwise, that SEWCUT will prevent unauthorized access to your private information.</p>
                                                <h2 class="title-sm">Users' Confirmation</h2>
                                                <p>By creating an account on the Site, the User hereby confirms and undertakes that he/she is acting as the Customer on his/her account or acting on behalf of the Customer to register such account. You represent to us and all suppliers of the merchandise through our site that all purchases made by you through our site will be within the scope of your authority to conclude contracts.</p>
                                                <h2 class="title-sm">Customer disputes</h2>
                                                <p>Information on the website should not be taken as absolutely correct, current, or complete, and the site may contain inaccuracies or typographical errors. SEWCUT will try our best to update the website to keep information current or to ensure the accuracy or completeness of any posted information. We assume no responsibility (and expressly disclaims any responsibility) for updating information. Accordingly, customers should confirm the accuracy and completeness of all posted information before making any decision related to any services, products, or other matters described on this site.</p>
                                           </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger products" data-dismiss="modal" aria-label="Close">
                                                    Close
                                                </button>
                                                <button type="submit" name="REGISTER" id="REGISTER" class="btn btn-info">
                                                    Agree and Register
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><
            </div>
        </main>
        <div class="modal fade" id="termsAndCondition-Modal1" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog custom-modal add-modal" role="document" style="max-width:1100px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <p>Terms And Conditions</p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="icon-close"></i></span>
                        </button>
                    </div>
                    <div class="modal-body" style="margin-right:5%;margin-left:5%;margin-top:5%;">
                        <h2 class="title-sm">Validity of contract</h2>
                        <p>By accessing, browsing, or using, making purchase via SEWCUTS's website, the following agreement between the customer (you) with a minimum age of 16 and the Shop SEWCUT is legally binding until further notice.</p><br>
                        <p>As soon as the order has been placed by you, it is your responsibility to provide a functioning address and check the order confirmation thoroughly for possible errors. You must contact us immediately in case you wish to change or correct any details in your order. Once a custom-made garment has been cut (i.e. production has started), no further changes can be applied. For other types of agreements, please contact us before completing your purchase. Upon the receipt of the goods through the customer, the contract is regarded as concluded.</p>
                        <h2 class="title-sm">Modification to Terms and Condition</h2>
                        <p>SEWCUT may, without notice to you, at any time revise these Terms & Conditions and any other information contained in the website by updating the information. We may also make improvements or changes in the products, services, or programs described on this site at any time without notice. It is your responsibility to check these Terms and Conditions each time before using the Site. The amended Terms and Conditions are effective from the date they are published on the Site. Your continued access and use of the Site and our service following the posting of changes will mean that you unconditionally accept and agree to the latest version of the Terms and Conditions.</p><br>
                        <h2 class="title-sm">Delivery</h2>
                        <p>During the order process, the customer will be informed about the estimated delivery time for the order. This estimate is based on the current production queue and the actual time it usually takes to send an order from our tailor shop (in CEBU) to your address.</p><br>
                        <p>The delivery time cannot be guaranteed, as it is only a calculated estimation. We are always working hard constantly monitoring the manufacturing process and final delivery to deliver your order as soon as possible. SEWCUT cannot be held responsible for losses, inconveniences, costs, or other damages resulting from late deliveries.</p><br>
                        <p>As soon as the order is shipped, you will receive possible tracking number tracking the time the order is handed over to your local dispatcher.</p><br>
                        <h2 class="title-sm">Complaint</h2>
                        <p>You have a right to withdraw from the agreement at any time before the expiry of a period of 14 days from the day on which you receive the goods without giving a reason. You must return any goods supplied at your own expense if you cancel the contract. Any consumer's specifications including shirts, suits, coats, dresses are excluded from the right of withdrawal (even if they are ordered as a standard size).</p><br>
                        <p>You have the right to email a complaint on your product within one (1) year of delivery. You should report any defect as soon as possible or as soon as the error should have been discovered. It is the buyer's responsibility to verify that the error was there originally or is the result of a production error. Included from damage under this warranty are the following: wrong design, faded color, shrinking (without our noticing), bubbling. You have to inform us if the product is defective with an appropriate delay. </p>
                        <h2 class="title-sm">Tolerances</h2>
                        <p>SEWCUJT's custom-made products are always made to the measurements stated by you. If you choose body measurements, the measurements are adjusted according to the fit selected by you (slim/tapered, normal/regular, or loose fit).</p><br>
                        <p>SEWCUT cannot guarantee that a garment in a standard size will have a perfect fit and therefore recommend you use your personal measurements instead. The number of buttons may vary depending on the shirt's size or can be provided by you upon your request. Otherwise, our experienced tailors will choose the best solution for each unique garment. Sometimes buttons are there for special reasons. Please note that in some cases visible chalk marks or marks from ironing can be left on the garment which usually disappear without any extra treatment during the first wash. Garments made from different rolls of fabric may differ slightly in shade of colour due to normal variations in the dyeing process. Should any other problems occur, please contact us so we can find a solution together.</p><br>
                        <p>The shown garment is a visualization only. The final product may vary somewhat in construction and colour. The perception of colours can vary from display to display. Therefore, the images do not reference an exact colour but have a guiding function only. We will try our best to visualize the fabrics the best for you.</p><br>
                        <h2 class="title-sm">No refunds</h2>
                        <p>Unfortunately SEWCUT does not refund The customer if the delivered product isn't to their liking. it is the customer's responsibility to state the correct measurements in profiles.</p>
                        <h2 class="title-sm">Personal information</h2>
                        <p>SEWCUT is responsible for the integrity of the personal information given by our customers. Your personal information is only used for internal purposes and neither your personal details nor your E-mail address will be given to third parties. Read more about our privacy policy here.</p><br>
                        <p>While SEWCUT takes reasonable steps to safeguard and to prevent unauthorized access to your personal information, SEWCUT is responsible for the acts of those who gain unauthorized access, and SEWCUT does not warranty, express, implied or otherwise, that SEWCUT will prevent unauthorized access to your private information.</p>
                        <h2 class="title-sm">Users' Confirmation</h2>
                        <p>By creating an account on the Site, the User hereby confirms and undertakes that he/she is acting as the Customer on his/her account or acting on behalf of the Customer to register such account. You represent to us and all suppliers of the merchandise through our site that all purchases made by you through our site will be within the scope of your authority to conclude contracts.</p>
                        <h2 class="title-sm">Customer disputes</h2>
                        <p>Information on the website should not be taken as absolutely correct, current, or complete, and the site may contain inaccuracies or typographical errors. SEWCUT will try our best to update the website to keep information current or to ensure the accuracy or completeness of any posted information. We assume no responsibility (and expressly disclaims any responsibility) for updating information. Accordingly, customers should confirm the accuracy and completeness of all posted information before making any decision related to any services, products, or other matters described on this site.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger products" data-dismiss="modal" aria-label="Close">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php include("../layouts/footer.layout.php") ?>
    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>
    <?php
    include("../layouts/jsfile.layout.php");
    include("toastr.php");
    ?>
</body>
</html>
