document.addEventListener("DOMContentLoaded", () => {
    const cartData = JSON.parse(localStorage.getItem('cart'));
    const cartItemsContainer = document.getElementById('cart_items_container');
    const grandTotalBox = document.querySelector('.grand-total');
    const paySummaryBox = document.querySelector(".pay-summary-box");
    const deliveryInfoBox = document.querySelector(".delivery-info-box");
    const billSectionWrapper = document.querySelector(".bill-section-wrapper");
    // Removed policyBox from here as its display is now handled by the <details> tag itself

    // Check if cart is empty or null, or if it's an empty object
    if (!cartData || Object.keys(cartData).length === 0) {
        cartItemsContainer.innerHTML = `
            <div class="empty-cart-message" data-aos="zoom-in" data-aos-duration="800">
                <span class="empty-cart-emoji">🛒</span><br>
                Your cart is empty!
                <p class="empty-cart-subtext">Start shopping to add items.</p>
            </div>
        `;
        // Hide all other cart-related sections
        if (deliveryInfoBox) deliveryInfoBox.style.display = 'none';
        if (billSectionWrapper) billSectionWrapper.style.display = 'none';
        // Hide the policy details box container when cart is empty
        const policyDetailsBox = document.querySelector(".policy-details-box");
        if (policyDetailsBox) policyDetailsBox.style.display = 'none';
        if (paySummaryBox) paySummaryBox.style.display = 'none';

        return; // Stop further execution if cart is empty
    }

    // If cart is not empty, proceed with fetching cart details
    fetch(BACKEND_URI + "/cart", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify(cartData)
    })
        .then(response => response.json())
        .then(cartResponse => {
            // Additional check for empty products array from backend response
            if (!cartResponse.products || cartResponse.products.length === 0) {
                cartItemsContainer.innerHTML = `
                <div class="empty-cart-message" data-aos="zoom-in" data-aos-duration="800">
                    <span class="empty-cart-emoji">🛒</span><br>
                    Your cart is empty!
                    <p class="empty-cart-subtext">Start shopping to add items.</p>
                </div>
            `;
                // Hide all other cart-related sections
                if (deliveryInfoBox) deliveryInfoBox.style.display = 'none';
                if (billSectionWrapper) billSectionWrapper.style.display = 'none';
                // Hide the policy details box container when cart is empty
                const policyDetailsBox = document.querySelector(".policy-details-box");
                if (policyDetailsBox) policyDetailsBox.style.display = 'none';
                if (paySummaryBox) paySummaryBox.style.display = 'none';
                return;
            }

            updateProductsContainerInCart(cartResponse);
            // Alpine.initTree is for Alpine.js; ensure it's loaded if you use it.
            // If not, this line can be removed or Alpine.js should be included.
            // Alpine.initTree(document.querySelector('.bill-section-wrapper'));
            updateBillDetailsInCart(cartResponse);
            updateDeliveryInfo(cartResponse);

            // Update grand total display here for non-empty cart
            if (cartResponse.totalAmount !== undefined) {
                grandTotalBox.textContent = `Grand Total: ₹${cartResponse.totalAmount.toFixed(2)}`;
            }
        })
        .catch(err => console.log(err));
});

function updateDeliveryInfo(cartResponse){
    // Ensure this only updates if the element exists and cartResponse.products is available
    const deliveryInfoBox = document.querySelector("div.delivery-info-box");
    if (deliveryInfoBox && cartResponse && cartResponse.products) {
        deliveryInfoBox.innerHTML = `Delivery in 13 minutes <br /> Shipment of ${cartResponse.products.length} item(s)`;
    }
}

function incrementProductInCart(productID){
    incrementProductQuantityInCart(productID);
    location.reload();
}
function decrementProductInCart(productID){
    decrementProductQuantityInCart(productID);
    location.reload();
}