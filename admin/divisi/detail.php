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
| AMBIL DATA DIVISI
|--------------------------------------------------------------------------
*/

$query = mysqli_query($conn, "SELECT * FROM divisi WHERE id_divisi='$id'");

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

$nama_divisi = $data['nama_divisi'];

/*
|--------------------------------------------------------------------------
| TOTAL PENGURUS
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| DATA PENGURUS
|--------------------------------------------------------------------------
*/

$pengurus = mysqli_query(
    $conn,
    "SELECT * FROM pengurus WHERE divisi='$nama_divisi'"
);

/*
|--------------------------------------------------------------------------
| DATA PROGRAM
|--------------------------------------------------------------------------
*/

$program = mysqli_query(
    $conn,
    "SELECT * FROM program_kerja WHERE divisi='$nama_divisi'"
);

/*
|--------------------------------------------------------------------------
| WARNA
|--------------------------------------------------------------------------
*/

$warna = explode(',', $data['warna_divisi']);

$color1 = $warna[0];

$color2 = $warna[1];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Divisi</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="../../assets/css/admin.css">

    <style>

        .division-wrapper{
            padding:30px;
        }

        /* HERO */

        .hero-card{
            border-radius:34px;
            padding:40px;
            color:white;
            position:relative;
            overflow:hidden;
            margin-bottom:30px;
        }

        .hero-card::before{
            content:'';
            position:absolute;
            width:300px;
            height:300px;
            background:rgba(255,255,255,0.08);
            border-radius:50%;
            top:-120px;
            right:-120px;
        }

        .hero-content{
            position:relative;
            z-index:2;
        }

        .hero-icon{
            width:90px;
            height:90px;
            border-radius:28px;
            background:rgba(255,255,255,0.15);
            display:flex;
            justify-content:center;
            align-items:center;
            font-size:38px;
            margin-bottom:25px;
        }

        .hero-title{
            font-size:42px;
            font-weight:700;
            margin-bottom:12px;
        }

        .hero-text{
            line-height:1.9;
            opacity:0.95;
            max-width:850px;
        }

        /* Card */

        .content-card{
            background:white;
            border-radius:28px;
            padding:28px;
            box-shadow:0 5px 20px rgba(0,0,0,0.04);
            margin-bottom:25px;
        }

        .card-title{
            font-size:24px;
            font-weight:700;
            color:#0f172a;
            margin-bottom:25px;
        }

        /* Stats */

        .stats-grid{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
            gap:20px;
        }

        .stat-box{
            background:#f8fafc;
            border-radius:22px;
            padding:24px;
        }

        .stat-label{
            color:#64748b;
            margin-bottom:10px;
        }

        .stat-value{
            font-size:28px;
            font-weight:700;
            color:#0f172a;
        }

        /* Members */

        .member-item{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:20px;
            padding:18px 0;
            border-bottom:1px solid #e2e8f0;
            flex-wrap:wrap;
        }

        .member-item:last-child{
            border-bottom:none;
        }

        .member-left{
            display:flex;
            align-items:center;
            gap:18px;
        }

        .member-photo{
            width:70px;
            height:70px;
            border-radius:20px;
            object-fit:cover;
        }

        .member-name{
            font-size:20px;
            font-weight:700;
            color:#0f172a;
        }

        .member-role{
            color:#64748b;
            margin-top:5px;
        }

        /* Program */

        .program-item{
            background:#f8fafc;
            border-radius:22px;
            padding:24px;
            margin-bottom:20px;
        }

        .program-title{
            font-size:22px;
            font-weight:700;
            color:#0f172a;
            margin-bottom:10px;
        }

        .program-status{
            display:inline-block;
            padding:8px 14px;
            border-radius:999px;
            font-size:13px;
            font-weight:600;
            margin-top:10px;
        }

        .aktif{
            background:#dcfce7;
            color:#16a34a;
        }

        .selesai{
            background:#dbeafe;
            color:#2563eb;
        }

    </style>

</head>
<body>

<?php include '../../includes/sidebar.php'; ?>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="main-content">

<?php include '../../includes/navbar_admin.php'; ?>

<div class="division-wrapper">

    <!-- HERO -->

    <div 
        class="hero-card"
        style="background:linear-gradient(135deg, <?= $color1; ?>, <?= $color2; ?>)"
    >

        <div class="hero-content">

            <div class="hero-icon">

                <i class="fa-solid <?= $data['icon_divisi']; ?>"></i>

            </div>

            <div class="hero-title">

                <?= $data['nama_divisi']; ?>

            </div>

            <div class="hero-text">

                <?= $data['fokus_divisi']; ?>

            </div>

        </div>

    </div>

    <!-- STATS -->

    <div class="content-card">

        <div class="card-title">
            Statistik Divisi
        </div>

        <div class="stats-grid">

            <!-- Ketua -->

            <div class="stat-box">

                <div class="stat-label">
                    Ketua Divisi
                </div>

                <div class="stat-value">

                    <?= $data['ketua_divisi']; ?>

                </div>

            </div>

            <!-- Pengurus -->

            <div class="stat-box">

                <div class="stat-label">
                    Total Pengurus
                </div>

                <div class="stat-value">

                    <?= $total_pengurus; ?>

                </div>

            </div>

            <!-- Program -->

            <div class="stat-box">

                <div class="stat-label">
                    Program Kerja
                </div>

                <div class="stat-value">

                    <?= $total_program; ?>

                </div>

            </div>

        </div>

    </div>

    <!-- PENGURUS -->

    <div class="content-card">

        <div class="card-title">
            Anggota Divisi
        </div>

        <?php if(mysqli_num_rows($pengurus) > 0) : ?>

            <?php while($p = mysqli_fetch_assoc($pengurus)) : ?>

                <div class="member-item">

                    <div class="member-left">

                        <img 
                            src="../../assets/uploads/pengurus/<?= $p['foto']; ?>"
                            class="member-photo"
                        >

                        <div>

                            <div class="member-name">

                                <?= $p['nama_lengkap']; ?>

                            </div>

                            <div class="member-role">

                                <?= $p['jabatan']; ?>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endwhile; ?>

        <?php else : ?>

            <p class="text-secondary mb-0">
                Belum ada pengurus pada divisi ini.
            </p>

        <?php endif; ?>

    </div>

    <!-- PROGRAM -->

    <div class="content-card">

        <div class="card-title">
            Program Kerja Divisi
        </div>

        <?php if(mysqli_num_rows($program) > 0) : ?>

            <?php while($pr = mysqli_fetch_assoc($program)) : ?>

                <div class="program-item">

                    <div class="program-title">

                        <?= $pr['nama_program']; ?>

                    </div>

                    <div class="text-secondary">

                       Target Programnya <?= $pr['target_program']; ?>

                    </div>

                    <?php if($pr['status'] == 'Aktif') : ?>

                        <span class="program-status aktif">

                            Aktif

                        </span>

                    <?php else : ?>

                        <span class="program-status selesai">

                            Selesai

                        </span>

                    <?php endif; ?>

                </div>

            <?php endwhile; ?>

        <?php else : ?>

            <p class="text-secondary mb-0">
                Belum ada program kerja pada divisi ini.
            </p>

        <?php endif; ?>

    </div>

</div>

</div>

<!-- JS -->
<script src="../../assets/js/admin.js"></script>

</body>
</html>