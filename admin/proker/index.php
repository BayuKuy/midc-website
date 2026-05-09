<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location: ../login.php");
    exit;
}

include '../../config/koneksi.php';

/*
|--------------------------------------------------------------------------
| FLASH MESSAGE
|--------------------------------------------------------------------------
*/

$success = "";

$error = "";

if(isset($_SESSION['success'])){

    $success = $_SESSION['success'];

    unset($_SESSION['success']);

}

if(isset($_SESSION['error'])){

    $error = $_SESSION['error'];

    unset($_SESSION['error']);

}

/*
|--------------------------------------------------------------------------
| AMBIL DATA PROGRAM
|--------------------------------------------------------------------------
*/

$query = mysqli_query($conn, "SELECT * FROM program_kerja ORDER BY id_program DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Kerja MIDC</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="../../assets/css/admin.css">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>

        .page-header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:30px;
            flex-wrap:wrap;
            gap:15px;
        }

        .btn-add{
            background:#2563eb;
            color:white;
            border:none;
            padding:12px 18px;
            border-radius:12px;
            text-decoration:none;
            transition:0.3s;
        }

        .btn-add:hover{
            background:#1d4ed8;
            color:white;
        }

        /* Program Card */

        .program-card{
            background:white;
            border-radius:24px;
            overflow:hidden;
            box-shadow:0 5px 20px rgba(0,0,0,0.05);
            transition:0.3s;
            height:100%;
        }

        .program-card:hover{
            transform:translateY(-5px);
        }

        .program-image{
            width:100%;
            height:220px;
            object-fit:cover;
        }

        .program-content{
            padding:22px;
        }

        .program-division{
            font-size:13px;
            color:#2563eb;
            font-weight:600;
            margin-bottom:8px;
        }

        .program-title{
            font-size:21px;
            font-weight:700;
            color:#0f172a;
            margin-bottom:15px;
        }

        /* Badge */

        .status-badge{
            display:inline-block;
            padding:7px 14px;
            border-radius:999px;
            font-size:12px;
            font-weight:600;
            margin-bottom:18px;
        }

        .planning{
            background:#fef3c7;
            color:#d97706;
        }

        .running{
            background:#dbeafe;
            color:#2563eb;
        }

        .done{
            background:#dcfce7;
            color:#16a34a;
        }

        /* Progress */

        .progress-label{
            display:flex;
            justify-content:space-between;
            margin-bottom:8px;
            font-size:14px;
            color:#475569;
        }

        .progress{
            height:10px;
            border-radius:999px;
            margin-bottom:18px;
        }

        /* Timeline */

        .timeline{
            font-size:14px;
            color:#64748b;
            margin-bottom:20px;
        }

        /* Footer */

        .program-footer{
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .action-btn{
            display:flex;
            gap:10px;
        }

        .btn-detail,
        .btn-edit,
        .btn-delete{
            width:38px;
            height:38px;
            border:none;
            border-radius:10px;
            display:flex;
            justify-content:center;
            align-items:center;
            text-decoration:none;
        }

        .btn-detail{
            background:#ede9fe;
            color:#7c3aed;
        }

        .btn-edit{
            background:#dbeafe;
            color:#2563eb;
        }

        .btn-delete{
            background:#fee2e2;
            color:#dc2626;
        }

    </style>

</head>
<body>

<?php include '../../includes/sidebar.php'; ?>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="main-content">

<?php include '../../includes/navbar_admin.php'; ?>

<div class="container-fluid p-4">

    <!-- HEADER -->

    <div class="page-header">

        <div>

            <h3 class="fw-bold mb-1">
                Program Kerja MIDC
            </h3>

            <p class="text-secondary">
                Monitoring dan pengelolaan program kerja organisasi
            </p>

        </div>

        <a href="tambah.php" class="btn-add">

            <i class="fa-solid fa-plus"></i>

            Tambah Program

        </a>

    </div>

    <!-- PROGRAM BOARD -->

    <div class="row">

        <?php while($data = mysqli_fetch_assoc($query)) : ?>

        <div class="col-lg-4 col-md-6 mb-4">

            <div class="program-card">

                <!-- IMAGE -->

                <img 
                    src="../../assets/uploads/program/<?= $data['thumbnail']; ?>"
                    class="program-image"
                >

                <div class="program-content">

                    <!-- DIVISI -->

                    <div class="program-division">

                        <?= $data['divisi']; ?>

                    </div>

                    <!-- TITLE -->

                    <div class="program-title">

                        <?= $data['nama_program']; ?>

                    </div>

                    <!-- STATUS -->

                    <?php if($data['status'] == 'Perencanaan') : ?>

                        <span class="status-badge planning">

                            Perencanaan

                        </span>

                    <?php elseif($data['status'] == 'Berjalan') : ?>

                        <span class="status-badge running">

                            Berjalan

                        </span>

                    <?php else : ?>

                        <span class="status-badge done">

                            Selesai

                        </span>

                    <?php endif; ?>

                    <!-- PROGRESS -->

                    <div class="progress-label">

                        <span>Progress Program</span>

                        <strong><?= $data['progress']; ?>%</strong>

                    </div>

                    <div class="progress">

                        <div 
                            class="progress-bar"
                            style="width: <?= $data['progress']; ?>%"
                        ></div>

                    </div>

                    <!-- TIMELINE -->

                    <div class="timeline">

                        <i class="fa-regular fa-calendar"></i>

                        <?= $data['timeline']; ?>

                    </div>

                    <!-- FOOTER -->

                    <div class="program-footer">

                        <small class="text-secondary">
                            MIDC Program
                        </small>

                        <div class="action-btn">

                            <!-- DETAIL -->

                            <a href="detail.php?id=<?= $data['id_program']; ?>" class="btn-detail">

                                <i class="fa-solid fa-eye"></i>

                            </a>

                            <!-- EDIT -->

                            <a href="edit.php?id=<?= $data['id_program']; ?>" class="btn-edit">

                                <i class="fa-solid fa-pen"></i>

                            </a>

                            <!-- DELETE -->

                            <a href="#" class="btn-delete" onclick="confirmDelete(<?= $data['id_program']; ?>)">

                                <i class="fa-solid fa-trash"></i>

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <?php endwhile; ?>

    </div>

</div>

</div>

<!-- JS -->
<script src="../../assets/js/admin.js"></script>
<script>

function confirmDelete(id){

    Swal.fire({

        title: 'Hapus program kerja?',

        text: 'Data yang dihapus tidak bisa dikembalikan!',

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#dc2626',

        cancelButtonColor: '#64748b',

        confirmButtonText: 'Ya, hapus!',

        cancelButtonText: 'Batal'

    }).then((result) => {

        if(result.isConfirmed){

            window.location.href = 'hapus.php?id=' + id;

        }

    });

}

</script>
</body>
</html>