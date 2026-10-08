<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['description'])) {
    echo "<h3>Data kategori berhasil diterima (ditambahkan):</h3>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
} else {
    echo "Data tidak diterima.";
}
?>
<p><a href="../../pages/categories/index.php">Kembali ke daftar kategori</a></p>
