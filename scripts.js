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

function addProductQuantityContainer(productId) {
    const productQuantityInCart = getProductCartQuantity(productId);
    if(productQuantityInCart === 0){
        const button = document.createElement('button');
        button.classList.add('btn');
        button.innerText = 'Add Product';
        button.onclick = () => addProduct(productId);

        const addProductButton = document.getElementById("addProduct_"+productId);
        addProductButton.innerHTML = "";
        addProductButton.appendChild(button);
    }else{
        const updateProductQuantity = document.createElement('div');
        updateProductQuantity.classList.add('productCounter');

        const decrementBtn = document.createElement('button');
        decrementBtn.classList.add('decrementBtn');
        decrementBtn.textContent = '-';
        decrementBtn.onclick = () => decrementProductQuantityInCart(productId);

        const productQuantitySpan = document.createElement('span');
        productQuantitySpan.textContent = (productQuantityInCart).toString();

        const incrementBtn = document.createElement('button');
        incrementBtn.classList.add('incrementBtn');
        incrementBtn.textContent = '+';
        incrementBtn.onclick = () => incrementProductQuantityInCart(productId);

        updateProductQuantity.appendChild(decrementBtn);
        updateProductQuantity.appendChild(productQuantitySpan);
        updateProductQuantity.appendChild(incrementBtn);

        const addProductButton = document.getElementById("addProduct_"+productId);
        addProductButton.innerHTML = "";
        addProductButton.appendChild(updateProductQuantity);
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

function displaySimilarProducts(similarProducts){
    const similarProductsList = document.getElementById('similarProductsList');
        similarProducts.forEach(product => {
            const productTile = document.createElement('div');
            productTile.classList.add('productTile');
            productTile.innerHTML = `
                <img src="${product.productImg}" alt="${product.productName}">
                <div><b>${product.productName}</b></div>
                <div>${product.productSize}</div>
                <div style="display: flex; justify-content: space-between">
                    <div>₹ ${product.productPrice}</div>
                    <div id="addProduct_${product.productId}">
                </div>  
                </div>
            `;
            similarProductsList.appendChild(productTile);
            addProductQuantityContainer(product.productId);

        });
}