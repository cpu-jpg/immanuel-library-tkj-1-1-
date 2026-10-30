<?php
require_once __DIR__ . "/../../repositories/category-repository.php";
require_once __DIR__ . "/../../repositories/author-repository.php";

session_start();

$categories = getCategories();
$authors = getAuthors();

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];

unset($_SESSION['errors'], $_SESSION['old']);

$pageTitle = "Tambah Buku";
$pageSubtitle = "Lengkapi data buku, kategori, dan penulis";
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Buku - Perpustakaan Digital</title>
  <link rel="stylesheet" href="../../styles/books/create.css">
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

        <form method="POST" action="../../actions/books/store.php">
          <div class="form-card" style="margin-bottom:20px;">
            <div class="form-section-title">Data Buku</div>
            <div class="form-group">
              <label for="title">Judul Buku</label>
              <input type="text" id="title" name="title" placeholder="Contoh: Laskar Pelangi" value="<?= htmlspecialchars($old['title'] ?? '') ?>">
              <?php if (isset($errors['title'])): ?>
                <span class="error-message"><?= $errors['title'] ?></span>
              <?php endif; ?>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" id="isbn" name="isbn" placeholder="Contoh: 978-979-1227-78-0" value="<?= htmlspecialchars($old['isbn'] ?? '') ?>">
                <?php if (isset($errors['isbn'])): ?>
                  <span class="error-message"><?= $errors['isbn'] ?></span>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <label for="year">Tahun Terbit</label>
                <input type="number" id="year" name="year" placeholder="Contoh: 2005" value="<?= htmlspecialchars($old['year'] ?? '') ?>">
                <?php if (isset($errors['year'])): ?>
                  <span class="error-message"><?= $errors['year'] ?></span>
                <?php endif; ?>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label for="stock">Jumlah Stok</label>
                <input type="number" id="stock" name="stock" placeholder="Contoh: 10" value="<?= htmlspecialchars($old['stock'] ?? '') ?>">
                <?php if (isset($errors['stock'])): ?>
                  <span class="error-message"><?= $errors['stock'] ?></span>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <label for="category_id">Kategori</label>
                <select id="category_id" name="category_id">
                  <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= ($old['category_id'] ?? '') == $category['id'] ? 'selected' : '' ?>><?= $category['name'] ?></option>
                  <?php endforeach; ?>
                </select>
                <?php if (isset($errors['category_id'])): ?>
                  <span class="error-message"><?= $errors['category_id'] ?></span>
                <?php endif; ?>
              </div>
            </div>
            <div class="form-group">
              <label for="description">Deskripsi</label>
              <textarea id="description" name="description" rows="3" placeholder="Sinopsis singkat buku"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
              <?php if (isset($errors['description'])): ?>
                <span class="error-message"><?= $errors['description'] ?></span>
              <?php endif; ?>
            </div>
          </div>

          <div class="form-card">
            <div class="form-section-title">Penulis Buku</div>
            <div class="form-group">
              <label>Pilih Penulis (bisa lebih dari satu)</label>
              <div class="checkbox-grid">
                <?php foreach ($authors as $author): ?>
                  <label class="checkbox-item">
                    <input type="checkbox" name="author_ids[]" value="<?= $author['id'] ?>" <?= in_array($author['id'], $old['author_ids'] ?? []) ? 'checked' : '' ?>>
                    <?= $author['name'] ?>
                  </label>
                <?php endforeach; ?>
              </div>
              <?php if (isset($errors['author_ids'])): ?>
                <span class="error-message"><?= $errors['author_ids'] ?></span>
              <?php endif; ?>
            </div>

            <div class="form-actions">
              <a href="index.php" class="btn btn-outline">Batal</a>
              <button type="submit" name="store" class="btn btn-primary">Simpan Buku</button>
            </div>
          </div>
        </form>
      </div>
    </main>
  </div>
</body>

</html>