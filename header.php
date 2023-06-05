<?php $file_name = explode(".", basename($_SERVER['PHP_SELF']))[0]; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title : "Country State" ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
      .nav-link.active {
        font-weight: bold;
      }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
  <div class="container">
    <a class="navbar-brand fw-bold" href="countries.php">Country City</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?= in_array($file_name, ["countries", "create-country", "edit-country"]) ? "active" : "" ?>" aria-current="page" href="/countries.php">Country</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= in_array($file_name, ["states", "create-state", "edit-state"]) ? "active" : "" ?>" aria-current="page" href="/states.php">States</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= in_array($file_name, ["cities", "edit-city"]) ? "active" : "" ?>" aria-current="page" href="/cities.php">Cities</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
    <div class="container my-5">

      