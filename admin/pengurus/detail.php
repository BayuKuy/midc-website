<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location: ../login.php");
    exit;
}

include '../../config/koneksi.php';

/*
|--------------------------------------------------------------------------
| VALIDASI ID
|--------------------------------------------------------------------------
*/

if(!isset($_GET['id'])){

    header("Location: index.php");

    exit;

}

$id = $_GET['id'];

/*
|--------------------------------------------------------------------------
| AMBIL DATA PENGURUS
|--------------------------------------------------------------------------
*/

$query = mysqli_query($conn, "SELECT * FROM pengurus WHERE id_pengurus='$id'");

$data = mysqli_fetch_assoc($query);

/*
|--------------------------------------------------------------------------
| JIKA DATA TIDAK ADA
|--------------------------------------------------------------------------
*/

if(!$data){

    header("Location: index.php");

    exit;

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengurus</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="../../assets/css/admin.css">

    <style>

        .profile-wrapper{
            padding:30px;
        }

        /* Hero */

        .hero-card{
            background:linear-gradient(135deg,#2563eb,#4f46e5);
            border-radius:30px;
            padding:40px;
            color:white;
            margin-bottom:30px;
            position:relative;
            overflow:hidden;
        }

        .hero-card::before{
            content:'';
            position:absolute;
            width:300px;
            height:300px;
            background:rgba(255,255,255,0.08);
            border-radius:50%;
            top:-100px;
            right:-100px;
        }

        .hero-content{
            position:relative;
            z-index:2;
            display:flex;
            align-items:center;
            gap:30px;
            flex-wrap:wrap;
        }

        /* Photo */

        .profile-photo{
            width:160px;
            height:160px;
            border-radius:28px;
            object-fit:cover;
            border:5px solid rgba(255,255,255,0.2);
        }

        /* Info */

        .profile-name{
            font-size:38px;
            font-weight:700;
            margin-bottom:10px;
        }

        .profile-role{
            font-size:18px;
            opacity:0.95;
            margin-bottom:15px;
        }

        .profile-division{
            display:inline-block;
            padding:8px 16px;
            border-radius:999px;
            background:rgba(255,255,255,0.15);
            font-size:14px;
            font-weight:600;
        }

        /* Card */

        .detail-card{
            background:white;
            border-radius:24px;
            padding:25px;
            box-shadow:0 5px 20px rgba(0,0,0,0.04);
            margin-bottom:25px;
        }

        .card-title{
            font-size:20px;
            font-weight:700;
            color:#0f172a;
            margin-bottom:20px;
        }

        /* Bio */

        .bio-text{
            color:#475569;
            line-height:1.9;
        }

        /* Info */

        .info-item{
            display:flex;
            justify-content:space-between;
            margin-bottom:18px;
            gap:15px;
        }

        .info-item span{
            color:#64748b;
        }

        .info-item strong{
            color:#0f172a;
            text-align:right;
        }

        /* Status */

        .status-badge{
            display:inline-block;
            padding:7px 14px;
            border-radius:999px;
            font-size:13px;
            font-weight:600;
        }

        .aktif{
            background:#dcfce7;
            color:#16a34a;
        }

        .nonaktif{
            background:#fee2e2;
            color:#dc2626;
        }

        /* Contact */

        .contact-item{
            display:flex;
            align-items:center;
            gap:15px;
            margin-bottom:20px;
        }

        .contact-icon{
            width:45px;
            height:45px;
            border-radius:14px;
            background:#eff6ff;
            color:#2563eb;
            display:flex;
            justify-content:center;
            align-items:center;
            font-size:18px;
        }

        .contact-text{
            color:#334155;
        }

        @media(max-width:768px){

            .hero-content{
                flex-direction:column;
                text-align:center;
            }

            .profile-name{
                font-size:30px;
            }

        }

    </style>

</head>
<body>

<?php include '../../includes/sidebar.php'; ?>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="main-content">

<?php include '../../includes/navbar_admin.php'; ?>

<div class="profile-wrapper">

    <!-- HERO -->

    <div class="hero-card">

        <div class="hero-content">

            <!-- PHOTO -->

            <img 
                src="../../assets/uploads/pengurus/<?= $data['foto']; ?>"
                class="profile-photo"
            >

            <!-- INFO -->

            <div>

                <div class="profile-name">

                    <?= $data['nama_lengkap']; ?>

                </div>

                <div class="profile-role">

                    <?= $data['jabatan']; ?>

                </div>

                <div class="profile-division">

                    <?= $data['divisi']; ?>

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <!-- LEFT -->

        <div class="col-lg-8">

            <!-- BIO -->

            <div class="detail-card">

                <div class="card-title">
                    Bio Pengurus
                </div>

                <div class="bio-text">

                    <?= nl2br($data['bio']); ?>

                </div>

            </div>

            <!-- CONTACT -->

            <div class="detail-card">

                <div class="card-title">
                    Kontak & Media Sosial
                </div>

                <!-- EMAIL -->

                <div class="contact-item">

                    <div class="contact-icon">

                        <i class="fa-regular fa-envelope"></i>

                    </div>

                    <div class="contact-text">

                        <?= $data['email']; ?>

                    </div>

                </div>

                <!-- INSTAGRAM -->

                <div class="contact-item">

                    <div class="contact-icon">

                        <i class="fa-brands fa-instagram"></i>

                    </div>

                    <div class="contact-text">

                        <?= $data['instagram']; ?>

                    </div>

                </div>

            </div>

        </div>

        <!-- RIGHT -->

        <div class="col-lg-4">

            <!-- ORGANIZATION INFO -->

            <div class="detail-card">

                <div class="card-title">
                    Informasi Organisasi
                </div>

                <div class="info-item">

                    <span>Divisi</span>

                    <strong>

                        <?= $data['divisi']; ?>

                    </strong>

                </div>

                <div class="info-item">

                    <span>Jabatan</span>

                    <strong>

                        <?= $data['jabatan']; ?>

                    </strong>

                </div>

                <div class="info-item">

                    <span>Periode</span>

                    <strong>

                        <?= $data['periode']; ?>

                    </strong>

                </div>

                <div class="info-item">

                    <span>Status</span>

                    <strong>

                        <?php if($data['status_anggota'] == 'Aktif') : ?>

                            <span class="status-badge aktif">

                                Aktif

                            </span>

                        <?php else : ?>

                            <span class="status-badge nonaktif">

                                Nonaktif

                            </span>

                        <?php endif; ?>

                    </strong>

                </div>

                <div class="info-item">

                    <span>Dibuat</span>

                    <strong>

                        <?= date('d M Y', strtotime($data['created_at'])); ?>

                    </strong>

                </div>

            </div>

        </div>

    </div>

</div>

</div>

<!-- JS -->
<script src="../../assets/js/admin.js"></script>

</body>
</html>