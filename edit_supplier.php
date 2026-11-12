<?php

require_once 'db_connect.php';
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare('UPDATE suppliers SET company_name=?, contact_person=?, email=?, phone=?, address=?, status=? WHERE supplier_id=?');
    $stmt->bind_param('ssssssi', $_POST['company_name'], $_POST['contact_person'], $_POST['email'], $_POST['phone'], $_POST['address'], $_POST['status'], $id);
    $stmt->execute();
    header('Location: suppliers.php?msg=' . urlencode('Supplier updated'));
    exit;
}

$stmt = $conn->prepare('SELECT * FROM suppliers WHERE supplier_id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$s = $stmt->get_result()->fetch_assoc();
if (!$s) { header('Location: suppliers.php'); exit; }

include 'includes/header.php';
?>
<div class='card shadow-sm'>
  <div class='card-header bg-white'><h5 class='mb-0'>Edit Supplier</h5></div>
  <div class='card-body'>
    <form method='post' class='row g-3'>
      <input type='hidden' name='id' value='<?= $s['supplier_id'] ?>'>
      <div class='col-md-6'><label class='form-label'>Company Name</label><input type='text' name='company_name' value='<?= e($s['company_name']) ?>' class='form-control' required></div>
      <div class='col-md-6'><label class='form-label'>Contact Person</label><input type='text' name='contact_person' value='<?= e($s['contact_person']) ?>' class='form-control' required></div>
      <div class='col-md-6'><label class='form-label'>Email</label><input type='email' name='email' value='<?= e($s['email']) ?>' class='form-control' required></div>
      <div class='col-md-6'><label class='form-label'>Phone</label><input type='text' name='phone' value='<?= e($s['phone']) ?>' class='form-control' required></div>
      <div class='col-12'><label class='form-label'>Address</label><textarea name='address' class='form-control' rows='2'><?= e($s['address']) ?></textarea></div>
      <div class='col-md-6'><label class='form-label'>Status</label>
        <select name='status' class='form-select'>
          <option <?= $s['status'] === 'Active' ? 'selected' : '' ?>>Active</option>
          <option <?= $s['status'] === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
        </select>
      </div>
      <div class='col-12'><button class='btn btn-primary'>Update</button> <a href='suppliers.php' class='btn btn-secondary'>Cancel</a></div>
    </form>
  </div>
</div>
<?php include 'includes/footer.php'; ?>
