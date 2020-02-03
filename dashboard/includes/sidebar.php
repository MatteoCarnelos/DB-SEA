<nav class="col-2 bg-light sidebar">
    <div class="sidebar-sticky d-flex flex-column">
    <div>
        <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?php if($active == 0) echo 'active' ?>" href="./">
            <i data-feather="home"></i>Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($active == 1) echo 'active' ?>" href="reports.php">
            <i data-feather="alert-triangle"></i>Segnalazioni</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($active == 2) echo 'active' ?>" href="medicines.php">
            <i data-feather="book-open"></i>Farmaci</a>
        </li>
        </ul>
    </div>
    <div class="mx-auto mt-auto mb-1">
        <img src="includes/logo-unipd.png" style="width: 75px; height: 75px;" class="img-fluid" alt="Unipd Logo">
    </div>
    <p class="text-muted text-center"><small>Carnelos - Kumar - Provera</small></p>
    </div>
</nav>