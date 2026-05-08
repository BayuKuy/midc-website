<?php

session_start();

include '../config/koneksi.php';

if(isset($_SESSION['login'])){
    header("Location: dashboard.php");
    exit;
}

$error = "";

if(isset($_POST['login'])){

    $username = mysqli_real_escape_string($conn, $_POST['username']);

    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");

    if(mysqli_num_rows($query) > 0){

        $data = mysqli_fetch_assoc($query);

        if(password_verify($password, $data['password'])){

            $_SESSION['login'] = true;

            $_SESSION['id_admin'] = $data['id_admin'];

            $_SESSION['nama'] = $data['nama'];

            $_SESSION['role'] = $data['role'];

            header("Location: dashboard.php");
            exit;

        }else{

            $error = "Password salah!";

        }

    }else{

        $error = "Username tidak ditemukan!";

    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login MIDC | Professional Portal</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --primary: #2563eb;
            --secondary: #4f46e5;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --bg-gradient: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--bg-gradient);
            overflow: hidden;
            position: relative;
        }

        /* Decorative Elements */
        .bg-circle {
            position: absolute;
            border-radius: 50%;
            z-index: 1;
            filter: blur(80px);
            opacity: 0.4;
        }
        .circle-1 { width: 400px; height: 400px; background: #60a5fa; top: -100px; left: -100px; }
        .circle-2 { width: 300px; height: 300px; background: #818cf8; bottom: -50px; right: -50px; }

        /* Login Card */
        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 2rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            z-index: 10;
            transition: all 0.3s ease;
        }

        .brand-logo {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 1.75rem;
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
        }

        h2 {
            color: var(--text-main);
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: -0.025em;
        }

        .subtitle {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin-bottom: 2rem;
        }

        /* Form Styling */
        .input-group {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
            overflow: hidden;
        }

        .input-group:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: var(--text-muted);
            padding-left: 1rem;
        }

        .form-control {
            border: none;
            padding: 0.75rem 1rem 0.75rem 0.5rem;
            font-size: 0.95rem;
            color: var(--text-main);
            background: transparent;
        }

        .form-control:focus {
            box-shadow: none;
            background: transparent;
        }

        .password-toggle {
            cursor: pointer;
            padding-right: 1rem;
            transition: color 0.2s;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        /* Button */
        .btn-login {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 0.75rem;
            padding: 0.8rem;
            font-weight: 600;
            font-size: 0.95rem;
            margin-top: 1rem;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.25);
        }

        /* Footer links */
        .login-footer {
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .login-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        /* Animation */
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .login-card { animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1); }

    </style>
</head>
<body>

    <div class="bg-circle circle-1"></div>
    <div class="bg-circle circle-2"></div>

    <div class="login-card">
        <div class="text-center">
            <div class="brand-logo">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h2>Selamat Datang</h2>
            <p class="subtitle">Silakan masuk ke akun <strong>MIDC</strong> Anda</p>
        </div>

        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label small fw-medium text-secondary">Username atau Email</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fa-regular fa-envelope"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="admin@midc.id" required name="username">
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between">
                    <label class="form-label small fw-medium text-secondary">Password</label>
                    <a href="#" class="small text-decoration-none" style="color: var(--primary)">Lupa sandi?</a>
                </div>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" class="form-control" id="password" placeholder="••••••••" required name="password">
                    <span class="input-group-text password-toggle" onclick="togglePassword()">
                        <i class="fa-regular fa-eye" id="eyeIcon"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-login w-100" name="login">
                Masuk ke Dashboard
            </button>
        </form>

        <div class="text-center login-footer">
            Belum punya akses? <a href="#">Hubungi Admin</a>
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (password.type === "password") {
                password.type = "text";
                eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                password.type = "password";
                eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>