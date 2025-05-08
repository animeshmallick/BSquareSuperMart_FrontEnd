document.addEventListener('DOMContentLoaded', function(){
    const param_value = new URLSearchParams(window.location.search).get("productId");
    if (param_value !== null) {
    const productID = Number(param_value);
        if (productID > 0 && !isNaN(productID)) {
            fetch("http://localhost:7777/product/" + productID)
                .then(response => response.json())
                .then(product => {
                    displayProduct(product);
                    updateItemsCountInFooter();
                    addProductQuantityContainer(product[0].productId);
                })
                .then(() => {
                    fetch("http://localhost:7777/similarProducts/" + productID)
                        .then(response => response.json())
                        .then(similarProducts => {
                            displaySimilarProducts(similarProducts);
                        })
                        .catch(err => console.log(err));
                })
                .catch(err => console.log(err));
        } else {
            alert("Invalid Parameters passed. Redirecting to homepage");
                window.location.href = "../home";
        }
    }else{
        alert("Invalid Parameters passed. Redirecting to homepage");
            window.location.href = "../home";
    }
});

function displayProduct(product) {
    const productContainer = document.getElementById('productDetails');
    productContainer.innerHTML = `
        <img src="${product[0].productImg}" alt="${product[0].productName}" class="product-image" />

        <div class="rating">
        <span>⭐⭐⭐⭐⭐</span>
        <span>(2224)</span>
        </div>
    <h2>${product[0].productName}</h2>
    <div>
        <div>
            <div><s>₹${product[0].productMrp}</s></div>
            <div>₹${product[0].productPrice}</div>
            <div>${product[0].productSize}</div>
        </div>
    </div>

    <div id="addProduct_${product[0].productId}">
    
    </div>

    <div class="product-description">
        <div class="productDescriptionTitle"><h3>About the Product</h3></div>
        <div class="section-content">
            <p>${product[0].productDescription}</p>
        </div>
    </div>
   
    `;

}