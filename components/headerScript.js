let fuse = undefined;
let searchBox = undefined, searchDropdown = undefined;
document.addEventListener("DOMContentLoaded", () => {
    if(fuse === undefined || fuse === null || !fuse) {
        fetch(BACKEND_URI + "/getAllProducts")
            .then(res => res.json())
            .then(data => {
                fuse = new Fuse(data, {
                    keys: ["name", "brand", "category", "subcategory", "description", "tags"],
                    threshold: 0.4,
                    includeScore: true
                });
            })
            .catch(err => {
                console.log("Failed to fetch products from Backend", err);
            });
    }

    try {
        AOS.init();
    }catch (err){}
    fetch('../components/header.php')
        .then(res => res.text())
        .then(data => {
            document.getElementById('page_header').innerHTML = data
            document.getElementById('hamburgerToggle').addEventListener('click', () => {
                document.getElementById('sideNav').classList.add('active');
            });
            document.getElementById('closeNav').addEventListener('click', () => {
                document.getElementById('sideNav').classList.remove('active');
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
                <a href="../products/index.php?productId=${item.id}" class="search-dropdown-item">
                    <img src="${item.image_url}" alt="${item.name}">
                    <div class="item-info">
                    <div class="item-name">${item.name}</div>
                    <div class="item-brand">${item.brand}</div>
                    </div>
                </a>

            `).join('');
                }

                searchDropdown.classList.add("show");
            });
        })
        .catch(err => console.log(err));

    fetch('../components/footer.html')
        .then(res => res.text())
        .then(data => document.getElementById('page_footer').innerHTML = data)
        .catch(err => console.log(err));


    document.addEventListener("click", (e) => {
        if (!searchBox.contains(e.target) && !searchDropdown.contains(e.target)) {
            searchDropdown.classList.remove("show");
        }
    });
});