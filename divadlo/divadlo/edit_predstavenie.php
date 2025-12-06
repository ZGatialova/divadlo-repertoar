<?php
require_once __DIR__ . '/includes/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;


$stmt = $pdo->prepare("SELECT * FROM predstavenia WHERE id_predstavenie = ?");
$stmt->execute([$id]);
$predstavenie = $stmt->fetch();

if (!$predstavenie) {
    echo "Predstavenie neexistuje.";
    exit;
}


$stmtHry = $pdo->query("SELECT id_hry, nazov FROM hry ORDER BY nazov");
$hry = $stmtHry->fetchAll();

$errors = [];
$id_hry = $predstavenie['id_hry'];
$datum = $predstavenie['datum'];
$cas = $predstavenie['cas'];
$miesto = $predstavenie['miesto'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_hry = (int)($_POST['id_hry'] ?? 0);
    $datum = trim($_POST['datum'] ?? '');
    $cas = trim($_POST['cas'] ?? '');
    $miesto = trim($_POST['miesto'] ?? '');

    if ($id_hry <= 0) {
        $errors[] = 'Vyber hru.';
    }
    if ($datum === '') {
        $errors[] = 'Dátum je povinný.';
    }
    if ($cas === '') {
        $errors[] = 'Čas je povinný.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare(
            "UPDATE predstavenia SET id_hry = ?, datum = ?, cas = ?, miesto = ? WHERE id_predstavenie = ?"
        );
        $stmt->execute([$id_hry, $datum, $cas, $miesto !== '' ? $miesto : null, $id]);

        header('Location: predstavenia.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Upraviť predstavenie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5" style="max-width: 700px;">
    <h1 class="h3 mb-4">Upraviť predstavenie</h1>

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
            <label class="form-label">Hra *</label>
            <select name="id_hry" class="form-select" required>
                <option value="">-- vyber hru --</option>
                <?php foreach ($hry as $hra): ?>
                    <option value="<?= (int)$hra['id_hry'] ?>" <?= $id_hry == $hra['id_hry'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($hra['nazov']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Dátum *</label>
            <input type="date" name="datum" class="form-control" required
                   value="<?= htmlspecialchars($datum) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Čas *</label>
            <input type="time" name="cas" class="form-control" required
                   value="<?= htmlspecialchars(substr($cas, 0, 5)) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Miesto</label>
            <input type="text" name="miesto" class="form-control"
                   value="<?= htmlspecialchars($miesto) ?>">
        </div>

        <div class="d-flex justify-content-between">
            <a href="predstavenia.php" class="btn btn-secondary">Späť na zoznam</a>
            <button type="submit" class="btn btn-warning">Uložiť zmeny</button>
        </div>
    </form>
</div>

</body>
</html>
