<?php

require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare('INSERT INTO suppliers (company_name, contact_person, email, phone, address, status) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('ssssss', $_POST['company_name'], $_POST['contact_person'], $_POST['email'], $_POST['phone'], $_POST['address'], $_POST['status']);
    $stmt->execute();
    header('Location: suppliers.php?msg=' . urlencode('Supplier added'));
    exit;
}
include 'includes/header.php';
?>
<div class='card shadow-sm'>
  <div class='card-header bg-white'><h5 class='mb-0'>Add Supplier</h5></div>
  <div class='card-body'>
    <form method='post' class='row g-3'>
      <div class='col-md-6'><label class='form-label'>Company Name</label><input type='text' name='company_name' class='form-control' required></div>
      <div class='col-md-6'><label class='form-label'>Contact Person</label><input type='text' name='contact_person' class='form-control' required></div>
      <div class='col-md-6'><label class='form-label'>Email</label><input type='email' name='email' class='form-control' required></div>
      <div class='col-md-6'><label class='form-label'>Phone</label><input type='text' name='phone' class='form-control' required></div>
      <div class='col-12'><label class='form-label'>Address</label><textarea name='address' class='form-control' rows='2'></textarea></div>
      <div class='col-md-6'><label class='form-label'>Status</label><select name='status' class='form-select'><option>Active</option><option>Inactive</option></select></div>
      <div class='col-12'><button class='btn btn-primary'>Save</button> <a href='suppliers.php' class='btn btn-secondary'>Cancel</a></div>
    </form>
  </div>
</div>
<?php include 'includes/footer.php'; ?>
