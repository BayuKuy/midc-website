<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location: ../login.php");
    exit;
}

include '../../config/koneksi.php';

$query = mysqli_query($conn, "SELECT * FROM berita ORDER BY id_berita DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Berita</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="../../assets/css/admin.css">

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

        .news-card{
            background:white;
            border-radius:22px;
            overflow:hidden;
            box-shadow:0 5px 20px rgba(0,0,0,0.04);
            transition:0.3s;
            height:100%;
        }

        .news-card:hover{
            transform:translateY(-5px);
        }

        .news-image{
            width:100%;
            height:220px;
            object-fit:cover;
        }

        .news-content{
            padding:20px;
        }

        .news-date{
            font-size:13px;
            color:#64748b;
            margin-bottom:10px;
        }

        .news-title{
            font-size:20px;
            font-weight:700;
            margin-bottom:10px;
            color:#0f172a;
        }

        .news-text{
            font-size:14px;
            color:#475569;
            margin-bottom:20px;
        }

        .news-footer{
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .news-author{
            font-size:14px;
            color:#64748b;
        }

        .action-btn{
            display:flex;
            gap:10px;
        }

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

            <!-- Header -->

            <div class="page-header">

                <div>

                    <h3 class="fw-bold mb-1">
                        Kelola Berita
                    </h3>

                    <p class="text-secondary">
                        Manajemen berita dan artikel website MIDC
                    </p>

                </div>

                <a href="tambah.php" class="btn-add">

                    <i class="fa-solid fa-plus"></i>

                    Tambah Berita

                </a>

            </div>

            <!-- News Card -->

            <div class="row">

                <?php while($data = mysqli_fetch_assoc($query)) : ?>

                    <div class="col-lg-4 col-md-6 mb-4">

                        <div class="news-card">

                            <img 
                                src="../../assets/uploads/berita/<?= $data['gambar']; ?>" 
                                class="news-image"
                            >

                            <div class="news-content">

                                <div class="news-date">

                                    <i class="fa-regular fa-calendar"></i>

                                    <?= date('d F Y', strtotime($data['tanggal'])); ?>

                                </div>

                                <div class="news-title">

                                    <?= $data['judul']; ?>

                                </div>

                                <div class="news-text">

                                    <?= substr($data['isi'], 0, 100); ?>...

                                </div>

                                <div class="news-footer">

                                    <div class="news-author">

                                        <i class="fa-regular fa-user"></i>

                                        <?= $data['penulis']; ?>

                                    </div>

                                    <div class="action-btn">

                                        <a href="edit.php?id=<?= $data['id_berita']; ?>" class="btn-edit">

                                            <i class="fa-solid fa-pen"></i>

                                        </a>

                                        <a href="#" class="btn-delete" onclick="confirmDelete(<?= $data['id_berita'] ?>)">

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
    
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

function confirmDelete(id){

    Swal.fire({

        title: 'Yakin ingin menghapus?',

        text: 'Berita yang dihapus tidak bisa dikembalikan!',

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#dc2626',

        cancelButtonColor: '#64748b',

        confirmButtonText: 'Ya, hapus!',

        cancelButtonText: 'Batal'

    }).then((result) => {

        if(result.isConfirmed){

            window.location = 'hapus.php?id=' + id;

        }

    });

}

</script>