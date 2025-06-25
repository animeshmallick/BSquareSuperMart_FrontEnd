let products = [];
let fuse;
let searchBox = undefined, searchDropdown = undefined;
document.addEventListener("DOMContentLoaded", () => {
    fetch(BACKEND_URI + "/getAllProducts")
        .then(res => res.json())
        .then(data => {
            products = data;
            fuse = new Fuse(products, {
                keys: ["name", "brand", "category", "subcategory", "description", "tags"],
                threshold: 0.4,
                includeScore: true
            });
        })
        .catch(err => {
            console.log("Failed to fetch products from Backend");
        });

    searchBox = document.querySelector("input.search-bar");
    searchDropdown = document.getElementById("searchResults");

    searchBox.addEventListener("input", () => {
        const query = searchBox.value.trim();
        if (!query) {
            searchDropdown.innerHTML = '';
            searchDropdown.classList.remove('show');
            return;
        }

        const results = fuse.search(query).slice(0, 6); // Top 6 results
        if (results.length === 0) {
            searchDropdown.innerHTML = `<div class="dropdown-item text-muted">No products found</div>`;
        } else {
            searchDropdown.innerHTML = results.map(({ item }) => `
                <a href="../products/index.php?productId=${item.id}" class="dropdown-item d-flex align-items-center">
                    <img src="${item.image_url}" alt="${item.name}" style="width:40px; height:40px; object-fit:cover; margin-right:10px;">
                    <div>
                        <div><strong>${item.name}</strong></div>
                        <small class="text-muted">${item.brand}</small>
                    </div>
                </a>
            `).join('');
        }

        searchDropdown.classList.add("show");
    });
    document.addEventListener("click", (e) => {
        if (!searchBox.contains(e.target) && !searchDropdown.contains(e.target)) {
            searchDropdown.classList.remove("show");
        }
    });
});