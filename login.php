<?php
// login.php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $role = $_POST['role'] ?? '';
  $inputUsername = trim($_POST['username'] ?? '');
  $inputPassword = $_POST['password'] ?? '';

    if ($role === 'admin') {
        // Admin credentials tetap hardcoded
        $username = 'admin';
        $password = 'admin123';

    if ($inputUsername === $username && $inputPassword === $password) {
      session_regenerate_id(true);
            $_SESSION['loggedin'] = true;
            $_SESSION['role'] = 'admin';
      $_SESSION['username'] = $inputUsername;
            header("Location: adminn.php");
            exit;
        } else {
            $error = "Username atau password admin salah.";
        }
    } else {
        // Untuk role user, terima semua username/password non-kosong
    if ($inputUsername !== '' && $inputPassword !== '') {
      session_regenerate_id(true);
            $_SESSION['loggedin'] = true;
            $_SESSION['role'] = 'user';
      $_SESSION['username'] = $inputUsername;
            header("Location: index.php");
            exit;
        } else {
            $error = "Masukkan username dan password untuk login user.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - DapurKita</title>
  <style>
    :root {
      --primary-color: #2e7d32;
      --primary-light: #60ad5e;
      --primary-dark: #005005;
      --accent-color: #8bc34a;
      --text-light: #f5f5f5;
      --text-dark: #333;
      --bg-color: #f8f9fa;
      --card-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    body {
      background-color: var(--bg-color);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background-image: linear-gradient(135deg, rgba(46, 125, 50, 0.1) 0%, rgba(139, 195, 74, 0.1) 100%);
    }
    
    .login-wrapper {
      width: 100%;
      max-width: 420px;
      padding: 20px;
    }
    
    .login-card {
      background: white;
      border-radius: 12px;
      padding: 40px;
      box-shadow: var(--card-shadow);
      text-align: center;
    }
    
    .logo {
      width: 120px;
      margin-bottom: 20px;
    }
    
    h2 {
      color: var(--primary-dark);
      margin-bottom: 24px;
      font-weight: 600;
    }
    
    .tabs {
      display: flex;
      margin-bottom: 24px;
      border-radius: 8px;
      overflow: hidden;
      background-color: #f0f0f0;
    }
    
    .tab-button {
      flex: 1;
      padding: 12px;
      border: none;
      background: transparent;
      cursor: pointer;
      font-weight: 500;
      color: var(--text-dark);
      transition: all 0.3s ease;
    }
    
    .tab-button.active {
      background: var(--primary-color);
      color: white;
    }
    
    .input-group {
      margin-bottom: 20px;
      text-align: left;
    }
    
    .input-group label {
      display: block;
      margin-bottom: 8px;
      color: var(--text-dark);
      font-weight: 500;
    }
    
    .input-group input {
      width: 100%;
      padding: 12px 16px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 16px;
      transition: border 0.3s;
    }
    
    .input-group input:focus {
      outline: none;
      border-color: var(--primary-light);
      box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.2);
    }
    
    .submit-btn {
      width: 100%;
      padding: 14px;
      background-color: var(--primary-color);
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s;
      margin-top: 10px;
    }
    
    .submit-btn:hover {
      background-color: var(--primary-dark);
    }
    
    .error {
      color: #d32f2f;
      background-color: #fce4ec;
      padding: 12px;
      border-radius: 8px;
      margin-bottom: 20px;
      font-size: 14px;
    }
    
    @media (max-width: 480px) {
      .login-card {
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>
  <div class="login-wrapper">
    <div class="login-card">
      <img src="assets/resep.jpg" alt="DapurKita Logo" class="logo">
      <h2>Selamat Datang di DapurKita</h2>

      <?php if (isset($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>

      <div class="tabs">
        <button class="tab-button active" data-role="admin">Admin</button>
        <button class="tab-button" data-role="user">User</button>
      </div>

      <form id="loginForm" method="POST" action="login.php">
        <input type="hidden" name="role" id="roleInput" value="admin">

        <div class="input-group">
          <label for="username">Email atau Username</label>
          <input type="text" name="username" id="username" required placeholder="Masukkan username Anda">
        </div>

        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" required placeholder="Masukkan password Anda">
        </div>

        <button type="submit" class="submit-btn">Masuk</button>
      </form>
    </div>
  </div>

  <script>
    const tabs = document.querySelectorAll('.tab-button');
    const roleInput = document.getElementById('roleInput');

    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        roleInput.value = tab.dataset.role;
      });
    });
  </script>
</body>
</html>