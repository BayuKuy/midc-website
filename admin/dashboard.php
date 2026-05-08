<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard MIDC</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/admin.css">

</head>
<body>

    <?php include '../includes/sidebar.php'; ?>

    <div class="main-content">
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <?php include '../includes/navbar_admin.php'; ?>

        <div class="container-fluid p-4">

            <h3 class="fw-bold mb-4">
                Dashboard MIDC
            </h3>

            <div class="row">

                <div class="col-md-4 mb-4">

                    <div class="dashboard-card">

                        <div>
                            <h5>Total Berita</h5>
                            <h2>12</h2>
                        </div>

                        <i class="fa-solid fa-newspaper dashboard-icon"></i>

                    </div>

                </div>

                <div class="col-md-4 mb-4">

                    <div class="dashboard-card">

                        <div>
                            <h5>Total Event</h5>
                            <h2>5</h2>
                        </div>

                        <i class="fa-solid fa-calendar dashboard-icon"></i>

                    </div>

                </div>

                <div class="col-md-4 mb-4">

                    <div class="dashboard-card">

                        <div>
                            <h5>Program Kerja</h5>
                            <h2>9</h2>
                        </div>

                        <i class="fa-solid fa-layer-group dashboard-icon"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- JS -->
    <script src="../assets/js/admin.js"></script>

</body>
</html>