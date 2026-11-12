<?php

require_once 'db_connect.php';

$total    = $conn->query('SELECT COUNT(*) c FROM suppliers')->fetch_assoc()['c'];
$active   = $conn->query("SELECT COUNT(*) c FROM suppliers WHERE status = 'Active'")->fetch_assoc()['c'];
$products = $conn->query('SELECT COUNT(*) c FROM products')->fetch_assoc()['c'];
$value    = $conn->query('SELECT COALESCE(SUM(unit_price * stock_qty), 0) v FROM products')->fetch_assoc()['v'];
$low      = $conn->query('SELECT p.product_name, p.stock_qty, s.company_name, s.phone FROM products p JOIN suppliers s ON s.supplier_id = p.supplier_id WHERE p.stock_qty < 10 ORDER BY p.stock_qty');

include 'includes/header.php';
?>
<h4 class='mb-3'>Dashboard</h4>
<div class='row g-3 mb-4'>
  <div class='col-6 col-lg-3'><div class='card shadow-sm stat-card text-center p-3'><small class='text-muted'>Total Suppliers</small><h2><?= $total ?></h2></div></div>
  <div class='col-6 col-lg-3'><div class='card shadow-sm stat-card text-center p-3'><small class='text-muted'>Active Suppliers</small><h2 class='text-success'><?= $active ?></h2></div></div>
  <div class='col-6 col-lg-3'><div class='card shadow-sm stat-card text-center p-3'><small class='text-muted'>Products</small><h2><?= $products ?></h2></div></div>
  <div class='col-6 col-lg-3'><div class='card shadow-sm stat-card text-center p-3'><small class='text-muted'>Inventory Value</small><h2 class='text-primary'>PHP <?= number_format($value, 2) ?></h2></div></div>
</div>

<div class='card shadow-sm'>
  <div class='card-header bg-white'><h5 class='mb-0 text-danger'><i class='bi bi-exclamation-triangle'></i> Low Stock (below 10)</h5></div>
  <div class='table-responsive'>
    <table class='table mb-0'>
      <thead><tr><th>Product</th><th>Stock</th><th>Supplier</th><th>Call</th></tr></thead>
      <tbody>
      <?php if ($low->num_rows === 0): ?>
        <tr><td colspan='4' class='text-center text-muted py-3'>All products are well stocked.</td></tr>
      <?php endif; ?>
      <?php while ($r = $low->fetch_assoc()): ?>
        <tr>
          <td><?= e($r['product_name']) ?></td>
          <td><span class='badge bg-danger'><?= $r['stock_qty'] ?></span></td>
          <td><?= e($r['company_name']) ?></td>
          <td><?= e($r['phone']) ?></td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include 'includes/footer.php'; ?>
