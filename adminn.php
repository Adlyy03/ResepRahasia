<?php
session_start();
include('inc/db.php');

// Cek apakah admin sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Proses tambah resep
if (isset($_POST['tambah'])) {
    $nama_resep = trim($_POST['nama_resep'] ?? '');
    $bahan = trim($_POST['bahan'] ?? '');
    $langkah = trim($_POST['langkah'] ?? '');
    $waktu_persiapkan = trim($_POST['waktu_persiapkan'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');

    if ($nama_resep !== '' && $bahan !== '' && $langkah !== '' && $waktu_persiapkan !== '' && $kategori !== '') {
        $stmt = $conn->prepare("INSERT INTO resep (nama_resep, bahan, langkah, waktu_persiapkan, kategori) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nama_resep, $bahan, $langkah, $waktu_persiapkan, $kategori);
        $stmt->execute();
    }
    header("Location: adminn.php");
    exit;
}

// Proses update resep
if (isset($_POST['update'])) {
    $id = (int)($_POST['id'] ?? 0);
    $nama_resep = trim($_POST['nama_resep'] ?? '');
    $bahan = trim($_POST['bahan'] ?? '');
    $langkah = trim($_POST['langkah'] ?? '');
    $waktu_persiapkan = trim($_POST['waktu_persiapkan'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');

    if ($id > 0 && $nama_resep !== '' && $bahan !== '' && $langkah !== '' && $waktu_persiapkan !== '' && $kategori !== '') {
        $stmt = $conn->prepare("UPDATE resep SET nama_resep = ?, bahan = ?, langkah = ?, waktu_persiapkan = ?, kategori = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $nama_resep, $bahan, $langkah, $waktu_persiapkan, $kategori, $id);
        $stmt->execute();
    }
    header("Location: adminn.php");
    exit;
}

// Proses hapus resep
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM resep WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
    header("Location: adminn.php");
    exit;
}

$editData = null;
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    if ($editId > 0) {
        $stmt = $conn->prepare("SELECT * FROM resep WHERE id = ?");
        $stmt->bind_param("i", $editId);
        $stmt->execute();
        $editResult = $stmt->get_result();
        if ($editResult && $editResult->num_rows > 0) {
            $editData = $editResult->fetch_assoc();
        }
    }
}

// Ambil semua resep
$sql = "SELECT * FROM resep";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - DapurKita</title>
    <style>
        :root {
            --primary: #2e7d32;
            --primary-light: #60ad5e;
            --primary-dark: #005005;
            --bg: #f8f9fa;
            --text: #333;
        }

        body {
            background-color: var(--bg);
            font-family: 'Segoe UI', Tahoma, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .card {
            background: white;
            width: 100%;
            max-width: 900px;
            margin-bottom: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            padding: 30px;
        }

        h1, h2 {
            color: var(--primary-dark);
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input[type="text"], textarea {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }

        button {
            padding: 12px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: var(--primary-dark);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        table th {
            background-color: var(--primary-light);
            color: white;
        }

        .actions a {
            color: var(--primary);
            text-decoration: none;
            margin-right: 10px;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .card {
                padding: 20px;
            }

            table {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    

    <!-- Card Daftar Resep -->
    <div class="card">
        <h2>Daftar Resep</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nama Resep</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo (int)$row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['nama_resep']); ?></td>
                <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                <td class="actions">
                    <a href="adminn.php?edit=<?php echo (int)$row['id']; ?>">Edit</a>
                    <a href="adminn.php?hapus=<?php echo (int)$row['id']; ?>" onclick="return confirm('Hapus resep ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- Card Form Tambah Resep -->
    <div class="card">
            <h2><?php echo $editData ? 'Edit Resep' : 'Tambah Resep Baru'; ?></h2>
            <form method="POST" action="adminn.php">
                <?php if ($editData): ?>
                    <input type="hidden" name="id" value="<?php echo (int)$editData['id']; ?>">
                <?php endif; ?>
                <input type="text" name="nama_resep" placeholder="Nama Resep" required value="<?php echo htmlspecialchars($editData['nama_resep'] ?? ''); ?>">
                <textarea name="bahan" placeholder="Bahan-bahan" required><?php echo htmlspecialchars($editData['bahan'] ?? ''); ?></textarea>
                <textarea name="langkah" placeholder="Langkah-langkah" required><?php echo htmlspecialchars($editData['langkah'] ?? ''); ?></textarea>
                <input type="text" name="waktu_persiapkan" placeholder="Waktu Persiapan (menit)" required value="<?php echo htmlspecialchars($editData['waktu_persiapkan'] ?? ''); ?>">
                <input type="text" name="kategori" placeholder="Kategori" required value="<?php echo htmlspecialchars($editData['kategori'] ?? ''); ?>">
                <?php if ($editData): ?>
                    <button type="submit" name="update">Simpan Perubahan</button>
                <?php else: ?>
                    <button type="submit" name="tambah">Tambah Resep</button>
                <?php endif; ?>
            </form>
        </div>


</body>
</html>
