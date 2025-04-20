function displayProducts(products, subcategory) {
    const productList = document.getElementById('productList');
    const nextProducts = products[subcategory] && products[subcategory].length > 0 ? products[subcategory] : [];

    if (nextProducts.length === 0) {
        productList.innerHTML = "<p>No products available for this category.</p>";
    } else {
        nextProducts.forEach((product, index) => {
            product.quantity = 0;
            const listItem = document.createElement('div');
            listItem.innerHTML = `
                        <div class="image-quantity">
                            <img src="${product.imgSrc}" class="square-image" alt="${product.name}">
                            <div>
                                <div>${product.size} </div>
                                <div><strong>MRP ₹${product.price}</strong> <s>₹${product.oldPrice}</s></div>
                            </div>
                            <button class="btn">Add</button>
                        </div>
                        <div class="flex-grow-1">
                            <h5>${product.name}</h5>
                        </div>
                `;
            productList.appendChild(listItem);
        });
    }
}

function displaySidebar(products) {
    const sidebarList = document.getElementById('sidebarList');
    const subcategories = Object.keys(products);
    subcategories.forEach(subcategory => {
        const item = document.createElement('div');
        item.classList.add('sidebar-item');
        item.setAttribute('data-category', subcategory);
        item.innerHTML = `<img src="https://via.placeholder.com/30" alt="${subcategory}"> <h6>${subcategory}</h6>`;
        sidebarList.appendChild(item);

        item.addEventListener('click', () => {
            document.querySelectorAll('.sidebar-item').forEach(i => i.classList.remove('active'));
            item.classList.add('active');
            document.getElementById('productList').innerHTML = '';
            displayProducts(products,subcategory);
        });
    });
}
const sub_category_param = new URLSearchParams(window.location.search).get("category");
fetch("http://localhost:7777/category/"+sub_category_param)
    .then(response => response.json())
    .then(products => {
        displaySidebar(products);
        displayProducts(products, Object.keys(products)[0]);
    })
    .catch(err => console.log(err))
    .catch(err => console.error("CORS error?", err));
