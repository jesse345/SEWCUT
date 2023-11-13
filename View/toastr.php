<?php
include '../includes/toastr.inc.php';
?>
<script src="../assets/js/toastr.min.js"></script>

<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    
    <?php if (isset($_SESSION['msg'])): ?>
        <?php $flashData = flash('msg'); ?>
        toastr.<?php echo $flashData['result']; ?>("<?php echo $flashData['message']; ?>");
    <?php endif; ?>

</script>

