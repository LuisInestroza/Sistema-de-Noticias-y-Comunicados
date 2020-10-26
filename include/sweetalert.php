<?php 
if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
    ?>
    <script>
        swal.fire({
            title: "<?php echo $_SESSION['status'];?>",
            icon: "<?php echo $_SESSION['status_icon'];?>",
            button: "OK",
        });
    </script>
    <?php
    unset($_SESSION['status']);
}
?>


