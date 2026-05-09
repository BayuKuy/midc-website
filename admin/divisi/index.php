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
| AMBIL DATA DIVISI
|--------------------------------------------------------------------------
*/

$query = mysqli_query($conn, "SELECT * FROM divisi ORDER BY id_divisi DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Divisi</title>

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
            margin-bottom:35px;
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

        /* Division Panel */

        .division-panel{
            background:white;
            border-radius:28px;
            padding:28px;
            box-shadow:0 5px 20px rgba(0,0,0,0.04);
            margin-bottom:25px;
            position:relative;
            overflow:hidden;
            transition:0.3s;
        }

        .division-panel:hover{
            transform:translateY(-4px);
        }

        .division-panel::before{
            content:'';
            position:absolute;
            top:0;
            left:0;
            width:7px;
            height:100%;
            background:linear-gradient(180deg,#2563eb,#4f46e5);
        }

        /* Top */

        .division-top{
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            gap:20px;
            flex-wrap:wrap;
        }

        /* Title */

        .division-name{
            font-size:28px;
            font-weight:700;
            color:#0f172a;
            margin-bottom:12px;
        }

        .division-focus{
            color:#64748b;
            line-height:1.8;
            max-width:700px;
        }

        /* Stats */

        .division-stats{
            display:flex;
            gap:15px;
            flex-wrap:wrap;
            margin-top:25px;
        }

        .stat-box{
            background:#f8fafc;
            padding:16px 22px;
            border-radius:18px;
            min-width:160px;
        }

        .stat-label{
            font-size:13px;
            color:#64748b;
            margin-bottom:6px;
        }

        .stat-value{
            font-size:22px;
            font-weight:700;
            color:#0f172a;
        }

        /* Action */

        .action-btn{
            display:flex;
            gap:10px;
        }

        .btn-detail,
        .btn-edit,
        .btn-delete{
            width:44px;
            height:44px;
            border:none;
            border-radius:14px;
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

        @media(max-width:768px){

            .division-top{
                flex-direction:column;
            }

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
                Master Data Divisi
            </h3>

            <p class="text-secondary">
                Struktur dan unit organisasi MIDC
            </p>

        </div>

        <a href="tambah.php" class="btn-add">

            <i class="fa-solid fa-plus"></i>

            Tambah Divisi

        </a>

    </div>

    <!-- LOOP DIVISI -->

    <?php while($data = mysqli_fetch_assoc($query)) : ?>

        <?php

        /*
        |--------------------------------------------------------------------------
        | TOTAL PENGURUS
        |--------------------------------------------------------------------------
        */

        $nama_divisi = $data['nama_divisi'];

        $total_pengurus = mysqli_num_rows(mysqli_query(
            $conn,
            "SELECT * FROM pengurus WHERE divisi='$nama_divisi'"
        ));

        /*
        |--------------------------------------------------------------------------
        | TOTAL PROGRAM
        |--------------------------------------------------------------------------
        */

        $total_program = mysqli_num_rows(mysqli_query(
            $conn,
            "SELECT * FROM program_kerja WHERE divisi='$nama_divisi'"
        ));

        ?>

        <!-- DIVISION PANEL -->

        <div class="division-panel">

            <div class="division-top">

                <!-- LEFT -->

                <div>

                    <div class="division-name">

                        <?= $data['nama_divisi']; ?>

                    </div>

                    <div class="division-focus">

                        <?= $data['fokus_divisi']; ?>

                    </div>

                    <!-- STATS -->

                    <div class="division-stats">

                        <!-- KETUA -->

                        <div class="stat-box">

                            <div class="stat-label">
                                Ketua Divisi
                            </div>

                            <div class="stat-value">

                                <?= $data['ketua_divisi']; ?>

                            </div>

                        </div>

                        <!-- ANGGOTA -->

                        <div class="stat-box">

                            <div class="stat-label">
                                Total Pengurus
                            </div>

                            <div class="stat-value">

                                <?= $total_pengurus; ?>

                            </div>

                        </div>

                        <!-- PROGRAM -->

                        <div class="stat-box">

                            <div class="stat-label">
                                Program Aktif
                            </div>

                            <div class="stat-value">

                                <?= $total_program; ?>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- ACTION -->

                <div class="action-btn">

                    <!-- DETAIL -->

                    <a href="detail.php?id=<?= $data['id_divisi']; ?>" class="btn-detail">

                        <i class="fa-solid fa-eye"></i>

                    </a>

                    <!-- EDIT -->

                    <a href="edit.php?id=<?= $data['id_divisi']; ?>" class="btn-edit">

                        <i class="fa-solid fa-pen"></i>

                    </a>

                    <!-- DELETE -->

                    <a 
                        href="#"
                        class="btn-delete"
                        onclick="confirmDelete(<?= $data['id_divisi']; ?>)"
                    >

                        <i class="fa-solid fa-trash"></i>

                    </a>

                </div>

            </div>

        </div>

    <?php endwhile; ?>

</div>

</div>

<!-- JS -->
<script src="../../assets/js/admin.js"></script>

<!-- DELETE -->

<script>

function confirmDelete(id){

    Swal.fire({

        title: 'Hapus divisi?',

        text: 'Data divisi akan dihapus permanen!',

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

<!-- SUCCESS -->

<?php if($success != "") : ?>

<script>

Swal.fire({

    icon: 'success',

    title: 'Berhasil!',

    text: '<?= $success; ?>',

    confirmButtonColor: '#2563eb'

});

</script>

<?php endif; ?>

<!-- ERROR -->

<?php if($error != "") : ?>

<script>

Swal.fire({

    icon: 'error',

    title: 'Oops...',

    text: '<?= $error; ?>',

    confirmButtonColor: '#dc2626'

});

</script>

<?php endif; ?>

</body>
</html>