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
| CEK DATA ADA
|--------------------------------------------------------------------------
*/

if($data){

    /*
    |--------------------------------------------------------------------------
    | HAPUS FOTO
    |--------------------------------------------------------------------------
    */

    $foto = "../../assets/uploads/pengurus/" . $data['foto'];

    if(!empty($data['foto']) && file_exists($foto)){

        unlink($foto);

    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS DATABASE
    |--------------------------------------------------------------------------
    */

    $delete = mysqli_query($conn, "DELETE FROM pengurus WHERE id_pengurus='$id'");

    if($delete){

        $_SESSION['success'] = "Pengurus berhasil dihapus!";

    }else{

        $_SESSION['error'] = "Pengurus gagal dihapus!";

    }

}else{

    $_SESSION['error'] = "Data pengurus tidak ditemukan!";

}

/*
|--------------------------------------------------------------------------
| REDIRECT
|--------------------------------------------------------------------------
*/

header("Location: index.php");

exit;

?>