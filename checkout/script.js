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
function displaySelectedAddress(addressId){

}