<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['isbn'], $_POST['year'], $_POST['stock'], $_POST['category_id'], $_POST['description'])) {
    echo "<h3>Data buku berhasil diterima (ditambahkan):</h3>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
} else {
    echo "Data tidak diterima.";
}
?>
<p><a href="../../pages/books/index.php">Kembali ke daftar buku</a></p>
