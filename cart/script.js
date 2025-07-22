document.addEventListener("DOMContentLoaded", () => {
    fetch(BACKEND_URI + "/cart", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify(JSON.parse(localStorage.getItem('cart')))
    })
        .then(response => response.json())
        .then(cartResponse => {
            updateProductsContainerInCart(cartResponse);
            Alpine.initTree(document.querySelector('.bill-section-wrapper'));
            updateBillDetailsInCart(cartResponse);
            updateDeliveryInfo(cartResponse);
        })
        .catch(err => console.log(err));
});

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