<?php

require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $stmt = $conn->prepare('DELETE FROM suppliers WHERE supplier_id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
}
header('Location: suppliers.php?msg=' . urlencode('Supplier deleted'));
exit;
