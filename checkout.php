<?php
require './inc/config.php';
if (!isset($_COOKIE['user'])) {
    header("Location: " . BASE_URL);
    die();
}
include VIEW_HEADER
?>
<div data-role="page">
    <div data-role="header">
        <h1>Checkout</h1>
    </div>
    <div data-role="main" class="ui-content" style="text-align: center">
        <p>Invoice sent to your email. Please check your email including spam.</p>
        <p>We will contact you soon. Thank You.</p>
        <a href="<?= BASE_URL ?>index.php">Home</a>
    </div>
    <?php include VIEW_COPYRIGHT ?>
</div>
<?php include VIEW_FOOTER ?>
