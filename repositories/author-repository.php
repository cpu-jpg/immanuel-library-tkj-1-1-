<?php


function getAuthors()
{
  $authors = [
    ["id" => 1, "name" => "Andrea Hirata",        "bio" => "Penulis asal Belitung, dikenal lewat novel Laskar Pelangi.", "total_books" => 1],
    ["id" => 2, "name" => "Tere Liye",             "bio" => "Penulis novel populer Indonesia, dikenal lewat serial Bumi.", "total_books" => 1],
    ["id" => 3, "name" => "J.K. Rowling",          "bio" => "Penulis asal Inggris, pencipta serial Harry Potter.", "total_books" => 1],
    ["id" => 4, "name" => "Pramoedya Ananta Toer", "bio" => "Sastrawan Indonesia, dikenal lewat Tetralogi Buru.", "total_books" => 2],
    ["id" => 5, "name" => "Sapardi Djoko Damono",  "bio" => "Penyair Indonesia, dikenal lewat puisi Hujan Bulan Juni.", "total_books" => 1],
  ];

  return $authors;
}


function getAuthor()
{
  $author = [
    "id" => 1,
    "name" => "Andrea Hirata",
    "bio" => "Penulis asal Belitung, dikenal lewat novel Laskar Pelangi.",
  ];

  return $author;
}
