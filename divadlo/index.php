<?php
require_once __DIR__ . '/includes/db.php';


$stmt = $pdo->query("SELECT * FROM hry ORDER BY nazov");
$hry = $stmt->fetchAll();
?>
<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Repertoár divadla</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f6f1e8;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        .navbar {
            background-color: #fff8ec;
            border-bottom: 1px solid #e3d2b8;
        }
        .navbar-brand {
            font-weight: 600;
            letter-spacing: 0.03em;
        }
        .page-title {
            font-family: "Playfair Display", Georgia, "Times New Roman", serif;
        }
        .card {
            border: 1px solid #e3d2b8;
        }
        .badge-genre {
            background-color: #d4a857;
        }
        footer {
            border-top: 1px solid #e3d2b8;
            background-color: #fff8ec;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="index.php">Repertoár divadla</a>
    </div>
</nav>

<main class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title h2 mb-0">Aktuálne hry</h1>
        <a href="add_hra.php" class="btn btn-outline-warning">Pridať novú hru</a>
    </div>

    <?php if (count($hry) === 0): ?>
        <div class="alert alert-info">
            Zatiaľ nie sú v databáze žiadne hry.
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($hry as $hra): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-1">
                                <?= htmlspecialchars($hra['nazov']) ?>
                            </h5>
                            <?php if (!empty($hra['autor'])): ?>
                                <p class="text-muted mb-2">
                                    od <?= htmlspecialchars($hra['autor']) ?>
                                </p>
                            <?php endif; ?>

                            <?php if (!empty($hra['zaner'])): ?>
                                <span class="badge badge-genre mb-2">
                                    <?= htmlspecialchars($hra['zaner']) ?>
                                </span>
                            <?php endif; ?>

                            <?php if (!empty($hra['dlzka'])): ?>
                                <p class="mb-2"><small>Dĺžka: <?= (int)$hra['dlzka'] ?> min</small></p>
                            <?php endif; ?>

                            <?php if (!empty($hra['popis'])): ?>
                                <p class="card-text small flex-grow-1">
                                    <?= htmlspecialchars($hra['popis']) ?>
                                </p>
                            <?php endif; ?>

                            <div class="mt-3 d-flex justify-content-between">
                                <a href="edit_hra.php?id=<?= (int)$hra['id_hry'] ?>" class="btn btn-sm btn-outline-secondary">
                                    Upraviť
                                </a>
                                <a href="delete_hra.php?id=<?= (int)$hra['id_hry'] ?>"
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Naozaj chceš zmazať túto hru?');">
                                    Zmazať
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<footer class="py-3 mt-5">
    <div class="container text-center">
        <small>© Repertoár divadla – semestrálny projekt</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
