<?php

function validateAuthor($data)
{
    $errors = [];


    if (empty($data['name'])) {
        $errors['name'] = "Penulis wajib diisi";
    } elseif (strlen($data['name']) < 3) {
        $errors['name'] = "Penulis minimal 3 karar";
    }

   
    if (empty($data['bio'])) {
        $errors['bio'] = "Bio wajib diisi";
    }

    return $errors;
}

function validateAuthorUpdate($data)
{
    $errors = [];

    if (empty($data['name'])) {
        $errors['name'] = "Penulis wajib diisi";
    } elseif (strlen($data['name']) < 3) {
        $errors['name'] = "Penulis minimal 3 karakter";
    }

  
    if (empty($data['bio'])) {
        $errors['bio'] = "Bio penulis wajib diisi";
    }

    return $errors;
}