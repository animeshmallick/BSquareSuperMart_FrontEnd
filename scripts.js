function addProduct(productId) {
    let cart = localStorage.getItem('cart');

    if (cart === null) {
        const cartItem= [{"ProductID":productId, "Quantity": 1}];
        localStorage.setItem('cart', JSON.stringify(cartItem));
    }else{
        cart = JSON.parse(cart);
        cart.push({"ProductID":productId , "Quantity":1});
        localStorage.setItem('cart', JSON.stringify(cart));
    }
    updateProductQuantityContainer(productId);
}

function decrementProductQuantityInCart(productId){
    const cart = JSON.parse(localStorage.getItem('cart'));
    for(let i = 0; i < cart.length; i++) {
        const item = cart[i];
        if (item.ProductID === productId) {
            if (item.Quantity > 0)
                item.Quantity -= 1;
            if (item.Quantity === 0)
                cart.splice(i, 1);
        }
    }
    if (cart.length > 0) {
        localStorage.setItem('cart', JSON.stringify(cart));
    }else{
        localStorage.removeItem('cart');
    }
    updateProductQuantityContainer(productId);
}

function incrementProductQuantityInCart(productId){
    const cart = JSON.parse(localStorage.getItem('cart'));
    for(let i = 0; i < cart.length; i++) {
        const item = cart[i];
        if(item.ProductID === productId){
            item.Quantity += 1;
            break;
        }
    }
    localStorage.setItem('cart', JSON.stringify(cart));
    updateProductQuantityContainer(productId);
}

function updateProductQuantityContainer(productId){
    addProductQuantityContainer(productId);
    updateItemsCountInFooter();
}

function updateItemsCountInFooter(){
    let cartItemsCount = 0;
    try {
        const cart = JSON.parse(localStorage.getItem('cart'));
        cart.forEach((item) => {
            cartItemsCount += item.Quantity;
        });
    }catch(Err){}
    const cartSize = document.getElementById('cartItemsCount');
    cartSize.innerText = cartItemsCount;
}