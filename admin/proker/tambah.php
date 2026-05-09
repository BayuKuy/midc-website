<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location: ../login.php");
    exit;
}

include '../../config/koneksi.php';

/*
|--------------------------------------------------------------------------
| TAMBAH PROGRAM
|--------------------------------------------------------------------------
*/

if(isset($_POST['publish'])){

    $nama_program = mysqli_real_escape_string($conn, $_POST['nama_program']);

    $divisi = mysqli_real_escape_string($conn, $_POST['divisi']);

    $target_program = mysqli_real_escape_string($conn, $_POST['target_program']);

    $tujuan = mysqli_real_escape_string($conn, $_POST['tujuan']);

    $timeline = mysqli_real_escape_string($conn, $_POST['timeline']);

    $progress = $_POST['progress'];

    $status = $_POST['status'];

    /*
    |--------------------------------------------------------------------------
    | UPLOAD THUMBNAIL
    |--------------------------------------------------------------------------
    */

    $thumbnail = $_FILES['thumbnail']['name'];

    $tmp = $_FILES['thumbnail']['tmp_name'];

    $folder = "../../assets/uploads/program/";

    $nama_thumbnail = time() . '-' . $thumbnail;

    move_uploaded_file($tmp, $folder . $nama_thumbnail);

    /*
    |--------------------------------------------------------------------------
    | INSERT DATABASE
    |--------------------------------------------------------------------------
    */

    $query = mysqli_query($conn, "INSERT INTO program_kerja
    (
        nama_program,
        divisi,
        target_program,
        tujuan,
        timeline,
        progress,
        status,
        thumbnail
    )

    VALUES

    (
        '$nama_program',
        '$divisi',
        '$target_program',
        '$tujuan',
        '$timeline',
        '$progress',
        '$status',
        '$nama_thumbnail'
    )
    ");

    /*
    |--------------------------------------------------------------------------
    | FLASH MESSAGE
    |--------------------------------------------------------------------------
    */

    if($query){

        $_SESSION['success'] = "Program kerja berhasil ditambahkan!";

        header("Location: index.php");

        exit;

    }else{

        $_SESSION['error'] = "Program kerja gagal ditambahkan!";

    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Program Kerja</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="../../assets/css/admin.css">

    <style>

        .program-wrapper{
            padding:30px;
        }

        .page-title h3{
            font-weight:700;
            color:#0f172a;
        }

        .page-title p{
            color:#64748b;
        }

        /* Card */

        .program-card{
            background:white;
            border-radius:24px;
            padding:25px;
            box-shadow:0 5px 20px rgba(0,0,0,0.04);
            margin-bottom:25px;
        }

        .card-title{
            font-size:20px;
            font-weight:700;
            margin-bottom:25px;
            color:#0f172a;
        }

        /* Form */

        .form-label{
            font-weight:600;
            color:#334155;
            margin-bottom:10px;
        }

        .form-control,
        .form-select{
            border:1px solid #e2e8f0;
            border-radius:14px;
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

        /* Upload */

        .upload-box{
            border:2px dashed #cbd5e1;
            border-radius:20px;
            padding:25px;
            text-align:center;
            cursor:pointer;
            transition:0.3s;
        }

        .upload-box:hover{
            border-color:#2563eb;
            background:#f8fafc;
        }

        .upload-icon{
            font-size:45px;
            color:#2563eb;
            margin-bottom:10px;
        }

        .preview-image{
            width:100%;
            border-radius:18px;
            margin-top:20px;
            max-height:240px;
            object-fit:cover;
            display:none;
        }

        /* Progress */

        .range-value{
            font-weight:700;
            color:#2563eb;
        }

        /* Insight */

        .insight-box{
            background:linear-gradient(135deg,#2563eb,#4f46e5);
            border-radius:20px;
            padding:22px;
            color:white;
        }

        .insight-box h5{
            font-weight:700;
            margin-bottom:12px;
        }

        .insight-box p{
            font-size:14px;
            opacity:0.9;
            margin-bottom:0;
            line-height:1.7;
        }

        /* Button */

        .btn-publish{
            width:100%;
            border:none;
            border-radius:14px;
            padding:14px;
            background:linear-gradient(135deg,#2563eb,#4f46e5);
            color:white;
            font-weight:600;
            transition:0.3s;
        }

        .btn-publish:hover{
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

<div class="program-wrapper">

    <!-- TITLE -->

    <div class="page-title mb-4">

        <h3>Tambah Program Kerja</h3>

        <p>
            Rancang dan monitoring program kerja organisasi MIDC
        </p>

    </div>

    <!-- FORM -->

    <form action="" method="POST" enctype="multipart/form-data">

        <div class="row">

            <!-- LEFT -->

            <div class="col-lg-8">

                <!-- INFORMASI -->

                <div class="program-card">

                    <div class="card-title">
                        Informasi Strategis
                    </div>

                    <!-- NAMA -->

                    <div class="mb-4">

                        <label class="form-label">
                            Nama Program
                        </label>

                        <input 
                            type="text"
                            name="nama_program"
                            class="form-control"
                            placeholder="Contoh: MIDC Tech Talk"
                            required
                        >

                    </div>

                    <!-- DIVISI -->

                    <div class="mb-4">

                        <label class="form-label">
                            Divisi Penanggung Jawab
                        </label>

                        <input 
                            type="text"
                            name="divisi"
                            class="form-control"
                            placeholder="Contoh: Kominfo"
                            required
                        >

                    </div>

                    <!-- TARGET -->

                    <div class="mb-4">

                        <label class="form-label">
                            Target Program
                        </label>

                        <input 
                            type="text"
                            name="target_program"
                            class="form-control"
                            placeholder="Contoh: Mahasiswa Baru"
                            required
                        >

                    </div>

                    <!-- TUJUAN -->

                    <div>

                        <label class="form-label">
                            Tujuan Program
                        </label>

                        <textarea 
                            name="tujuan"
                            class="form-control"
                            placeholder="Jelaskan tujuan program kerja..."
                            required
                        ></textarea>

                    </div>

                </div>

            </div>

            <!-- RIGHT -->

            <div class="col-lg-4">

                <!-- THUMBNAIL -->

                <div class="program-card">

                    <div class="card-title">
                        Thumbnail Program
                    </div>

                    <label class="upload-box">

                        <input 
                            type="file"
                            name="thumbnail"
                            hidden
                            accept="image/*"
                            onchange="previewImage(event)"
                            required
                        >

                        <div class="upload-icon">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>

                        <h6 class="fw-bold">
                            Upload Thumbnail
                        </h6>

                        <p class="text-secondary small mb-0">
                            PNG, JPG atau JPEG
                        </p>

                        <img 
                            id="previewImg"
                            class="preview-image"
                        >

                    </label>

                </div>

                <!-- SETUP -->

                <div class="program-card">

                    <div class="card-title">
                        Monitoring Setup
                    </div>

                    <!-- TIMELINE -->

                    <div class="mb-4">

                        <label class="form-label">
                            Timeline
                        </label>

                        <input 
                            type="text"
                            name="timeline"
                            class="form-control"
                            placeholder="Contoh: Juli - Agustus 2026"
                            required
                        >

                    </div>

                    <!-- STATUS -->

                    <div class="mb-4">

                        <label class="form-label">
                            Status Program
                        </label>

                        <select 
                            name="status"
                            class="form-select"
                        >

                            <option value="Perencanaan">
                                Perencanaan
                            </option>

                            <option value="Berjalan">
                                Berjalan
                            </option>

                            <option value="Selesai">
                                Selesai
                            </option>

                        </select>

                    </div>

                    <!-- PROGRESS -->

                    <div class="mb-4">

                        <label class="form-label">
                            Progress Awal
                        </label>

                        <input 
                            type="range"
                            name="progress"
                            min="0"
                            max="100"
                            value="0"
                            class="form-range"
                            id="progressRange"
                            oninput="updateProgress(this.value)"
                        >

                        <div class="range-value">

                            <span id="progressValue">
                                0%
                            </span>

                        </div>

                    </div>

                    <!-- BUTTON -->

                    <button 
                        type="submit"
                        name="publish"
                        class="btn-publish"
                    >

                        <i class="fa-solid fa-paper-plane"></i>

                        Publish Program

                    </button>

                </div>

                <!-- INSIGHT -->

                <div class="insight-box">

                    <h5>
                        MIDC Strategic Program
                    </h5>

                    <p>
                        Program kerja yang terstruktur akan membantu organisasi berjalan lebih profesional dan menjadi legacy digital bagi kepengurusan berikutnya.
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

function previewImage(event){

    const image = document.getElementById('previewImg');

    image.src = URL.createObjectURL(event.target.files[0]);

    image.style.display = "block";

}

function updateProgress(value){

    document.getElementById('progressValue').innerText = value + '%';

}

</script>

</body>
</html>