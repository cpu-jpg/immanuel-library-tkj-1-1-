<?php
require_once __DIR__ . "/../../repositories/author-repository.php";

session_start();

$id = $_GET['id'] ?? '';
$author = getAuthor($id);

if (!$author) {
    header("Location: index.php");
    exit();
}

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];

unset($_SESSION['errors'], $_SESSION['old']);

$pageTitle = "Edit Penulis";
$pageSubtitle = "Perbarui data penulis";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Penulis - Perpustakaan Digital</title>
  <link rel="stylesheet" href="../../styles/authors/edit.css">
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

        <form method="POST" action="../../actions/authors/update.php">
          <input type="hidden" name="id" value="<?= $author['id'] ?>">
          <div class="form-card">
            <div class="form-section-title">Data Penulis</div>
            <div class="form-group">
              <label for="name">Nama Penulis</label>
              <input type="text" id="name" name="name" value="<?= $author['name'] ?>">
              <?php if (isset($errors['name'])): ?>
                <span class="error-message"><?= $errors['name'] ?></span>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="bio">Biografi Singkat</label>
              <textarea id="bio" name="bio" rows="3"><?= $author['bio'] ?></textarea>
              <?php if (isset($errors['bio'])): ?>
                <span class="error-message"><?= $errors['bio'] ?></span>
              <?php endif; ?>
            </div>
            <div class="form-actions">
              <a href="index.php" class="btn btn-outline">Batal</a>
              <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
            </div>
          </div>
        </form>
      </div>
    </main>
  </div>
</body>

</html>