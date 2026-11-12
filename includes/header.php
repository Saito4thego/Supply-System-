<?php require_once __DIR__ . '/../db_connect.php'; ?>
<!DOCTYPE html>
<html lang='en'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <title>SupplierHub - Supplier Management System</title>
  <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
  <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css' rel='stylesheet'>
  <link href='css/style.css' rel='stylesheet'>
</head>
<body>
<nav class='navbar navbar-expand-lg navbar-dark bg-primary mb-4'>
  <div class='container'>
    <a class='navbar-brand' href='index.php'><i class='bi bi-truck'></i> SupplierHub</a>
    <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#mainNav'>
      <span class='navbar-toggler-icon'></span>
    </button>
    <div class='collapse navbar-collapse' id='mainNav'>
      <ul class='navbar-nav ms-auto'>
        <li class='nav-item'><a class='nav-link' href='index.php'>Dashboard</a></li>
        <li class='nav-item'><a class='nav-link' href='suppliers.php'>Suppliers</a></li>
        <li class='nav-item'><a class='nav-link' href='products.php'>Products</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class='container'>
<?php if (isset($_GET['msg'])): ?>
  <div class='alert alert-success alert-dismissible fade show'>
    <?= e($_GET['msg']) ?>
    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
  </div>
<?php endif; ?>
