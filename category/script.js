document.addEventListener('DOMContentLoaded', () => {
    const sub_category_param = new URLSearchParams(window.location.search).get("category");
    fetch("http://localhost:7777/category/"+sub_category_param)
        .then(response => response.json())
        .then(products => {
            displaySidebar(products);
            displayProductList(products, Object.keys(products)[0]);
            updateItemsCountInFooter();
        })
        .catch(err => console.log(err));
})
function displayProductList(products, product_subcategory) {
    const productList = document.getElementById('productList');
    const eligibleProducts = products[product_subcategory] && products[product_subcategory].length > 0 ?
                                     products[product_subcategory] :
                                     [];
    if (eligibleProducts.length === 0) {
        productList.innerHTML = "<p>No products available for this category.</p>";
    } else {
        eligibleProducts.forEach((product, index) => {
            const listItem = document.createElement('div');
            listItem.innerHTML = `
                <div class="image-quantity">
                    <img src="${product.productImg}" class="square-image" alt="${product.productName}">
                    <div>
                        <div>${product.productSize} </div>
                        <div><strong>MRP ₹${product.productPrice}</strong> <s>₹${product.productMrp}</s></div>
                    </div>
                    <div id="addProduct_${product.productId}">
                    
                    </div>
                </div>
                <div>
                    <h5>${product.productName}</h5>
                </div>
            `;
            productList.appendChild(listItem);
            addProductQuantityContainer(product.productId);
        });
    }
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

// function refreshAddProductButton(productQuantityInCart,productId,index) {
//     document.getElementById('addProduct_'+index).innerHTML = ``;
//     addProductButton(productQuantityInCart,productId,index);
// }
function displaySidebar(products) {
    const sidebarList = document.getElementById('sidebarList');
    const subcategories = Object.keys(products);
    subcategories.forEach(subcategory => {
        const item = document.createElement('div');
        item.classList.add('sidebar-item');
        item.innerHTML = `<img src="https://via.placeholder.com/30" alt="${subcategory}"> <h6>${subcategory}</h6>`;
        sidebarList.appendChild(item);

        item.addEventListener('click', () => {
            document.querySelectorAll('.sidebar-item').forEach(i => i.classList.remove('active'));
            item.classList.add('active');
            document.getElementById('productList').innerHTML = '';
            displayProductList(products,subcategory);
        });
    });
}



