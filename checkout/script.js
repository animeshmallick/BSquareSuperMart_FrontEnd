fetch(BACKEND_URI + "/cart", {
    method: "POST",
    headers: {"Content-Type": "application/json"},
    body: JSON.stringify(JSON.parse(localStorage.getItem('cart')))
})
    .then(response => {
        if (response.status !== 200) {
            window.location.href = "../cart";
        }
        return response.json();
    })
    .then(cartResponse => {
        updateProductsContainerInCart(cartResponse);
        Alpine.initTree(document.querySelector('.bill-section-wrapper'));
        updateBillDetailsInCart(cartResponse);
    })
    .catch(err => console.log(err));

function incrementProductInCart(productID){
    incrementProductQuantityInCart(productID);
    location.reload();
}
function decrementProductInCart(productID){
    decrementProductQuantityInCart(productID);
    location.reload();
}

//Validate purchase ID and redirect to either thankyou page or order failed page
function placeOrderHandler(){
    const form = document.querySelector("form");
    const cartInput = document.createElement("input");
    cartInput.type = "hidden";
    cartInput.name = "cart";
    cartInput.value = JSON.stringify(JSON.parse(localStorage.getItem('cart')));
    form.appendChild(cartInput);
    form.submit();
}