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

/*
|--------------------------------------------------------------------------
| UPDATE PENGURUS
|--------------------------------------------------------------------------
*/

if(isset($_POST['update'])){

    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);

    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);

    $divisi = mysqli_real_escape_string($conn, $_POST['divisi']);

    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $instagram = mysqli_real_escape_string($conn, $_POST['instagram']);

    $bio = mysqli_real_escape_string($conn, $_POST['bio']);

    $status_anggota = $_POST['status_anggota'];

    $periode = mysqli_real_escape_string($conn, $_POST['periode']);

    /*
    |--------------------------------------------------------------------------
    | CEK FOTO BARU
    |--------------------------------------------------------------------------
    */

    if($_FILES['foto']['name'] != ""){

        // HAPUS FOTO LAMA

        $foto_lama = "../../assets/uploads/pengurus/" . $data['foto'];

        if(file_exists($foto_lama)){

            unlink($foto_lama);

        }

        // UPLOAD FOTO BARU

        $foto = $_FILES['foto']['name'];

        $tmp = $_FILES['foto']['tmp_name'];

        $nama_foto = time() . '-' . $foto;

        move_uploaded_file($tmp, "../../assets/uploads/pengurus/" . $nama_foto);

    }else{

        // PAKAI FOTO LAMA

        $nama_foto = $data['foto'];

    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE DATABASE
    |--------------------------------------------------------------------------
    */

    $update = mysqli_query($conn, "UPDATE pengurus SET

        nama_lengkap = '$nama_lengkap',
        foto = '$nama_foto',
        jabatan = '$jabatan',
        divisi = '$divisi',
        email = '$email',
        instagram = '$instagram',
        bio = '$bio',
        status_anggota = '$status_anggota',
        periode = '$periode'

        WHERE id_pengurus = '$id'

    ");

    /*
    |--------------------------------------------------------------------------
    | FLASH MESSAGE
    |--------------------------------------------------------------------------
    */

    if($update){

        $_SESSION['success'] = "Data pengurus berhasil diperbarui!";

    }else{

        $_SESSION['error'] = "Data pengurus gagal diperbarui!";

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
    <title>Edit Pengurus</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="../../assets/css/admin.css">

    <style>

        .member-wrapper{
            padding:30px;
        }

        .page-title h3{
            font-weight:700;
            color:#0f172a;
        }

        .page-title p{
            color:#64748b;
        }

        .member-card{
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
            min-height:180px;
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
            width:140px;
            height:140px;
            border-radius:50%;
            object-fit:cover;
            margin-top:20px;
            border:4px solid #e2e8f0;
        }

        .profile-preview{
            text-align:center;
        }

        .profile-name{
            font-size:22px;
            font-weight:700;
            margin-top:15px;
            color:#0f172a;
        }

        .profile-role{
            color:#2563eb;
            font-weight:600;
            margin-top:5px;
        }

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

<div class="member-wrapper">

    <!-- TITLE -->

    <div class="page-title mb-4">

        <h3>Edit Pengurus</h3>

        <p>
            Perbarui data dan profil pengurus MIDC
        </p>

    </div>

    <!-- FORM -->

    <form action="" method="POST" enctype="multipart/form-data">

        <div class="row">

            <!-- LEFT -->

            <div class="col-lg-8">

                <div class="member-card">

                    <div class="card-title">
                        Informasi Personal
                    </div>

                    <div class="mb-4">

                        <label class="form-label">
                            Nama Lengkap
                        </label>

                        <input 
                            type="text"
                            name="nama_lengkap"
                            class="form-control"
                            value="<?= $data['nama_lengkap']; ?>"
                            required
                        >

                    </div>

                    <div class="mb-4">

                        <label class="form-label">
                            Jabatan
                        </label>

                        <input 
                            type="text"
                            name="jabatan"
                            class="form-control"
                            value="<?= $data['jabatan']; ?>"
                            required
                        >

                    </div>

                    <div>

                        <label class="form-label">
                            Bio Singkat
                        </label>

                        <textarea 
                            name="bio"
                            class="form-control"
                            required
                        ><?= $data['bio']; ?></textarea>

                    </div>

                </div>

            </div>

            <!-- RIGHT -->

            <div class="col-lg-4">

                <!-- FOTO -->

                <div class="member-card">

                    <div class="card-title">
                        Foto Profil
                    </div>

                    <label class="upload-box">

                        <input 
                            type="file"
                            name="foto"
                            hidden
                            accept="image/*"
                            onchange="previewImage(event)"
                        >

                        <h6 class="fw-bold">
                            Ganti Foto
                        </h6>

                        <p class="text-secondary small mb-0">
                            PNG, JPG atau JPEG
                        </p>

                        <div class="profile-preview">

                            <img 
                                src="../../assets/uploads/pengurus/<?= $data['foto']; ?>"
                                id="previewImg"
                                class="preview-image"
                            >

                            <div class="profile-name" id="previewName">
                                <?= $data['nama_lengkap']; ?>
                            </div>

                            <div class="profile-role" id="previewRole">
                                <?= $data['jabatan']; ?>
                            </div>

                        </div>

                    </label>

                </div>

                <!-- ORGANIZATION -->

                <div class="member-card">

                    <div class="card-title">
                        Informasi Organisasi
                    </div>

                    <div class="mb-4">

                        <label class="form-label">
                            Divisi
                        </label>

                        <input 
                            type="text"
                            name="divisi"
                            class="form-control"
                            value="<?= $data['divisi']; ?>"
                            required
                        >

                    </div>

                    <div class="mb-4">

                        <label class="form-label">
                            Email
                        </label>

                        <input 
                            type="email"
                            name="email"
                            class="form-control"
                            value="<?= $data['email']; ?>"
                        >

                    </div>

                    <div class="mb-4">

                        <label class="form-label">
                            Instagram
                        </label>

                        <input 
                            type="text"
                            name="instagram"
                            class="form-control"
                            value="<?= $data['instagram']; ?>"
                        >

                    </div>

                    <div class="mb-4">

                        <label class="form-label">
                            Periode Kepengurusan
                        </label>

                        <input 
                            type="text"
                            name="periode"
                            class="form-control"
                            value="<?= $data['periode']; ?>"
                            required
                        >

                    </div>

                    <div class="mb-4">

                        <label class="form-label">
                            Status Anggota
                        </label>

                        <select 
                            name="status_anggota"
                            class="form-select"
                        >

                            <option 
                                value="Aktif"
                                <?= $data['status_anggota'] == 'Aktif' ? 'selected' : ''; ?>
                            >
                                Aktif
                            </option>

                            <option 
                                value="Nonaktif"
                                <?= $data['status_anggota'] == 'Nonaktif' ? 'selected' : ''; ?>
                            >
                                Nonaktif
                            </option>

                        </select>

                    </div>

                    <button 
                        type="submit"
                        name="update"
                        class="btn-update"
                    >

                        <i class="fa-solid fa-floppy-disk"></i>

                        Update Pengurus

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

const namaInput = document.querySelector('input[name="nama_lengkap"]');

const jabatanInput = document.querySelector('input[name="jabatan"]');

namaInput.addEventListener('input', function(){

    document.getElementById('previewName').innerText = this.value;

});

jabatanInput.addEventListener('input', function(){

    document.getElementById('previewRole').innerText = this.value;

});

</script>

</body>
</html>