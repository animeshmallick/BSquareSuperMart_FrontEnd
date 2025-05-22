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




