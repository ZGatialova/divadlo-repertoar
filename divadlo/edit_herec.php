<?php
require_once __DIR__ . '/includes/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM herci WHERE id_herec = ?");
$stmt->execute([$id]);
$herec = $stmt->fetch();

if (!$herec) {
    echo "Herec neexistuje.";
    exit;
}

$errors = [];
$meno = $herec['meno'];
$priezvisko = $herec['priezvisko'];
$datum_narodenia = $herec['datum_narodenia'];
$bio = $herec['bio'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $meno = trim($_POST['meno'] ?? '');
    $priezvisko = trim($_POST['priezvisko'] ?? '');
    $datum_narodenia = trim($_POST['datum_narodenia'] ?? '');
    $bio = trim($_POST['bio'] ?? '');

    if ($meno === '') {
        $errors[] = 'Meno je povinné.';
    }
    if ($priezvisko === '') {
        $errors[] = 'Priezvisko je povinné.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare(
            "UPDATE herci SET meno = ?, priezvisko = ?, datum_narodenia = ?, bio = ? WHERE id_herec = ?"
        );
        $stmt->execute([
            $meno,
            $priezvisko,
            $datum_narodenia !== '' ? $datum_narodenia : null,
            $bio !== '' ? $bio : null,
            $id
        ]);

        header('Location: herci.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Upraviť herca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5" style="max-width: 700px;">
    <h1 class="h3 mb-4">Upraviť herca</h1>

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
            <label class="form-label">Meno *</label>
            <input type="text" name="meno" class="form-control" required
                   value="<?= htmlspecialchars($meno) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Priezvisko *</label>
            <input type="text" name="priezvisko" class="form-control" required
                   value="<?= htmlspecialchars($priezvisko) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Dátum narodenia</label>
            <input type="date" name="datum_narodenia" class="form-control"
                   value="<?= htmlspecialchars($datum_narodenia) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Bio / stručný popis</label>
            <textarea name="bio" class="form-control" rows="4"><?= htmlspecialchars($bio) ?></textarea>
        </div>

        <div class="d-flex justify-content-between">
            <a href="herci.php" class="btn btn-secondary">Späť na zoznam</a>
            <button type="submit" class="btn btn-warning">Uložiť zmeny</button>
        </div>
    </form>
</div>

</body>
</html>
