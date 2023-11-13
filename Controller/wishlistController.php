<?php
include("../Model/db.php");
session_start();
include '../includes/toastr.inc.php';

if (isset($_POST['ADDWISHLIST'])) {
    $product_id = $_POST['product_id'];

    insertProduct(
        'wishlists',
        array('user_id', 'product_id'),
        array($_SESSION['id'], $product_id)
    );

    flash("msg", "success", "Added to Wishlist");
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();

} elseif (isset($_POST['REMOVEWISHLIST'])) {
    $product_id = $_POST['product_id'];

    removeWishlist($_SESSION['id'], $product_id);

    flash("msg", "success", "Removed from Wishlist");
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} elseif (isset($_POST['REMOVETOWISHLIST'])) {
    $wishlistID = $_POST['wishlist_id'];
    removeTOWishlist($wishlistID);

    flash("msg", "success", "Removed from Wishlist");
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
