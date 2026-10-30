<?php

function validateBook($data)
{
    $errors = [];

    if (empty($data['title'])) {
        $errors['title'] = "Judul buku wajib diisi";
    } elseif (strlen($data['title']) < 3) {
        $errors['title'] = "Judul buku minimal 3 huruf atau karakter";
    }

    if (empty($data['isbn'])) {
        $errors['isbn'] = "ISBN tidak boleh dikosongkan";
    }

    // Year validation
    if (empty($data['year'])) {
        $errors['year'] = "Tahun terbit wajib diisi";
    } elseif (!is_numeric($data['year'])) {
        $errors['year'] = "Tahun terbit harus berupa angka";
    }

  
    if (empty($data['stock'])) {
        $errors['stock'] = "Jumlah tidak boleh dikosongkan";
    } elseif (!is_numeric($data['stock'])) {
        $errors['stock'] = "Jumlah stok harus berupa angka tidak boleh mengandung 
        huruf atau karakter";
    }

    if (empty($data['category_id'])) {
        $errors['category_id'] = "Kategori tidak boleh dikosongkan";
    }

    if (empty($data['description'])) {
        $errors['description'] = "Deskripsi tidak boleh dikosongkan";
    }

    if (empty($data['author_ids']) || count($data['author_ids']) === 0) {
        $errors['author_ids'] = "Pilih setidaknya satu penulis";
    }

    return $errors;
}

function validateBookUpdate($data)
{
    $errors = [];


    if (empty($data['title'])) {
        $errors['title'] = "Judul buku wajib diisi";
    } elseif (strlen($data['title']) < 3) {
        $errors['title'] = "Judul buku minimal 3 karakter";
    }


    if (empty($data['isbn'])) {
        $errors['isbn'] = "ISBN wajib diisi";
    }


    if (empty($data['year'])) {
        $errors['year'] = "Tahun terbit wajib diisi";
    } elseif (!is_numeric($data['year'])) {
        $errors['year'] = "Tahun terbit harus berupa angka";
    }

    if (empty($data['stock'])) {
        $errors['stock'] = "Jumlah stok wajib diisi";
    } elseif (!is_numeric($data['stock'])) {
        $errors['stock'] = "Jumlah stok harus berupa angka";
    }

    if (empty($data['category_id'])) {
        $errors['category_id'] = "Kategori wajib dipilih";
    }

    return $errors;
}
?>