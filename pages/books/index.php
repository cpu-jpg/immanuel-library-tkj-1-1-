<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header('Location: /pages/auth/login.php');
    exit();
}

require_once __DIR__ . "/../../repositories/book-repository.php";

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10;
$filters = $_GET['filters'] ?? [];

$books = getBooks($filters, $page, $perPage);
$totalBooks = countBooks($filters);
$totalPages = ceil($totalBooks / $perPage);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Buku - Perpustakaan Digital</title>
  <link rel="stylesheet" href="../../styles/books/index.css">
</head>

<body>
  <div class="app-shell">
    <?php require_once __DIR__ . "/../../components/admin/sidebar.php" ?>

    <main class="app-main">
      <?php require_once __DIR__ . "/../../components/admin/topbar.php" ?>

      <div class="app-content">
        <div class="toolbar">
          <form method="GET" action="" class="toolbar-filters">
            <div class="search-box">
              <svg class="icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="7" />
                <path d="m21 21-4.3-4.3" />
              </svg>
              <input type="text" name="search" class="search-input"
                placeholder="Cari judul buku..." value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
            </div>
            <select name="category" class="filter-select">
              <option value="">Semua Kategori</option>
              <option value="Fiksi" <?= ($filters['category'] ?? '') == 'Fiksi' ? 'selected' : '' ?>>Fiksi</option>
              <option value="Sains" <?= ($filters['category'] ?? '') == 'Sains' ? 'selected' : '' ?>>Sains</option>
              <option value="Sejarah" <?= ($filters['category'] ?? '') == 'Sejarah' ? 'selected' : '' ?>>Sejarah</option>
              <option value="Teknologi" <?= ($filters['category'] ?? '') == 'Teknologi' ? 'selected' : '' ?>>Teknologi</option>
            </select>
            <button type="submit" class="btn btn-outline btn-sm">Cari</button>
          </form>
          <a href="create.php" class="btn btn-primary">+ Tambah Buku</a>
        </div>

        <div class="data-card">
          <table class="data-table">
            <thead>
              <tr>
                <th>Judul Buku</th>
                <th>Kategori</th>
                <th>Penulis</th>
                <th>Stok</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($books as $index => $book): ?>
                <tr>
                  <td>
                    <div class="cell-primary">
                      <span class="cell-thumb"><svg class="icon" width="16" height="16" viewBox="0 0 24 24"
                          fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round">
                          <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                          <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z" />
                        </svg></span>
                      <a href="show.php?id=<?= $book['id'] ?>" style="color:inherit;"><?= $book['title'] ?></a>
                    </div>
                  </td>
                  <td><span class="badge badge-muted"><?= $book['category'] ?></span></td>
                  <td>
                    <div class="chip-list">
                      <?php foreach ($book['authors'] as $author): ?>
                        <span class="chip">
                          <?= $author ?>
                        </span>
                      <?php endforeach ?>
                    </div>
                  </td>
                  <td><?= $book['stock'] ?></td>
                  <td>
                    <div class="cell-actions">
                      <a href="edit.php?id=<?= $book['id'] ?>" class="btn btn-outline btn-sm">Edit</a>
                      <a href="../../actions/books/destroy.php?id=<?= $book['id'] ?>" class="btn btn-danger btn-sm"
                        onclick="return confirm('Yakin ingin menghapus buku ini?')">Hapus</a>
                    </div>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>

        <div class="pagination">
          <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>&filters=<?= http_build_query($filters) ?>" class="pagination-btn"><</a>
          <?php endif; ?>

          <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>&filters=<?= http_build_query($filters) ?>" class="pagination-btn">></a>
          <?php endif; ?>

          <?php if ($totalPages > 1): ?>
            <span>
              Halaman <?= $page ?> dari <?= $totalPages ?>
            </span>
          <?php endif; ?>
        </div>
      </div>
    </main>
  </div>

</html>