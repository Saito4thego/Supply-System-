<?php
require_once 'db_connect.php';

$q = trim($_GET['q'] ?? '');
$status = $_GET['status'] ?? '';
$like = '%' . $q . '%';

$sql = "SELECT s.*, (SELECT COUNT(*) FROM products p WHERE p.supplier_id = s.supplier_id) AS product_count
        FROM suppliers s
        WHERE (s.company_name LIKE ? OR s.contact_person LIKE ?) AND (? = '' OR s.status = ?)
        ORDER BY s.supplier_id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssss', $like, $like, $status, $status);
$stmt->execute();
$result = $stmt->get_result();

include 'includes/header.php';
?>
<div class='d-flex justify-content-between align-items-center mb-3'>
  <h4 class='mb-0'>Suppliers</h4>
  <a href='add_supplier.php' class='btn btn-primary'><i class='bi bi-plus-lg'></i> Add Supplier</a>
</div>

<form method='get' class='row g-2 mb-3'>
  <div class='col-md-6'><input type='text' name='q' value='<?= e($q) ?>' class='form-control' placeholder='Search company or contact person'></div>
  <div class='col-md-3'>
    <select name='status' class='form-select'>
      <option value=''>All status</option>
      <option value='Active' <?= $status === 'Active' ? 'selected' : '' ?>>Active</option>
      <option value='Inactive' <?= $status === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
    </select>
  </div>
  <div class='col-md-3'><button class='btn btn-outline-primary'>Filter</button> <a href='suppliers.php' class='btn btn-outline-secondary'>Reset</a></div>
</form>

<div class='card shadow-sm'>
  <div class='table-responsive'>
    <table class='table table-hover align-middle mb-0'>
      <thead><tr><th>ID</th><th>Company</th><th>Contact</th><th>Phone</th><th>Status</th><th>Products</th><th>Actions</th></tr></thead>
      <tbody>
      <?php if ($result->num_rows === 0): ?>
        <tr><td colspan='7' class='text-center text-muted py-4'>No suppliers found.</td></tr>
      <?php endif; ?>
      <?php while ($r = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $r['supplier_id'] ?></td>
          <td><?= e($r['company_name']) ?></td>
          <td><?= e($r['contact_person']) ?><br><small class='text-muted'><?= e($r['email']) ?></small></td>
          <td><?= e($r['phone']) ?></td>
          <td><span class='badge bg-<?= $r['status'] === 'Active' ? 'success' : 'secondary' ?>'><?= e($r['status']) ?></span></td>
          <td><?= $r['product_count'] ?></td>
          <td class='text-nowrap'>
            <a href='edit_supplier.php?id=<?= $r['supplier_id'] ?>' class='btn btn-sm btn-warning'>Edit</a>
            <form method='post' action='delete_supplier.php' class='d-inline' onsubmit='return confirm(`Delete this supplier and all its products?`)'>
              <input type='hidden' name='id' value='<?= $r['supplier_id'] ?>'>
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
