<?php
require_once __DIR__ . '/includes/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM predstavenia WHERE id_predstavenie = ?");
    $stmt->execute([$id]);
}

header('Location: predstavenia.php');
exit;
