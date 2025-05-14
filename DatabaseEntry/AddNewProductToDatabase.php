<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add New Product</title>
    <script src="../Config.js"></script>
    <script src="script.js"></script>
    <link href="style.css" rel="stylesheet"/>
</head>
<body>
<div class="form-container" id="addNewProductToDatabase">
    <form id="productForm" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" name="name" required>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" name="category" required>
        </div>
        <div class="form-group">
            <label for="subcategory">Subcategory</label>
            <input type="text" name="subcategory" required>
        </div>
        <div class="form-group">
            <label for="brand">Brand</label>
            <input type="text" name="brand" required>
        </div>
        <div class="form-group">
            <label for="sku">SKU</label>
            <input type="text" name="sku" required>
        </div>
        <div class="form-group">
            <label for="barcode">Barcode</label>
            <input type="text" name="barcode" required>
        </div>
        <div class="form-group">
            <label for="mrp">MRP</label>
            <input type="number" step="0.01" name="mrp" required>
        </div>
        <div class="form-group">
            <label for="selling_price">Selling Price</label>
            <input type="number" step="0.01" name="selling_price" required>
        </div>
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" name="stock" required>
        </div>
        <div class="form-group">
            <label for="size">Size</label>
            <input type="text" name="size" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="expiration_date">Expiration Date</label>
            <input type="date" name="expiration_date" required>
        </div>
        <div class="form-group">
            <label for="added_on">Added On</label>
            <input type="date" name="added_on" id="added_on" readonly>
        </div>
        <div class="form-group">
            <label for="tags">Tags (comma separated)</label>
            <input type="text" name="tags" required>
        </div>
        <input type="file" name="images" accept="image/*" multiple required />
        <div style="text-align:center;">
            <button type="submit" id="AddNewProductToDatabaseBtn">Add Product</button>
        </div>
    </form>
    <script>
        document.getElementById("productForm").action = "http://localhost:7777/addNewProductToDatabase/"
    </script>
</div>
</body>
</html>
