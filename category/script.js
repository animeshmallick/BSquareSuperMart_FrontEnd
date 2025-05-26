function displayProductsForSubcategory(subcategory) {
    document.querySelectorAll(".product-outer-container").forEach(product => {
        if (product.getAttribute("subcategory") === subcategory) {
            product.style.display = "block";
        }else{
            product.style.display = "none";
        }
    });
}

function handleBackButton() {
    window.location.href = "../home";
}
function displayProduct() {
    document.querySelectorAll('.product-outer-container').forEach(tile => {
        tile.addEventListener('click', function () {
            const productId = this.getAttribute('productId');
            const iframe = document.getElementById('modal-iframe');
            iframe.src = '../products/index.php?productId=' + productId;
            document.getElementById('productModal').style.display = 'flex';
        });
    });
}
function closeModal(){
    document.getElementById('productModal').style.display = 'none';
    document.getElementById('modal-iframe').src = ''; // Clear iframe
    window.location.reload();
}




