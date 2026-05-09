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
| CEK DATA ADA
|--------------------------------------------------------------------------
*/

if($data){

    /*
    |--------------------------------------------------------------------------
    | HAPUS THUMBNAIL
    |--------------------------------------------------------------------------
    */

    $thumbnail = "../../assets/uploads/program/" . $data['thumbnail'];

    if(!empty($data['thumbnail']) && file_exists($thumbnail)){

        unlink($thumbnail);

    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS DATABASE
    |--------------------------------------------------------------------------
    */

    $delete = mysqli_query($conn, "DELETE FROM program_kerja WHERE id_program='$id'");

    if($delete){

        $_SESSION['success'] = "Program kerja berhasil dihapus!";

    }else{

        $_SESSION['error'] = "Program kerja gagal dihapus!";

    }

}else{

    $_SESSION['error'] = "Data program tidak ditemukan!";

}

/*
|--------------------------------------------------------------------------
| REDIRECT
|--------------------------------------------------------------------------
*/

header("Location: index.php");

exit;

?>