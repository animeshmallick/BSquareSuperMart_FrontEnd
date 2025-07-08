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

function updateItemsCountInFooter() {
    let cartItemsCount = 0;
    const cartBar = document.getElementById('cartBar');
    const cartSize = document.getElementById('cartItemsCount');
    try {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart.forEach(item => {
            cartItemsCount += item.Quantity;
        });
    } catch (err) {}

    if (cartItemsCount !== 0) {
        cartBar.style.display = "flex";
        cartSize.innerText = cartItemsCount;
    } else {
        cartBar.style.display = "none";
    }
}
function goToCart() {
    window.location.href = "../cart/";
}
function refreshCartBar(){
    setInterval(updateItemsCountInFooter,200);
}
function clearCart(){
    localStorage.removeItem('cart');
}