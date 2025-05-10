function addProductToDB() {
        let productJson = {};

        const form = document.getElementById('productForm');
        const inputs = form.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                productJson[input.name] = input.value;
            });
            fetch(BACKEND_URI + "/AddNewProductToDatabase",
                {method: "POST",
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(productJson)
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

