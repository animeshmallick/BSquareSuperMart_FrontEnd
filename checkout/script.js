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
    const formData = new URLSearchParams();
    formData.append('cart', localStorage.getItem('cart'));
    fetch('placeOrderHandler.php', {
            method: "POST",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'Order Placed Success'){
                localStorage.removeItem('cart');
                window.location.href = `../thankyou/index.php?PID=${data.PID}`;
            }else{
                window.location.href = "../orderFailed";
            }
        })
        .catch(err => console.log(err));
}