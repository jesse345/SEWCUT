<?php
include("../Model/db.php");
session_start();
error_reporting(0);

if (!isset($_SESSION['id'])) {
	header("Location: ../index.php");
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include("../layouts/head.layout.php") ?>
	<title>My Product</title>
	<style>
		.table.table-summary tbody td {
			border-bottom: none;
			height: 40px;
		}

		.summary-total {
			border-top: .1rem solid #ebebeb;
		}
	</style>
</head>

<body>
	<?php
	$user = mysqli_fetch_assoc(getrecord('user_details', 'id', $_SESSION['id']));
	$p = displayDetails('product_details', 'category', 'dress');
	?>
	<div class="page-wrapper">
		<?php include("../layouts/header_layout.php"); ?>
		<main class="main">
			<nav aria-label="breadcrumb" class="breadcrumb-nav">
				<div class="container">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="index.php">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">My Cart</li>
					</ol>
				</div>
			</nav>
			<div class="page-content">
				<div class="cart">
					<div class="container">
						<div class="row">
							<div class="col-lg-12">
								<?php
								$cart = displayCart($_SESSION['id']);
								while ($seller = mysqli_fetch_assoc($cart)):
									$sel = mysqli_fetch_assoc(displayDetails('user_details', 'id', $seller['seller_id']));
									$subtotal = 0;
									?>
									<div style="margin-bottom: 150px;">
										<u>
											<?= ucfirst($sel['firstname']) . ' ' . ucfirst($sel['lastname']) ?>
										</u>
										<table class="table table-cart table-mobile text-center">
											<thead>
												<tr>
													<th>Product</th>
													<th>Price</th>
													<th>Quantity</th>
													<th>Total</th>
													<th></th>
												</tr>
											</thead>
											<tbody class="seller-table">
												<?php
												$eachSeller = displayEachseller($_SESSION['id'], $seller['seller_id']);
												while ($c = mysqli_fetch_assoc($eachSeller)):
													$productPrice = getProductPrice($c['product_id'], $c['color'], $c['size']);
													$productImages = displayDetails('product_images', 'product_id', $c['product_id']);
													$p = mysqli_fetch_assoc($productImages);
													$productDetails = mysqli_fetch_assoc(displayDetails('product_details', 'id', $c['product_id']));
													$productDetailsETC = mysqli_fetch_assoc(displayDetailsETC('product_details_etc', $c['product_id'], $c['color'], $c['size']));
													$total = $productPrice['price'] * $c['quantity'];
													$subtotal += $total;
													?>
													<tr>
														<td class="product-col">
															<div class="product" style="margin-left: 32px;">
																<figure class="product-media">
																	<a href="#productViewMore-Modal<?php echo $c['id'] ?>"
																		data-toggle="modal">
																		<img src="<?php echo $p['image'] ?>">
																	</a>
																	<div class="modal fade"
																		id="productViewMore-Modal<?php echo $c['id'] ?>"
																		tabindex="-1" role="dialog" aria-hidden="true">
																		<div class="modal-dialog custom-modal add-modal"
																			role="document">
																			<div class="modal-content">
																				<div class="modal-body">
																					<div class="card-body">
																						<label>Images and Videos</label><br>
																						<img src="<?php echo $p['image'] ?>"
																							class="img-responsive">
																						<?php while ($pi = mysqli_fetch_assoc($productImages)): ?>
																							<?php
																							$fileExtension = pathinfo($pi['image'], PATHINFO_EXTENSION);

																							if (in_array($fileExtension, array('jpg', 'jpeg', 'png', 'gif'))):
																								// Display Image
																								?>
																								<img src="<?php echo $pi['image']; ?>"
																									class="img-responsive mt-3"
																									alt="Image">
																							<?php elseif (in_array($fileExtension, array('mp4', 'avi', 'mov'))):
																								// Display Video
																								?>
																								<video controls class="video-responsive"
																									style="margin-top:10px;width:523px;">
																									<source
																										src="<?php echo $pi['image']; ?>"
																										type="video/<?php echo $fileExtension; ?>">
																									<!-- Add more source elements for other video formats if needed -->
																									Your browser does not support the
																									video tag.
																								</video>
																							<?php endif; ?>
																						<?php endwhile; ?>
																					</div>
																				</div>
																				<div class="modal-footer">
																					<button type="button"
																						class="btn btn-danger products"
																						data-dismiss="modal" aria-label="Close">
																						Close
																					</button>
																				</div>
																			</div>
																		</div>
																	</div>
																</figure>

																<h3 class="product-title">
																	<a href="#">
																		<?php echo $productDetails['product_name'] ?>
																	</a>
																</h3><!-- End .product-title -->
															</div><!-- End .product -->
														</td>
														<td class="price-col" id="cartPrice">
															<?php echo $productPrice['price'] ?>
														</td>
														<td class="quantity-col">
															<div class="cart-product-quantity">
																<input type="number" class="form-control product-quantity"
																	data-cart_id="<?php echo $c['id'] ?>"
																	value="<?php echo $c['quantity'] ?>" min="1"
																	max="<?php echo $productDetailsETC['quantity'] ?>" step="1"
																	data-decimals="0" required>
															</div><!-- End .cart-product-quantity -->
														</td>
														<?php $total = $productPrice['price'] * $c['quantity'] ?>
														<td class="total-price-col">
															<?= $total ?>
														</td>
														<td class="remove-col">
															<!-- <form action="../Controller/cartController.php" method="POST"> -->
															<button class="btn-remove"
																data-product_id="<?php echo $c['product_id'] ?>"
																style="color:red;"><i class="icon-close"></i></button>
															<!-- </form> -->
														</td>
													</tr>
													<form action="../Controller/cartController.php" method="POST">
														<input type="hidden" name="total[]" value="<?= $total ?>">
														<input type="hidden" name="cart_id[]" value="<?= $c['id'] ?>">
														<input type="hidden" name="quantity[]"
															value="<?php echo $c['quantity'] ?>">
													<?php endwhile; ?>

													<tr class="d-flex subtotal-row" style="position:absolute;right: 0;">
														<td colspan="1"></td>
														<td class="subtotal-col" colspan="1"
															style="font-size:18px;font-weight:500">SubTotal: <span
																class="subtotal">
																<?= $subtotal ?>
															</span></td>
														<input type="hidden" name="Subtotal" value="<?= $subtotal ?>">
														<td colspan="1" style="margin-left:30px;"><button type="sumbit"
																name="CHECKOUT" class="btn btn-primary">Checkout</button>
														</td>
													</tr>
												</form>

											</tbody>
										</table>
									</div>
								<?php endwhile; ?>
							</div>
						</div><!-- End .row -->
					</div><!-- End .container -->
				</div><!-- End .cart -->
			</div><!-- End .page-content -->
		</main><!-- End .main -->
		<br>
		<?php include("../layouts/footer.layout1.php"); ?>
	</div>

	<?php
	include("../layouts/jsfile.layout.php");
	include("toastr.php");
	?>
</body>
<script>
	$(document).ready(function () {
		$(".product-quantity").change(function () {
			var cart_id = $(this).data("cart_id");
			var product_quantity = $(this).val();

			$.ajax({
				type: "POST",
				url: "../Controller/cartController.php",
				data: {
					UPDATEQUANTITY: true,
					cart_id: cart_id,
					product_quantity: product_quantity
				},
				success: function (response) {
					// Handle the response from the server here
					console.log(response);

					// Reload the current page to reflect the updated cart
					location.reload();
				},
				error: function (xhr, status, error) {
					// Handle any AJAX errors here
					console.error("AJAX error:", error);
				}
			});
		});
		// $(".product-quantity").change(function () {
		// 	// Get the quantity input field within the same row
		// 	var quantityInput = $(this).closest("tr").find(".product-quantity");

		// 	// Get the current quantity and price for this row
		// 	var quantity = parseInt(quantityInput.val());
		// 	var price = parseFloat($(this).closest("tr").find(".price-col").text());

		// 	// Calculate the total price for this row
		// 	var total = quantity * price;

		// 	// Update the total price cell in this row
		// 	$(this).closest("tr").find(".total-price-col").text(total.toFixed(2));

		// 	// Recalculate and update the subtotal for this seller's table
		// 	var sellerTable = $(this).closest(".seller-table");
		// 	updateSubtotal(sellerTable);
		// 	$("input[name='total[]']").val(total.toFixed(2));
		// 	$("input[name='quantity[]']").val(quantity);
		// });

		// Function to calculate and update the subtotal for a specific seller's table
		function updateSubtotal(sellerTable) {
			var subtotal = 0;

			// Iterate through the rows in the seller's table and sum up the individual totals
			sellerTable.find(".total-price-col").each(function () {
				subtotal += parseFloat($(this).text());
			});

			// Update the subtotal displayed in the corresponding row
			sellerTable.find(".subtotal").text(subtotal.toFixed(2));
			$("input[name='newTotal']").val(subtotal.toFixed(2));
		}

		$(".btn-remove").click(function () {
			var product_id = $(this).data("product_id");

			// Display a confirmation dialog
			if (confirm("Are you sure you want to remove this product?")) {
				// User confirmed, send the removal request
				$.ajax({
					type: "POST",
					url: "../Controller/cartController.php",
					data: {
						REMOVECART: true,
						product_id: product_id
					},
					success: function (response) {
						// Handle the response from the server here
						console.log(response);

						// Reload the current page to reflect the updated cart
						location.reload();
					},
					error: function (xhr, status, error) {
						// Handle any AJAX errors here
						console.error("AJAX error:", error);
					}
				});
			}
		});


	});
</script>

</html>
