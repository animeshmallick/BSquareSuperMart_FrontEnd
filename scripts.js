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

function updateProductsContainerInCart(cartResponse) {
    const productsContainer = document.getElementById("cart_items_container");
    productsContainer.innerHTML = ""; // Clear previous items

    if (cartResponse.products.length === 0) {
        const productContainer = document.createElement("div");
        productContainer.classList.add("text-center", "text-gray-500", "text-lg", "py-10");
        productContainer.innerHTML = `<div class="empty-cart">🛒 Your cart is empty.</div>`;
        productsContainer.appendChild(productContainer);
        return;
    }

    // Apply modern grid layout
    productsContainer.className = "grid md:grid-cols-3 gap-6";

    cartResponse.products.forEach(product => {
        const productContainer = document.createElement("div");
        productContainer.className = "bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-transform transform hover:scale-105 flex flex-col";

        productContainer.innerHTML = `
        <div style="display: flex">
        <div style="width: 30%">
      <img src="${product.image_url}" alt="${product.name}" class="w-full object-contain bg-gray-100 p-2">
      </div>
      <div>
      <div class="p-4 flex flex-col flex-grow justify-between">
        <div>
          <h4 class="font-semibold text-lg text-gray-800">${product.name}</h4>
          <p class="text-sm text-gray-500 mb-2">${product.size}</p>
          <div class="text-blue-600 font-bold text-xl">
            ₹${product.selling_price}
          </div>
        </div>
        <div class="mt-4 flex justify-center">
          <div class="flex items-center gap-4 px-4 py-2 bg-gray-100 rounded-full shadow-inner">
            <button
              class="w-8 h-8 rounded-full bg-blue-100 hover:bg-blue-200 text-blue-700 text-xl font-bold transition-all duration-200"
              onclick="decrementProductInCart(${product.id})"
              aria-label="Decrease Quantity"
            >−</button>
            <span class="min-w-[24px] text-center text-lg font-semibold">${product.quantity}</span>
            <button
              class="w-8 h-8 rounded-full bg-blue-100 hover:bg-blue-200 text-blue-700 text-xl font-bold transition-all duration-200"
              onclick="incrementProductInCart(${product.id})"
              aria-label="Increase Quantity"
            >+</button>
          </div>
        </div>
      </div>
      </div>
      </div>
    `;

        productsContainer.appendChild(productContainer);
    });
}


function updateBillDetailsInCart(cartResponse) {
    const billContainer = document.querySelector("div.bill-section-wrapper");

    billContainer.innerHTML = `
    <div x-data="{ open: false }" class="border border-gray-300 rounded-lg overflow-hidden shadow-sm">
      
      <!-- Header (Click to toggle) -->
      <button @click="open = !open"
              class="w-full flex justify-between items-center px-4 py-3 bg-green-100 text-green-700 font-semibold cursor-pointer transition">
        <span>💰 Bill Summary</span>
        <svg :class="open ? 'rotate-180' : ''" class="h-5 w-5 transform transition-transform duration-200"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7" />
        </svg>
      </button>

      <!-- Collapsible content -->
      <div x-show="open" x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-screen"
           x-transition:leave="transition ease-in duration-200"
           x-transition:leave-start="opacity-100 max-h-screen" x-transition:leave-end="opacity-0 max-h-0"
           class="px-4 py-3 bg-white overflow-hidden space-y-2 text-sm">

        <div class="flex justify-between"><span>🛒 Items total</span><span>₹${cartResponse.bill.cart_items_total.toFixed(2)}</span></div>
        <div class="flex justify-between"><span>🚚 Delivery charge</span><span>₹${cartResponse.bill.delivery_fee}</span></div>
        <div class="flex justify-between"><span>📦 Packaging charge</span><span>₹${cartResponse.bill.packaging_fee}</span></div>
        <div class="flex justify-between"><span>🖥️ Platform charge</span><span>₹${cartResponse.bill.platform_fee}</span></div>
        <div class="flex justify-between"><span>🧺 Small cart charge</span><span>₹${cartResponse.bill.small_cart_fee ?? 0}</span></div>
        <div class="flex justify-between"><span>🔒 Restricted cart charge</span><span>₹${cartResponse.bill.restricted_cart_fee ?? 0}</span></div>
        <hr class="my-2">
      </div>

      <!-- Total always visible -->
      <div class="px-4 py-3 bg-yellow-100 flex justify-between items-center text-lg font-bold">
        <span>Total</span><span>₹${cartResponse.bill.total_bill}</span>
      </div>
    </div>
  `;

    const grandTotalDiv = document.querySelector("div.grand-total");
    if (grandTotalDiv)
        grandTotalDiv.innerHTML = `Grand Total: ₹${cartResponse.bill.total_bill}`;
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