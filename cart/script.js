document.addEventListener("DOMContentLoaded", () => {
    fetch(BACKEND_URI + "/cart", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify(JSON.parse(localStorage.getItem('cart')))
    })
        .then(response => response.json())
        .then(cartResponse => {
            updateProductsContainerInCart(cartResponse);
            updateBillDetailsInCart(cartResponse);
            updateDeliveryInfo(cartResponse);
        })
        .catch(err => console.log(err));
});

function updateProductsContainerInCart(cartResponse){
    const productsContainer = document.getElementById("cart_items_container");
    if(cartResponse.products.length === 0){
        const productContainer = document.createElement("div");
        productContainer.classList.add("item-box");
        productContainer.innerHTML = `<div class="empty-cart">Empty Cart.</div>`;
        return;
    }
    cartResponse.products.forEach(product => {
        const productContainer = document.createElement("div");
        productContainer.classList.add("item-box");
        productContainer.innerHTML = `
                    <img src="${product.image_url}" alt="Product Image">
                    <div class="item-details">
                        <div>${product.name}</div>
                        <div><strong>${product.size}</strong></div>
                        <div><strong>₹${product.selling_price}</strong></div>
                    </div>
                    <div class="quantity-control">
                        <button class="qty-btn" onclick="decrementProductInCart(${product.id})">-</button>
                        <span>${product.quantity}</span>
                        <button class="qty-btn" onclick="incrementProductInCart(${product.id})">+</button>
                    </div>
                `;
        productsContainer.appendChild(productContainer);
    });
}
function updateBillDetailsInCart(cartResponse){
    const billContainer = document.querySelector("div.bill-section-wrapper");
    billContainer.innerHTML = `
                <div class="bill-section-title">Bill Details</div>
                <div class="bill-line"><span>🛒 Items total</span><span>₹${cartResponse.bill.cart_items_total.toFixed(2)}</span></div><hr>
                <div class="bill-line"><span>🚚 Delivery charge</span><span>₹${cartResponse.bill.delivery_fee}</span></div>
                <div class="bill-line"><span>📦 Packaging charge</span><span>₹${cartResponse.bill.packaging_fee}</span></div>
                <div class="bill-line"><span>🖥️ Platform charge</span><span>₹${cartResponse.bill.platform_fee}</span></div>
                <div class="bill-line"><span>🧺 Small cart charge</span><span>₹${cartResponse.bill.hasOwnProperty("small_cart_fee") ? cartResponse.bill.small_cart_fee : 0}</span></div>
                <div class="bill-line"><span>🔒 Restricted cart charge</span><span>₹${cartResponse.bill.hasOwnProperty("restricted_cart_fee") ? cartResponse.bill.restricted_cart_fee : 0}</span></div><hr>
                <div class="total-bill-line total-bill-box">
                    <span>Total</span><span><strong>₹${cartResponse.bill.total_bill}</strong></span>
                </div>
            `;
    document.querySelector("div.grand-total").innerHTML = `Grand Total: ₹${cartResponse.bill.total_bill}`
}
function updateDeliveryInfo(cartResponse){
    document.querySelector("div.delivery-info-box").innerHTML = `Delivery in 13 minutes <br /> Shipment of ${cartResponse.products.length} items(s)`
}
function incrementProductInCart(productID){
    incrementProductQuantityInCart(productID);
    location.reload();
}
function decrementProductInCart(productID){
    decrementProductQuantityInCart(productID);
    location.reload();
}