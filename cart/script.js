function redirectCartWithPostCall() {
    const form = document.createElement('form');
    form.action = "";
    form.method = "POST";

    const cart_value = document.createElement('input');
    cart_value.type = "hidden";
    cart_value.name = 'cart';
    cart_value.value = localStorage.getItem('cart');
    form.appendChild(cart_value);

    document.body.appendChild(form);
    form.submit();
}