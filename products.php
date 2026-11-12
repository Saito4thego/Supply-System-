<?php


require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare('INSERT INTO products (supplier_id, product_name, unit_price, stock_qty) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('isdi', $_POST['supplier_id'], $_POST['product_name'], $_POST['unit_price'], $_POST['stock_qty']);
    $stmt->execute();
    header('Location: products.php?msg=' . urlencode('Product added'));
    exit;
}

$suppliers = $conn->query("SELECT supplier_id, company_name FROM suppliers WHERE status = 'Active' ORDER BY company_name");
$products = $conn->query('SELECT p.*, s.company_name FROM products p JOIN suppliers s ON s.supplier_id = p.supplier_id ORDER BY p.product_id DESC');

include 'includes/header.php';
?>
<h4 class='mb-3'>Products</h4>
<div class='card shadow-sm mb-4'>
  <div class='card-body'>
    <form method='post' class='row g-2'>
      <div class='col-md-3'>
        <select name='supplier_id' class='form-select' required>
          <option value=''>Select supplier</option>
          <?php while ($s = $suppliers->fetch_assoc()): ?>
            <option value='<?= $s['supplier_id'] ?>'><?= e($s['company_name']) ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class='col-md-3'><input type='text' name='product_name' class='form-control' placeholder='Product name' required></div>
      <div class='col-md-2'><input type='number' step='0.01' min='0' name='unit_price' class='form-control' placeholder='Price' required></div>
      <div class='col-md-2'><input type='number' min='0' name='stock_qty' class='form-control' placeholder='Stock' required></div>
      <div class='col-md-2 d-grid'><button class='btn btn-primary'>Add</button></div>
    </form>
  </div>
</div>

<div class='card shadow-sm'>
  <div class='table-responsive'>
    <table class='table table-hover align-middle mb-0'>
      <thead><tr><th>ID</th><th>Product</th><th>Supplier</th><th>Price</th><th>Stock</th><th>Actions</th></tr></thead>
      <tbody>
      <?php while ($p = $products->fetch_assoc()): ?>
        <tr>
          <td><?= $p['product_id'] ?></td>
          <td><?= e($p['product_name']) ?></td>
          <td><?= e($p['company_name']) ?></td>
          <td>PHP <?= number_format($p['unit_price'], 2) ?></td>
          <td><span class='badge bg-<?= $p['stock_qty'] < 10 ? 'danger' : 'success' ?>'><?= $p['stock_qty'] ?></span></td>
          <td class='text-nowrap'>
            <a href='edit_product.php?id=<?= $p['product_id'] ?>' class='btn btn-sm btn-warning'>Edit</a>
            <form method='post' action='delete_product.php' class='d-inline' onsubmit='return confirm(`Delete this product?`)'>
              <input type='hidden' name='id' value='<?= $p['product_id'] ?>'>
              <button class='btn btn-sm btn-danger'>Delete</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include 'includes/footer.php'; ?>
