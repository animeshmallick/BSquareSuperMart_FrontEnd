function addProductContainer(productId) {
    const addProductButton = document.getElementById("addProduct_"+productId);
    addProductButton.innerHTML = "";
    const productQuantityInCart = getProductCartQuantity(productId);
    if(productQuantityInCart === 0){
        const button = document.createElement('button');
        button.classList.add('btn');
        button.innerHTML = 'Add Product';
        button.addEventListener('click', () => {
            incrementProductQuantityInCart(productId);
            addProductContainer(productId); //Re-renders the Add Product div
        });
        addProductButton.appendChild(button);
    }else{
        const productQuantity = document.createElement('div');
        productQuantity.classList.add('productCounter');

        const decrementBtn = document.createElement('button');
        decrementBtn.classList.add('decrementBtn');
        decrementBtn.textContent = '-';
        decrementBtn.addEventListener('click', () => {
            decrementProductQuantityInCart(productId);
            addProductContainer(productId);
            // updateItemsCountInFooter();
        });

        const productQuantitySpan = document.createElement('span');
        productQuantitySpan.textContent = (productQuantityInCart).toString();

        const incrementBtn = document.createElement('button');
        incrementBtn.classList.add('incrementBtn');
        incrementBtn.textContent = '+';
        incrementBtn.addEventListener('click',() => {
            incrementProductQuantityInCart(productId);
            addProductContainer(productId);
            // updateItemsCountInFooter();
        });

        productQuantity.appendChild(decrementBtn);
        productQuantity.appendChild(productQuantitySpan);
        productQuantity.appendChild(incrementBtn);

        addProductButton.appendChild(productQuantity);
    }
}
function getProductCartQuantity(productId) {
    try {
        const cart = JSON.parse(localStorage.getItem('cart'));
        for (let i = 0; i < cart.length; i++) {
            const item = cart[i];
            if (item.ProductID === productId) {
                //Product_ID exists in 'cart'. Return the respective product quantity.
                return item.Quantity;
            }
        }
        //Product_ID does not exist in 'cart'. Return '0'
        return 0;
    } catch (Err) {
        //'cart' does not exist in localstorage.
        return 0;
    }
}

function decrementProductQuantityInCart(productId){
    event.stopPropagation();
    const cart = JSON.parse(localStorage.getItem('cart'));
    for(let i = 0; i < cart.length; i++) {
        const item = cart[i];
        if (item.ProductID === productId) {
            if (item.Quantity > 0)
                item.Quantity -= 1;
            if (item.Quantity === 0)
                cart.splice(i, 1);
            break;
        }
    }
    if (cart.length > 0) {
        localStorage.setItem('cart', JSON.stringify(cart));
    }else{
        localStorage.removeItem('cart');
    }
}

function incrementProductQuantityInCart(productId){
    event.stopPropagation();
    let cart = localStorage.getItem('cart');
    cart = JSON.parse(cart);

    if (cart === null) {
        const cartItem= [{"ProductID":productId, "Quantity": 1}];
        localStorage.setItem('cart', JSON.stringify(cartItem));
    }else{
        let count = 0;
        for(let i = 0; i < cart.length; i++) {
            const item = cart[i];
            if(item.ProductID === productId){
                cart[i].Quantity += 1;
                count += 1;
                break;
            }
        }
        if(count === 0) {
            cart[cart.length]= {"ProductID":productId, "Quantity": 1};
        }
            localStorage.setItem('cart', JSON.stringify(cart));
    }
}

function updateItemsCountInFooter(){
    let cartItemsCount = 0;
    const cartBar = document.getElementById('cartBar');
    const cartSize = document.getElementById('cartItemsCount');
    try {
        const cart = JSON.parse(localStorage.getItem('cart'));
        cart.forEach((item) => {
            cartItemsCount += item.Quantity;
        });
    }catch(Err){}
    if(!cartBar || !cartSize)
        return;
    if (cartItemsCount !== 0){  //Display cart bar only if there are items added in the cart
        // const cartSize = document.getElementById('cartItemsCount');
        cartBar.style.display = "flex";
        cartSize.innerText = cartItemsCount;
    }else{  //If no items in cart then hide the cart bar
        cartBar.style.display = "none";
    }
}
function refreshCartBar(){
    setInterval(updateItemsCountInFooter,200);
}