// Assuming BACKEND_URI is defined in ../scripts.js or similar
// const BACKEND_URI = 'your_backend_api_url';

document.addEventListener('DOMContentLoaded', function () {
    const productId = new URLSearchParams(location.search).get("productId");
    fetch(`${BACKEND_URI}/product/${productId}`)
        .then(res => res.json())
        .then(product => {
            if (!product.error) {
                displayProductDetails(product);
                fetch(`${BACKEND_URI}/similarProducts/${productId}`)
                    .then(res => res.json())
                    .then(displaySimilarProducts)
                    .catch(console.error);
            }
        })
        .catch(console.error); // Catch potential errors during initial product fetch
});

function displayProductDetails(product) {
    document.getElementById('productImage').src = product.productImg;
    document.getElementById('productImage').alt = product.productName;
    document.getElementById('productName').textContent = product.productName;
    document.getElementById('productMrp').innerHTML = `<s>₹${product.productMrp}</s>`;
    document.getElementById('productPrice').innerHTML = `<b>₹${product.productPrice}</b>`;
    document.getElementById('productSize').textContent = product.productSize;
    document.querySelector("div.addProduct").setAttribute("id", `addProduct_${product.productId}`);
    document.getElementById('productDescription').innerHTML = product.productDescription;

    // Assuming addProductContainer is defined in ../scripts.js or similar
    // It might dynamically add buttons based on cart status
    if (typeof addProductContainer === 'function') {
        addProductContainer(product.productId);
    } else {
        // Fallback if addProductContainer is not defined or loaded yet
        document.querySelector("div.addProduct").innerHTML = `
            <button class="btn btn-success" onclick="incrementProductQuantityInCart(${product.productId});">Add to Cart</button>
        `;
    }
}

function displaySimilarProducts(products) {
    const container = document.getElementById("similarProductsList");
    container.innerHTML = ""; // Clear previous content

    if (!products || products.length === 0) {
        container.innerHTML = "<div class='text-muted'>No similar products found.</div>";
        return;
    }

    products.forEach(product => {
        const col = document.createElement("div");
        col.className = "col-6 col-md-4 col-lg-3";

        col.innerHTML = `
            <div class="product-outer-container" productId="${product.productId}">
                <img src="${product.productImg}" alt="${product.productName}">
                <div><b>${product.productName}</b></div>
                <div>${product.productSize}</div>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <div class="text-success fw-semibold">₹ ${product.productPrice}</div>
                    <button class="btn btn-sm btn-success" onclick="event.stopPropagation(); incrementProductQuantityInCart(${product.productId});">Add</button>
                </div>
            </div>`;

        col.querySelector(".product-outer-container").addEventListener("click", () => {
            window.location.href = `../products/index.php?productId=${product.productId}`;
        });

        container.appendChild(col);
    });
}