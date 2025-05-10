document.addEventListener('DOMContentLoaded', () => {
    console.log(JSON.parse(localStorage.getItem('cart')));
    fetch(BACKEND_URI + "/cart",
        {method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: localStorage.getItem('cart')
        })
        .then(response => response.json())
        .then(cart => {
            console.log(cart);
            const cart_items_container = document.getElementById('cart_items_container');
            cart.forEach(product => {
                const cart_item_div = document.createElement('div');
                cart_item_div.innerHTML = `<div class="item-box">
                                                <img src="${product.img}" alt="ProductImage" />
                                                <div class="item-details">
                                                    <div>${product.name}</div>
                                                    <div><strong>${product.size}</strong></div>
                                                    <div><strong>₹${product.price}</strong></div>
                                                </div>
                                                <div class="quantity-control">
                                                    <button>-</button>
                                                    <span>1</span>
                                                    <button>+</button>
                                                </div>
                                            </div>`;
                cart_items_container.appendChild(cart_item_div);
            });
        })
        .catch(err => console.log(err));
});