document.addEventListener("DOMContentLoaded", function(){

    const sidebar = document.getElementById("sidebar");

    const openSidebar = document.getElementById("openSidebar");

    const closeSidebar = document.getElementById("closeSidebar");

    const overlay = document.getElementById("sidebarOverlay");

    // OPEN SIDEBAR
    openSidebar.addEventListener("click", function(){

        sidebar.classList.add("show");

        overlay.classList.add("show");

    });

    // CLOSE SIDEBAR
    closeSidebar.addEventListener("click", closeSidebarMenu);

    overlay.addEventListener("click", closeSidebarMenu);

    function closeSidebarMenu(){

        sidebar.classList.remove("show");

        overlay.classList.remove("show");

    }

});