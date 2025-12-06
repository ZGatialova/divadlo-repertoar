<?php
require_once __DIR__ . '/includes/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM hry WHERE id_hry = ?");
$stmt->execute([$id]);
$hra = $stmt->fetch();

if (!$hra) {
    echo "Hra neexistuje.";
    exit;
}

$errors = [];
$nazov = $hra['nazov'];
$autor = $hra['autor'];
$zaner = $hra['zaner'];
$dlzka = $hra['dlzka'];
$popis = $hra['popis'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nazov = trim($_POST['nazov'] ?? '');
    $autor = trim($_POST['autor'] ?? '');
    $zaner = trim($_POST['zaner'] ?? '');
    $dlzka = trim($_POST['dlzka'] ?? '');
    $popis = trim($_POST['popis'] ?? '');

    if ($nazov === '') {
        $errors[] = 'Názov je povinný.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare(
            "UPDATE hry SET nazov = ?, autor = ?, zaner = ?, dlzka = ?, popis = ? WHERE id_hry = ?"
        );
        $stmt->execute([
            $nazov,
            $autor ?: null,
            $zaner ?: null,
            $dlzka !== '' ? (int)$dlzka : null,
            $popis ?: null,
            $id
        ]);

        header('Location: index.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Upraviť hru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5" style="max-width: 700px;">
    <h1 class="h3 mb-4">Upraviť hru</h1>

    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Názov *</label>
            <input type="text" name="nazov" class="form-control" required
                   value="<?= htmlspecialchars($nazov) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Autor</label>
            <input type="text" name="autor" class="form-control"
                   value="<?= htmlspecialchars($autor) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Žáner</label>
            <input type="text" name="zaner" class="form-control"
                   value="<?= htmlspecialchars($zaner) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Dĺžka (minúty)</label>
            <input type="number" name="dlzka" class="form-control" min="0"
                   value="<?= htmlspecialchars($dlzka) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Popis</label>
            <textarea name="popis" class="form-control" rows="4"><?= htmlspecialchars($popis) ?></textarea>
        </div>

        <div class="d-flex justify-content-between">
            <a href="index.php" class="btn btn-secondary">Späť na zoznam</a>
            <button type="submit" class="btn btn-warning">Uložiť zmeny</button>
        </div>
    </form>
</div>

</body>
</html>
