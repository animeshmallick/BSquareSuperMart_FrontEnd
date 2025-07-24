<?php
session_start();
include "../Common.php";
$common = new Common();
$isLoggedIn = $common->is_user_logged_in($_SESSION['authToken'] ?? null);
if($isLoggedIn){
    $redirect = $_GET['redirect'] ?? null;
    $error = $_GET['error'] ?? null;
    ?>
    <!DOCTYPE html>
    <html lang="en" xmlns="http://www.w3.org/1999/html">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Add New Address</title>
        <script src="../scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/fuse.js@7.1.0/dist/fuse.min.js"></script>
        <link href="../styles.css" rel="stylesheet" type="text/css">
    </head>
    <body>
    <div id="page_header"><?php include '../components/header.php'; ?></div>
    <form method="POST" action="addAddressHandler.php">
        <input type="text" name="address_line1" placeholder="Address Line 1" required/>
        <input type="text" name="address_line2" placeholder="Address Line 2" required/>
        <input type="text" name="redirect" hidden="hidden" readonly="readonly" value="<?=$redirect?>"/>
        <button type="submit"> Save </button>
        <?php if($error){?>
            <h3><?=$error?></h3>
        <?php } ?>
    </form>
    <div id="page_footer"><?php include '../components/footer.html'; ?></div>
    </body>
    </html>
<?php }else{
    header("Location: ../login/index.php?redirect=addAddress");
}?>

