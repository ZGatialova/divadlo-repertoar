<?php
require_once __DIR__ . '/includes/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM hry WHERE id_hry = ?");
    $stmt->execute([$id]);
}

header('Location: index.php');
exit;
