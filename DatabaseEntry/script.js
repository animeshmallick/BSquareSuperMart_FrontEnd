function addProductToDB(e) {
    const form = e.target;
    console.log(new FormData(form));
    fetch(BACKEND_URI + "/AddNewProductToDatabase",
        {method: "POST",
            headers: {'Content-Type': 'application/json'},
            body: new FormData(form)
        })
        .then(response => response.json())
        .then(data => {
            if (data['message'] === 'Product Added Successfully') {
                alert("Product added!");
                window.location.reload();
                return;
            }
            alert(data['message']);
        })
            .catch(error => console.log(error));
    return false;
}

