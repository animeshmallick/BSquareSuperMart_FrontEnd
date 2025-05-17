<?php
include "../Common.php";
$api = (new ApiBuilder())->init()
    ->setMethod("GET")
    ->setPath('/categories')
    ->execute();
$all_categories = $api->getResponse();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BSquareSuperMart Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <script src="../Config.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>
<body>
<div class="container-fluid p-3" style="background: linear-gradient(to bottom, #FFD700, #FFF);">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold pulseEffect">BSquare in 15 minutes at </h3>
            <p class="text-muted fadeIn" id="address" data-bs-toggle="modal" data-bs-target="#addressModal">HOME - Flat No 2A 009 ▼</p>
        </div>
        <div>
            <img src="../images/user-icon.png" alt="User" class="rounded-circle wow fadeIn" width="10">
        </div>
    </div>
    <div class="mt-3">
        <input type="text" class="form-control search-bar wow bounceIn" placeholder="Search 'sugar'">
    </div>
</div>

<div class="container mt-3" id="categories">
    <?php foreach ($all_categories as $categoryHeader => $categories){ ?>
        <h5 class="category-title wow fadeInLeft"><?= $categoryHeader ?></h5>
        <div class="row">
            <?php foreach ($categories as $category) { ?>
                <div class="col-4 text-center wow zoomIn category-item">
                    <div class="category-img-container">
                        <img class="category-img" width="100%" alt="<?= $category->name ?>">
                    </div>
                    <div class="category-overlay">
                        <p class="category-name"><?= $category->name ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<!-- Address Selection Modal -->
<div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addressModalLabel">Select Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <li class="list-group-item address-item" data-address="HOME - Flat No 2A 009">HOME - Flat No 2A 009</li>
                    <li class="list-group-item address-item" data-address="Office - Block B 302">Office - Block B 302</li>
                    <li class="list-group-item address-item" data-address="Parent's House - Street 5">Parent's House - Street 5</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    new WOW().init();

    $(document).ready(function() {
        $('.address-item').click(function() {
            let selectedAddress = $(this).data('address');
            $('#address').text(selectedAddress);
            $('#addressModal').modal('hide');
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
