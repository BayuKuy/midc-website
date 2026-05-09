<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location: ../login.php");
    exit;
}

include '../../config/koneksi.php';

/*
|--------------------------------------------------------------------------
| TAMBAH PENGURUS
|--------------------------------------------------------------------------
*/

if(isset($_POST['simpan'])){

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
    | UPLOAD FOTO
    |--------------------------------------------------------------------------
    */

    $foto = $_FILES['foto']['name'];

    $tmp = $_FILES['foto']['tmp_name'];

    $folder = "../../assets/uploads/pengurus/";

    $nama_foto = time() . '-' . $foto;

    move_uploaded_file($tmp, $folder . $nama_foto);

    /*
    |--------------------------------------------------------------------------
    | INSERT DATABASE
    |--------------------------------------------------------------------------
    */

    $query = mysqli_query($conn, "INSERT INTO pengurus
    (
        nama_lengkap,
        foto,
        jabatan,
        divisi,
        email,
        instagram,
        bio,
        status_anggota,
        periode
    )

    VALUES

    (
        '$nama_lengkap',
        '$nama_foto',
        '$jabatan',
        '$divisi',
        '$email',
        '$instagram',
        '$bio',
        '$status_anggota',
        '$periode'
    )
    ");

    /*
    |--------------------------------------------------------------------------
    | FLASH MESSAGE
    |--------------------------------------------------------------------------
    */

    if($query){

        $_SESSION['success'] = "Pengurus berhasil ditambahkan!";

        header("Location: index.php");

        exit;

    }else{

        $_SESSION['error'] = "Pengurus gagal ditambahkan!";

    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengurus</title>

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

        /* Card */

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

        .upload-icon{
            font-size:45px;
            color:#2563eb;
            margin-bottom:10px;
        }

        .preview-image{
            width:140px;
            height:140px;
            border-radius:50%;
            object-fit:cover;
            margin-top:20px;
            display:none;
            border:4px solid #e2e8f0;
        }

        /* Profile Preview */

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

        /* Button */

        .btn-save{
            width:100%;
            border:none;
            border-radius:14px;
            padding:14px;
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

<div class="member-wrapper">

    <!-- TITLE -->

    <div class="page-title mb-4">

        <h3>Tambah Pengurus</h3>

        <p>
            Kelola data anggota dan struktur organisasi MIDC
        </p>

    </div>

    <!-- FORM -->

    <form action="" method="POST" enctype="multipart/form-data">

        <div class="row">

            <!-- LEFT -->

            <div class="col-lg-8">

                <!-- PERSONAL -->

                <div class="member-card">

                    <div class="card-title">
                        Informasi Personal
                    </div>

                    <!-- NAMA -->

                    <div class="mb-4">

                        <label class="form-label">
                            Nama Lengkap
                        </label>

                        <input 
                            type="text"
                            name="nama_lengkap"
                            class="form-control"
                            placeholder="Masukkan nama lengkap..."
                            required
                        >

                    </div>

                    <!-- JABATAN -->

                    <div class="mb-4">

                        <label class="form-label">
                            Jabatan
                        </label>

                        <input 
                            type="text"
                            name="jabatan"
                            class="form-control"
                            placeholder="Contoh: Ketua MIDC"
                            required
                        >

                    </div>

                    <!-- BIO -->

                    <div>

                        <label class="form-label">
                            Bio Singkat
                        </label>

                        <textarea 
                            name="bio"
                            class="form-control"
                            placeholder="Ceritakan profil singkat pengurus..."
                            required
                        ></textarea>

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
                            required
                        >

                        <div class="upload-icon">
                            <i class="fa-solid fa-user"></i>
                        </div>

                        <h6 class="fw-bold">
                            Upload Foto
                        </h6>

                        <p class="text-secondary small mb-0">
                            PNG, JPG atau JPEG
                        </p>

                        <div class="profile-preview">

                            <img 
                                id="previewImg"
                                class="preview-image"
                            >

                            <div class="profile-name" id="previewName">
                                Nama Pengurus
                            </div>

                            <div class="profile-role" id="previewRole">
                                Jabatan
                            </div>

                        </div>

                    </label>

                </div>

                <!-- ORGANIZATION -->

                <div class="member-card">

                    <div class="card-title">
                        Informasi Organisasi
                    </div>

                    <!-- DIVISI -->

                    <div class="mb-4">

                        <label class="form-label">
                            Divisi
                        </label>

                        <input 
                            type="text"
                            name="divisi"
                            class="form-control"
                            placeholder="Contoh: Kominfo"
                            required
                        >

                    </div>

                    <!-- EMAIL -->

                    <div class="mb-4">

                        <label class="form-label">
                            Email
                        </label>

                        <input 
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="contoh@email.com"
                        >

                    </div>

                    <!-- INSTAGRAM -->

                    <div class="mb-4">

                        <label class="form-label">
                            Instagram
                        </label>

                        <input 
                            type="text"
                            name="instagram"
                            class="form-control"
                            placeholder="@username"
                        >

                    </div>

                    <!-- PERIODE -->

                    <div class="mb-4">

                        <label class="form-label">
                            Periode Kepengurusan
                        </label>

                        <input 
                            type="text"
                            name="periode"
                            class="form-control"
                            placeholder="2025 - 2026"
                            required
                        >

                    </div>

                    <!-- STATUS -->

                    <div class="mb-4">

                        <label class="form-label">
                            Status Anggota
                        </label>

                        <select 
                            name="status_anggota"
                            class="form-select"
                        >

                            <option value="Aktif">
                                Aktif
                            </option>

                            <option value="Nonaktif">
                                Nonaktif
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

                        Simpan Pengurus

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

    image.style.display = "block";

}

const namaInput = document.querySelector('input[name="nama_lengkap"]');

const jabatanInput = document.querySelector('input[name="jabatan"]');

namaInput.addEventListener('input', function(){

    document.getElementById('previewName').innerText = this.value || 'Nama Pengurus';

});

jabatanInput.addEventListener('input', function(){

    document.getElementById('previewRole').innerText = this.value || 'Jabatan';

});

</script>

</body>
</html>