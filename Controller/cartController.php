<?php
session_start();
include("../Model/db.php");
include '../includes/toastr.inc.php';

if (isset($_POST['ADDTOCART'])) {
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];

    $seller = mysqli_fetch_assoc(displayDetails('products', 'id', $product_id));

    $quantity = $_POST['quanity'];
    $size = $_POST['size'];
    $color = $_POST['color'];

    $price = getQuantity($product_id, $color, $size);
    $total = $price['price'] * $quantity;

    $field = array('user_id', 'product_id', 'seller_id', 'quantity', 'size', 'color', 'total', 'isOrder');
    $value = array($user_id, $product_id, $seller['user_id'], $quantity, $size, $color, $total, 'No');

    insertCart(
        'carts',
        $field,
        $value
    );

    flash("msg", "success", "Added to Cart");
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} elseif (isset($_POST['REMOVECART'])) {
    $product_id = $_POST['product_id'];

    removeCart($_SESSION['id'], $product_id);
    flash("msg", "success", "Removed from Cart");
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} elseif (isset($_POST['CHECKOUT'])) {
    $cart_id = $_POST['cart_id'];
    $total = $_POST['total'];
    $quantity = $_POST['quantity'];
    $subTotal = $_POST['Subtotal'];

    $fields = array('id', 'total', 'quantity');
    foreach ($cart_id as $i => $cartID) {
        updateCart(
            'carts',
            $fields,
            array($cartID, $total[$i], $quantity[$i])
        );
        echo "cartID " . $cartID . " total " . $total[$i] . " quantity " . $quantity[$i];
        $seller_id = mysqli_fetch_assoc(displayDetails('carts', 'id', $cart_id[$i]));
    }

    // Redirect to the checkout page with seller_id
    header("Location: ../View/checkout.php?seller=" . $seller_id['seller_id']);
} elseif (isset($_POST['UPDATEQUANTITY'])) {
    $cart_id = $_POST['cart_id'];
    $product_quantity = $_POST['product_quantity'];

    updateCart('carts', array('id', 'quantity'), array($cart_id, $product_quantity));
    header("Location: " . $_SERVER['HTTP_REFERER']);
}
