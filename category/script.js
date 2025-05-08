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
});
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
                    <h5 class="productDescription">${product.productName}</h5>
                </div>
            `;
            productList.appendChild(listItem);
            addProductQuantityContainer(product.productId);
        });
    }
}

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



