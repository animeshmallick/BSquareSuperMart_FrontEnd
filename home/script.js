function fill_categories(){
    fetch(BACKEND_URI + "/categories")
        .then(response => response.json())
        .then(categories => {
            const categories_container = document.getElementById("categories");
            Object.entries(categories).forEach(([key, value]) => {
                const title = document.createElement("h5");
                title.classList.add("category-title");
                title.classList.add("wow");
                title.classList.add("fadeInLeft");
                title.innerHTML = key;
                categories_container.appendChild(title);
                const div = document.createElement("div");
                div.classList.add("row");
                value.forEach(product => {
                    console.log(product);
                    const inner_div = document.createElement("div");
                    inner_div.className = "col-4 text-center wow zoomIn category-item";

                    const inner_div_1 = document.createElement("div");
                    inner_div_1.classList.add("category-img-container");

                    const img_container = document.createElement("img");
                    img_container.classList.add("category-img");
                    img_container.width = 100;
                    img_container.alt = product.name;

                    const inner_div_2 = document.createElement("div");
                    inner_div_2.classList.add("category-overlay");

                    const p = document.createElement("p");
                    p.classList.add("category-name");
                    p.innerText = product.name;
                    inner_div_2.appendChild(p);

                    inner_div_1.appendChild(img_container);
                    inner_div_1.appendChild(inner_div_2);

                    inner_div.appendChild(inner_div_1);
                    div.appendChild(inner_div);

                    categories_container.appendChild(div);
                })
            })
        });
}