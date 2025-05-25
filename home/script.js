document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.getElementById("userMenu");
    const openBtn = document.getElementById("openSidebar");
    const closeBtn = document.getElementById("closeSidebar");

    function openSidebar() {
        sidebar.classList.add("show");          // Show sidebar
        sidebar.removeAttribute("aria-hidden"); // Make visible to screen readers
        sidebar.removeAttribute("inert");       // Make focusable/interactable
        sidebar.focus();                        // Optional: focus for accessibility

        openBtn.style.display = "none";
        closeBtn.style.display = "inline-block";
    }

    function closeSidebar() {
        sidebar.classList.remove("show");       // Hide sidebar
        sidebar.setAttribute("aria-hidden", "true");
        sidebar.setAttribute("inert", "");      // Disable interactions

        openBtn.style.display = "inline-block";
        closeBtn.style.display = "none";
    }

    openBtn.addEventListener("click", openSidebar);
    closeBtn.addEventListener("click", closeSidebar);
});
