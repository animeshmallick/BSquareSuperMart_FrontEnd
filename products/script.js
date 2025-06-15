document.addEventListener('DOMContentLoaded', function() {
    const productId_param = new URLSearchParams(location.search).get("productId");
    const urlPath = BACKEND_URI + "/product/" + productId_param;
    fetch(urlPath)
        .then(response => {
            console.log(urlPath);
            console.log(response);
            return response.json(); })
        .then(product => {
            console.log(product);
            if(!('error' in product)) {
                displayProductDetails(product);
                fetch(BACKEND_URI + "/similarProducts/" + productId_param)
                    .then(response => response.json())
                    .then(similarProducts => {
                        displaySimilarProducts(similarProducts);
                })
                    .catch(error =>console.log(error));
            }
        })
})
function displayProductDetails(product){
    const productImage = document.getElementById('productImage');
    productImage.src = `${product.productImg}`;
    productImage.alt = `${product.productName}`;

    document.getElementById('productName').innerHTML =`${product.productName}`;
    document.getElementById('productMrp').innerHTML = `<s>₹${product.productMrp}</s>`;
    document.getElementById('productPrice').innerHTML = `<b>₹${product.productPrice}</b>`;
    document.getElementById('productSize').innerHTML = `${product.productSize}`;
    document.querySelector("div.addProduct").setAttribute(`id`,`addProduct_`+product.productId);
    document.getElementById('productDescription').innerHTML = `${product.productDescription}`;


    addProductContainer(product.productId);
}
function displaySimilarProducts(similarProducts){
    const similarProductsList = document.getElementById("similarProductsList");
    if( similarProducts !== null && Object.keys(similarProducts).length > 0) {
        similarProducts.forEach(product => {
            const productTile = document.createElement("div");
            productTile.classList.add("product-outer-container");
            productTile.setAttribute('productId', product.productId);
            productTile.innerHTML = `
            <img src="${product.productImg}" alt="${product.productName}">
            <div><b>${product.productName}</b></div>
            <div>${product.productSize}</div>
            <div style="display: flex; justify-content: space-between">
                <div>₹ ${product.productPrice}</div>
                <div id="addProductButton">
                    <button class="btn" id="addProductButton" onclick="event.stopPropagation();incrementProductQuantityInCart(${product.productId}); this.closest('.product-outer-container').click();">Add Product</button>
                </div>
            </div>`;
            productTile.addEventListener('click', function(){
                window.location.href ="../products/index.php?productId=" + product.productId;
            });
            similarProductsList.appendChild(productTile);
            // addProductContainer(product.productId);

        });
    }else{
        const productTile = document.createElement('div');
        productTile.innerHTML = "No similar products found";
        similarProductsList.appendChild(productTile);

    }
}