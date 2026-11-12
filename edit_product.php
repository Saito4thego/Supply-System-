<?php

require_once 'db_connect.php';
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare('UPDATE products SET supplier_id=?, product_name=?, unit_price=?, stock_qty=? WHERE product_id=?');
    $stmt->bind_param('isdii', $_POST['supplier_id'], $_POST['product_name'], $_POST['unit_price'], $_POST['stock_qty'], $id);
    $stmt->execute();
    header('Location: products.php?msg=' . urlencode('Product updated'));
    exit;
}

$stmt = $conn->prepare('SELECT * FROM products WHERE product_id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$p = $stmt->get_result()->fetch_assoc();
if (!$p) { header('Location: products.php'); exit; }

$suppliers = $conn->query('SELECT supplier_id, company_name FROM suppliers ORDER BY company_name');
include 'includes/header.php';
?>
<div class='card shadow-sm'>
  <div class='card-header bg-white'><h5 class='mb-0'>Edit Product</h5></div>
  <div class='card-body'>
    <form method='post' class='row g-3'>
      <input type='hidden' name='id' value='<?= $p['product_id'] ?>'>
      <div class='col-md-6'><label class='form-label'>Supplier</label>
        <select name='supplier_id' class='form-select'>
          <?php while ($s = $suppliers->fetch_assoc()): ?>
            <option value='<?= $s['supplier_id'] ?>' <?= $s['supplier_id'] == $p['supplier_id'] ? 'selected' : '' ?>><?= e($s['company_name']) ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class='col-md-6'><label class='form-label'>Product Name</label><input type='text' name='product_name' value='<?= e($p['product_name']) ?>' class='form-control' required></div>
      <div class='col-md-6'><label class='form-label'>Unit Price</label><input type='number' step='0.01' min='0' name='unit_price' value='<?= e($p['unit_price']) ?>' class='form-control' required></div>
      <div class='col-md-6'><label class='form-label'>Stock</label><input type='number' min='0' name='stock_qty' value='<?= e($p['stock_qty']) ?>' class='form-control' required></div>
      <div class='col-12'><button class='btn btn-primary'>Update</button> <a href='products.php' class='btn btn-secondary'>Cancel</a></div>
    </form>
  </div>
</div>
<?php include 'includes/footer.php'; ?>
