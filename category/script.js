document.addEventListener("DOMContentLoaded",function(){
    const category_param = new URLSearchParams(location.search).get("category");
    displayCategoryHeader(category_param);
    fetch(BACKEND_URI + "/category/" + category_param)
        .then(response => response.json())
        .then(data => {
            if (!('error' in data)){
                const subcategories = Object.keys(data);
                displaySidebar(subcategories);
                createProductList(data);
                displayProductsForSubcategory(subcategories[0]);
                refreshCartBar();
            }else{

            }
    })
        .catch(error =>console.log(error));
})

function displayCategoryHeader(category){
    const categoryHeader = document.getElementById("categoryHeader");
    categoryHeader.innerHTML = `
        <div style="display: flex; margin: 0.25rem;">
            <button class="back-button" onclick="handleBackButton()">←</button>
            <div class="category_name">${category}</div>        
        </div>`;
}

function displaySidebar(subcategories){
    const sidebarList = document.getElementById('sidebarList');
    sidebarList.classList.add('sidebar');
    subcategories.forEach( subcategory => {
        const sidebarListItem = document.createElement('div');
        sidebarListItem.innerHTML = `
        <div class="sidebar-subcategory-item" id="${subcategory}">
            <div>
                <img src="https://via.placeholder.com/30" alt="${subcategory}">
            </div>
            <div>
                <h6>${subcategory}</h6>
            </div>   
        </div> `;
        sidebarListItem.addEventListener('click',() => displayProductsForSubcategory(subcategory))
        sidebarList.appendChild(sidebarListItem);
    })
}

function displayProductsForSubcategory(subcategory) {
    document.querySelectorAll(".product-outer-container").forEach(product => {
        if (product.getAttribute("subcategory") === subcategory) {
            product.style.display = "block";
        }else{
            product.style.display = "none";
        }
    });
}

function handleBackButton() {
    window.location.href = "../home";
}

function displayProduct(productId) {
    const iframe = document.getElementById('modal-iframe');
    iframe.src = '../products/index.php?productId=' + productId;
    document.getElementById('productModal').style.display = 'flex';
    document.querySelector('button.close-icon').addEventListener("click", () => {
        closeModal(productId);
    })
}

function closeModal(productId){
    document.getElementById('productModal').style.display = 'none';
    document.getElementById('modal-iframe').src = ''; // Clear iframe
    addProductContainer(productId);

}

function createProductList(products){
    const productsList = document.getElementById("productList");
        Object.entries(products).forEach( ([subcategory,category_products]) => {
            category_products.forEach(product => {
                const productTile = document.createElement('div');
                productTile.classList.add("product-outer-container");
                productTile.style.display = 'none';
                productTile.setAttribute('subcategory', subcategory);
                productTile.setAttribute('productId', product.productId);
                productTile.innerHTML =`
                <div class="image-quantity">
                    <img src="${product.productImg}" class="square-image" alt="${product.productName}"/>
                    <div>
                        <div>${product.productSize}</div>
                        <div><strong>MRP ₹${product.productPrice}</strong> <s>₹${product.productMrp}</s>
                        </div>
                    </div>
                    <div id="addProduct_${product.productId}">
                        
                    </div>
                </div>
                <div>
                    <h5 class="productDescription">${product.productName}</h5>
                </div>`;
                productTile.addEventListener('click', () => displayProduct(product.productId));
                productsList.appendChild(productTile);
                addProductContainer(product.productId);
            });
        });
}




