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
| AMBIL DATA PROGRAM
|--------------------------------------------------------------------------
*/

$query = mysqli_query($conn, "SELECT * FROM program_kerja WHERE id_program='$id'");

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

/*
|--------------------------------------------------------------------------
| UPDATE PROGRAM
|--------------------------------------------------------------------------
*/

if(isset($_POST['update'])){

    $nama_program = mysqli_real_escape_string($conn, $_POST['nama_program']);

    $divisi = mysqli_real_escape_string($conn, $_POST['divisi']);

    $target_program = mysqli_real_escape_string($conn, $_POST['target_program']);

    $tujuan = mysqli_real_escape_string($conn, $_POST['tujuan']);

    $timeline = mysqli_real_escape_string($conn, $_POST['timeline']);

    $progress = $_POST['progress'];

    $status = $_POST['status'];

    /*
    |--------------------------------------------------------------------------
    | CEK THUMBNAIL BARU
    |--------------------------------------------------------------------------
    */

    if($_FILES['thumbnail']['name'] != ""){

        // HAPUS THUMBNAIL LAMA

        $thumbnail_lama = "../../assets/uploads/program/" . $data['thumbnail'];

        if(file_exists($thumbnail_lama)){

            unlink($thumbnail_lama);

        }

        // UPLOAD THUMBNAIL BARU

        $thumbnail = $_FILES['thumbnail']['name'];

        $tmp = $_FILES['thumbnail']['tmp_name'];

        $nama_thumbnail = time() . '-' . $thumbnail;

        move_uploaded_file($tmp, "../../assets/uploads/program/" . $nama_thumbnail);

    }else{

        // PAKAI THUMBNAIL LAMA

        $nama_thumbnail = $data['thumbnail'];

    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE DATABASE
    |--------------------------------------------------------------------------
    */

    $update = mysqli_query($conn, "UPDATE program_kerja SET

        nama_program = '$nama_program',
        divisi = '$divisi',
        target_program = '$target_program',
        tujuan = '$tujuan',
        timeline = '$timeline',
        progress = '$progress',
        status = '$status',
        thumbnail = '$nama_thumbnail'

        WHERE id_program = '$id'

    ");

    /*
    |--------------------------------------------------------------------------
    | FLASH MESSAGE
    |--------------------------------------------------------------------------
    */

    if($update){

        $_SESSION['success'] = "Program kerja berhasil diperbarui!";

    }else{

        $_SESSION['error'] = "Program kerja gagal diperbarui!";

    }

    header("Location: index.php");

    exit;

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Program Kerja</title>

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

        .preview-image{
            width:100%;
            border-radius:18px;
            margin-top:20px;
            max-height:240px;
            object-fit:cover;
        }

        /* Progress */

        .range-value{
            font-weight:700;
            color:#2563eb;
        }

        /* Button */

        .btn-update{
            width:100%;
            border:none;
            border-radius:14px;
            padding:14px;
            background:linear-gradient(135deg,#2563eb,#4f46e5);
            color:white;
            font-weight:600;
            transition:0.3s;
        }

        .btn-update:hover{
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

        <h3>Edit Program Kerja</h3>

        <p>
            Perbarui progress dan strategi program organisasi MIDC
        </p>

    </div>

    <!-- FORM -->

    <form action="" method="POST" enctype="multipart/form-data">

        <div class="row">

            <!-- LEFT -->

            <div class="col-lg-8">

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
                            value="<?= $data['nama_program']; ?>"
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
                            value="<?= $data['divisi']; ?>"
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
                            value="<?= $data['target_program']; ?>"
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
                            required
                        ><?= $data['tujuan']; ?></textarea>

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
                        >

                        <h6 class="fw-bold">
                            Ganti Thumbnail
                        </h6>

                        <p class="text-secondary small mb-0">
                            PNG, JPG atau JPEG
                        </p>

                        <img 
                            src="../../assets/uploads/program/<?= $data['thumbnail']; ?>"
                            id="previewImg"
                            class="preview-image"
                        >

                    </label>

                </div>

                <!-- MONITORING -->

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
                            value="<?= $data['timeline']; ?>"
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

                            <option 
                                value="Perencanaan"
                                <?= $data['status'] == 'Perencanaan' ? 'selected' : ''; ?>
                            >
                                Perencanaan
                            </option>

                            <option 
                                value="Berjalan"
                                <?= $data['status'] == 'Berjalan' ? 'selected' : ''; ?>
                            >
                                Berjalan
                            </option>

                            <option 
                                value="Selesai"
                                <?= $data['status'] == 'Selesai' ? 'selected' : ''; ?>
                            >
                                Selesai
                            </option>

                        </select>

                    </div>

                    <!-- PROGRESS -->

                    <div class="mb-4">

                        <label class="form-label">
                            Progress Program
                        </label>

                        <input 
                            type="range"
                            name="progress"
                            min="0"
                            max="100"
                            value="<?= $data['progress']; ?>"
                            class="form-range"
                            id="progressRange"
                            oninput="updateProgress(this.value)"
                        >

                        <div class="range-value">

                            <span id="progressValue">
                                <?= $data['progress']; ?>%
                            </span>

                        </div>

                    </div>

                    <!-- BUTTON -->

                    <button 
                        type="submit"
                        name="update"
                        class="btn-update"
                    >

                        <i class="fa-solid fa-floppy-disk"></i>

                        Update Program

                    </button>

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

}

function updateProgress(value){

    document.getElementById('progressValue').innerText = value + '%';

}

</script>

</body>
</html>