<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location: ../login.php");
    exit;
}

include '../../config/koneksi.php';

/*
|--------------------------------------------------------------------------
| TAMBAH DIVISI
|--------------------------------------------------------------------------
*/

if(isset($_POST['simpan'])){

    $nama_divisi = mysqli_real_escape_string($conn, $_POST['nama_divisi']);

    $fokus_divisi = mysqli_real_escape_string($conn, $_POST['fokus_divisi']);

    $ketua_divisi = mysqli_real_escape_string($conn, $_POST['ketua_divisi']);

    $warna_divisi = $_POST['warna_divisi'];

    $icon_divisi = $_POST['icon_divisi'];

    /*
    |--------------------------------------------------------------------------
    | INSERT DATABASE
    |--------------------------------------------------------------------------
    */

    $query = mysqli_query($conn, "INSERT INTO divisi
    (
        nama_divisi,
        fokus_divisi,
        ketua_divisi,
        warna_divisi,
        icon_divisi
    )

    VALUES

    (
        '$nama_divisi',
        '$fokus_divisi',
        '$ketua_divisi',
        '$warna_divisi',
        '$icon_divisi'
    )
    ");

    /*
    |--------------------------------------------------------------------------
    | FLASH MESSAGE
    |--------------------------------------------------------------------------
    */

    if($query){

        $_SESSION['success'] = "Divisi berhasil ditambahkan!";

        header("Location: index.php");

        exit;

    }else{

        $_SESSION['error'] = "Divisi gagal ditambahkan!";

    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Divisi</title>

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

        .page-title h3{
            font-weight:700;
            color:#0f172a;
        }

        .page-title p{
            color:#64748b;
        }

        /* CARD */

        .division-card{
            background:white;
            border-radius:28px;
            padding:28px;
            box-shadow:0 5px 20px rgba(0,0,0,0.04);
            margin-bottom:25px;
        }

        .card-title{
            font-size:22px;
            font-weight:700;
            color:#0f172a;
            margin-bottom:25px;
        }

        /* FORM */

        .form-label{
            font-weight:600;
            color:#334155;
            margin-bottom:10px;
        }

        .form-control,
        .form-select{
            border:1px solid #e2e8f0;
            border-radius:16px;
            padding:14px;
            box-shadow:none;
        }

        .form-control:focus,
        .form-select:focus{
            border-color:#2563eb;
            box-shadow:0 0 0 4px rgba(37,99,235,0.1);
        }

        textarea{
            min-height:220px;
            resize:none;
        }

        /* PREVIEW */

        .preview-panel{
            border-radius:28px;
            padding:35px;
            color:white;
            position:relative;
            overflow:hidden;
            transition:0.3s;
            min-height:340px;
        }

        .preview-panel::before{
            content:'';
            position:absolute;
            width:250px;
            height:250px;
            background:rgba(255,255,255,0.08);
            border-radius:50%;
            top:-100px;
            right:-100px;
        }

        .preview-content{
            position:relative;
            z-index:2;
        }

        .preview-icon{
            width:85px;
            height:85px;
            border-radius:24px;
            background:rgba(255,255,255,0.15);
            display:flex;
            justify-content:center;
            align-items:center;
            font-size:38px;
            margin-bottom:25px;
        }

        .preview-name{
            font-size:30px;
            font-weight:700;
            margin-bottom:12px;
        }

        .preview-focus{
            line-height:1.9;
            opacity:0.95;
            margin-bottom:25px;
        }

        /* MINI STATS */

        .mini-stats{
            display:flex;
            gap:12px;
            flex-wrap:wrap;
        }

        .mini-box{
            background:rgba(255,255,255,0.12);
            padding:14px 18px;
            border-radius:16px;
            min-width:120px;
        }

        .mini-label{
            font-size:12px;
            opacity:0.8;
            margin-bottom:5px;
        }

        .mini-value{
            font-size:20px;
            font-weight:700;
        }

        /* INFO */

        .info-box{
            background:#f8fafc;
            border-radius:22px;
            padding:22px;
            margin-top:25px;
        }

        .info-box h5{
            font-weight:700;
            color:#0f172a;
            margin-bottom:12px;
        }

        .info-box p{
            color:#64748b;
            line-height:1.8;
            margin-bottom:0;
        }

        /* BUTTON */

        .btn-save{
            width:100%;
            border:none;
            border-radius:16px;
            padding:15px;
            background:linear-gradient(135deg,#2563eb,#4f46e5);
            color:white;
            font-weight:600;
            transition:0.3s;
        }

        .btn-save:hover{
            transform:translateY(-2px);
            box-shadow:0 10px 20px rgba(37,99,235,0.2);
        }

    </style>

</head>
<body>

<?php include '../../includes/sidebar.php'; ?>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="main-content">

<?php include '../../includes/navbar_admin.php'; ?>

<div class="division-wrapper">

    <!-- TITLE -->

    <div class="page-title mb-4">

        <h3>Tambah Divisi</h3>

        <p>
            Bangun struktur unit organisasi dan identitas divisi MIDC
        </p>

    </div>

    <!-- FORM -->

    <form action="" method="POST">

        <div class="row">

            <!-- LEFT -->

            <div class="col-lg-8">

                <div class="division-card">

                    <div class="card-title">
                        Informasi Divisi
                    </div>

                    <!-- NAMA -->

                    <div class="mb-4">

                        <label class="form-label">
                            Nama Divisi
                        </label>

                        <input 
                            type="text"
                            name="nama_divisi"
                            class="form-control"
                            placeholder="Contoh: Kominfo"
                            required
                            id="divisionName"
                        >

                    </div>

                    <!-- KETUA -->

                    <div class="mb-4">

                        <label class="form-label">
                            Ketua Divisi
                        </label>

                        <input 
                            type="text"
                            name="ketua_divisi"
                            class="form-control"
                            placeholder="Nama ketua divisi..."
                            required
                        >

                    </div>

                    <!-- FOKUS -->

                    <div>

                        <label class="form-label">
                            Fokus Divisi
                        </label>

                        <textarea 
                            name="fokus_divisi"
                            class="form-control"
                            placeholder="Jelaskan fokus, tanggung jawab, dan tujuan divisi..."
                            required
                            id="divisionFocus"
                        ></textarea>

                    </div>

                </div>

            </div>

            <!-- RIGHT -->

            <div class="col-lg-4">

                <!-- LIVE PREVIEW -->

                <div 
                    class="preview-panel"
                    id="previewPanel"
                    style="background:linear-gradient(135deg,#2563eb,#4f46e5)"
                >

                    <div class="preview-content">

                        <!-- ICON -->

                        <div class="preview-icon">

                            <i class="fa-solid fa-laptop-code" id="previewIcon"></i>

                        </div>

                        <!-- NAME -->

                        <div class="preview-name" id="previewName">

                            Nama Divisi

                        </div>

                        <!-- FOCUS -->

                        <div class="preview-focus" id="previewFocus">

                            Fokus divisi akan tampil di sini...

                        </div>

                        <!-- STATS -->

                        <div class="mini-stats">

                            <div class="mini-box">

                                <div class="mini-label">
                                    Pengurus
                                </div>

                                <div class="mini-value">
                                    0
                                </div>

                            </div>

                            <div class="mini-box">

                                <div class="mini-label">
                                    Program
                                </div>

                                <div class="mini-value">
                                    0
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- VISUAL SETUP -->

                <div class="division-card mt-4">

                    <div class="card-title">
                        Identitas Visual
                    </div>

                    <!-- COLOR -->

                    <div class="mb-4">

                        <label class="form-label">
                            Warna Divisi
                        </label>

                        <select 
                            name="warna_divisi"
                            class="form-select"
                            id="colorSelect"
                        >

                            <option value="#2563eb,#4f46e5">
                                Biru MIDC
                            </option>

                            <option value="#16a34a,#22c55e">
                                Hijau
                            </option>

                            <option value="#7c3aed,#a855f7">
                                Ungu
                            </option>

                            <option value="#ea580c,#f97316">
                                Orange
                            </option>

                            <option value="#dc2626,#ef4444">
                                Merah
                            </option>

                        </select>

                    </div>

                    <!-- ICON -->

                    <div class="mb-4">

                        <label class="form-label">
                            Icon Divisi
                        </label>

                        <select 
                            name="icon_divisi"
                            class="form-select"
                            id="iconSelect"
                        >

                            <option value="fa-laptop-code">
                                Kominfo
                            </option>

                            <option value="fa-users">
                                PSDM
                            </option>

                            <option value="fa-bullhorn">
                                Humas
                            </option>

                            <option value="fa-handshake">
                                Kemitraan
                            </option>

                            <option value="fa-chart-line">
                                Kewirausahaan
                            </option>

                            <option value="fa-mosque">
                                Keagamaan
                            </option>

                        </select>

                    </div>

                    <!-- BUTTON -->

                    <button 
                        type="submit"
                        name="simpan"
                        class="btn-save"
                    >

                        <i class="fa-solid fa-floppy-disk"></i>

                        Simpan Divisi

                    </button>

                </div>

                <!-- INSIGHT -->

                <div class="info-box">

                    <h5>
                        Organization Department
                    </h5>

                    <p>
                        Divisi akan menjadi pusat struktur organisasi yang nantinya terhubung dengan pengurus, program kerja, dan sistem struktur organisasi MIDC.
                    </p>

                </div>

            </div>

        </div>

    </form>

</div>

</div>

<!-- JS -->
<script src="../../assets/js/admin.js"></script>

<script>

/*
|--------------------------------------------------------------------------
| LIVE PREVIEW
|--------------------------------------------------------------------------
*/

const divisionName = document.getElementById('divisionName');

const divisionFocus = document.getElementById('divisionFocus');

const previewName = document.getElementById('previewName');

const previewFocus = document.getElementById('previewFocus');

divisionName.addEventListener('input', function(){

    previewName.innerText = this.value || 'Nama Divisi';

});

divisionFocus.addEventListener('input', function(){

    previewFocus.innerText = this.value || 'Fokus divisi akan tampil di sini...';

});

/*
|--------------------------------------------------------------------------
| COLOR PREVIEW
|--------------------------------------------------------------------------
*/

const colorSelect = document.getElementById('colorSelect');

const previewPanel = document.getElementById('previewPanel');

colorSelect.addEventListener('change', function(){

    const colors = this.value.split(',');

    previewPanel.style.background = `linear-gradient(135deg, ${colors[0]}, ${colors[1]})`;

});

/*
|--------------------------------------------------------------------------
| ICON PREVIEW
|--------------------------------------------------------------------------
*/

const iconSelect = document.getElementById('iconSelect');

const previewIcon = document.getElementById('previewIcon');

iconSelect.addEventListener('change', function(){

    previewIcon.className = 'fa-solid ' + this.value;

});

</script>

</body>
</html>