<nav class="top-navbar">
 <button class="toggle-btn" id="openSidebar">
    <i class="fa-solid fa-bars"></i>
 </button>   

 <div class="navbar-profile">
    <span>
        <?= $_SESSION['nama']; ?>
    </span>

    <img src="https://ui-avatars.com/api?name=<?= $_SESSION['nama']; ?>" alt="">
 </div>
</nav>