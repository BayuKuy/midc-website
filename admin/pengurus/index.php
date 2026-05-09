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
| AMBIL DIVISI
|--------------------------------------------------------------------------
*/

$divisi_query = mysqli_query($conn, "SELECT DISTINCT divisi FROM pengurus ORDER BY divisi ASC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directory Pengurus</title>

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

        /* Division */

        .division-title{
            font-size:22px;
            font-weight:700;
            color:#0f172a;
            margin-bottom:20px;
            margin-top:40px;
        }

        /* Member Card */

        .member-card{
            background:white;
            border-radius:24px;
            padding:22px;
            box-shadow:0 5px 20px rgba(0,0,0,0.04);
            margin-bottom:20px;
            transition:0.3s;
        }

        .member-card:hover{
            transform:translateY(-3px);
        }

        .member-wrapper{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:20px;
            flex-wrap:wrap;
        }

        .member-left{
            display:flex;
            gap:20px;
            align-items:center;
        }

        /* Photo */

        .member-photo{
            width:90px;
            height:90px;
            border-radius:20px;
            object-fit:cover;
        }

        /* Info */

        .member-name{
            font-size:22px;
            font-weight:700;
            color:#0f172a;
            margin-bottom:5px;
        }

        .member-role{
            color:#2563eb;
            font-weight:600;
            margin-bottom:12px;
        }

        .member-meta{
            font-size:14px;
            color:#64748b;
            margin-bottom:5px;
        }

        /* Status */

        .status-badge{
            display:inline-block;
            padding:6px 14px;
            border-radius:999px;
            font-size:12px;
            font-weight:600;
            margin-top:10px;
        }

        .aktif{
            background:#dcfce7;
            color:#16a34a;
        }

        .nonaktif{
            background:#fee2e2;
            color:#dc2626;
        }

        /* Action */

        .action-btn{
            display:flex;
            gap:10px;
        }

        .btn-detail,
        .btn-edit,
        .btn-delete{
            width:42px;
            height:42px;
            border:none;
            border-radius:12px;
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

        /* Responsive */

        @media(max-width:768px){

            .member-wrapper{
                flex-direction:column;
                align-items:flex-start;
            }

            .action-btn{
                width:100%;
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
                Directory Pengurus MIDC
            </h3>

            <p class="text-secondary">
                Struktur dan data pengurus organisasi MIDC
            </p>

        </div>

        <a href="tambah.php" class="btn-add">

            <i class="fa-solid fa-plus"></i>

            Tambah Pengurus

        </a>

    </div>

    <!-- LOOP DIVISI -->

    <?php while($divisi = mysqli_fetch_assoc($divisi_query)) : ?>

        <div class="division-title">

            <?= $divisi['divisi']; ?>

        </div>

        <?php

        $nama_divisi = $divisi['divisi'];

        $pengurus_query = mysqli_query($conn, "SELECT * FROM pengurus WHERE divisi='$nama_divisi'");

        ?>

        <?php while($data = mysqli_fetch_assoc($pengurus_query)) : ?>

            <!-- MEMBER -->

            <div class="member-card">

                <div class="member-wrapper">

                    <!-- LEFT -->

                    <div class="member-left">

                        <!-- PHOTO -->

                        <img 
                            src="../../assets/uploads/pengurus/<?= $data['foto']; ?>"
                            class="member-photo"
                        >

                        <!-- INFO -->

                        <div>

                            <div class="member-name">

                                <?= $data['nama_lengkap']; ?>

                            </div>

                            <div class="member-role">

                                <?= $data['jabatan']; ?>

                            </div>

                            <div class="member-meta">

                                <i class="fa-regular fa-envelope"></i>

                                <?= $data['email']; ?>

                            </div>

                            <div class="member-meta">

                                <i class="fa-brands fa-instagram"></i>

                                <?= $data['instagram']; ?>

                            </div>

                            <!-- STATUS -->

                            <?php if($data['status_anggota'] == 'Aktif') : ?>

                                <span class="status-badge aktif">

                                    Aktif

                                </span>

                            <?php else : ?>

                                <span class="status-badge nonaktif">

                                    Nonaktif

                                </span>

                            <?php endif; ?>

                        </div>

                    </div>

                    <!-- ACTION -->

                    <div class="action-btn">

                        <!-- DETAIL -->

                        <a href="detail.php?id=<?= $data['id_pengurus']; ?>" class="btn-detail">

                            <i class="fa-solid fa-eye"></i>

                        </a>

                        <!-- EDIT -->

                        <a href="edit.php?id=<?= $data['id_pengurus']; ?>" class="btn-edit">

                            <i class="fa-solid fa-pen"></i>

                        </a>

                        <!-- DELETE -->

                        <a 
                            href="#"
                            class="btn-delete"
                            onclick="confirmDelete(<?= $data['id_pengurus']; ?>)"
                        >

                            <i class="fa-solid fa-trash"></i>

                        </a>

                    </div>

                </div>

            </div>

        <?php endwhile; ?>

    <?php endwhile; ?>

</div>

</div>

<!-- JS -->
<script src="../../assets/js/admin.js"></script>

<!-- DELETE -->

<script>

function confirmDelete(id){

    Swal.fire({

        title: 'Hapus pengurus?',

        text: 'Data pengurus akan dihapus permanen!',

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