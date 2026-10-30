<?php
session_start();

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];

unset($_SESSION['errors'], $_SESSION['old']);

$pageTitle = "Tambah Penulis";
$pageSubtitle = "Daftarkan penulis baru ke sistem";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Penulis - Perpustakaan Digital</title>
  <link rel="stylesheet" href="../../styles/authors/create.css">
</head>
<body>
  <div class="app-shell">
  <?php require_once __DIR__ . "/../../components/admin/sidebar.php" ?>

    <main class="app-main">
      <?php require_once __DIR__ . "/../../components/admin/topbar.php" ?>

      <div class="app-content">
        <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
          <ul>
            <?php foreach ($errors as $error): ?>
              <li><?= $error ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>

        <form method="POST" action="../../actions/authors/store.php">
          <div class="form-card">
            <div class="form-section-title">Data Penulis</div>
            <div class="form-group">
              <label for="name">Nama Penulis</label>
              <input type="text" id="name" name="name" placeholder="Contoh: Tere Liye" value="<?= htmlspecialchars($old['name'] ?? '') ?>">
              <?php if (isset($errors['name'])): ?>
                <span class="error-message"><?= $errors['name'] ?></span>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="bio">Biografi Singkat=</label>
              <textarea id="bio" name="bio" rows="3" placeholder="Biografi singkat penulis"><?= htmlspecialchars($old['bio'] ?? '') ?></textarea>
              <?php if (isset($errors['bio'])): ?>
                <span class="error-message"><?= $errors['bio'] ?></span>
              <?php endif; ?>
            </div>

            <div class="form-actions">
              <a href="index.php" class="btn btn-outline">Batal</a>
              <button type="submit" name="store" class="btn btn-primary">Simpan Penulis</button>
            </div>
          </div>
        </form>
      </div>
    </main>
  </div>
</body>
</html>