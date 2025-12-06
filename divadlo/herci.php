<?php
require_once __DIR__ . '/includes/db.php';


$stmt = $pdo->query("SELECT * FROM herci ORDER BY priezvisko, meno");
$herci = $stmt->fetchAll();
?>
<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Herci – repertoár divadla</title>
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
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Hry</a></li>
                <li class="nav-item"><a class="nav-link active" href="herci.php">Herci</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 mb-0">Herci</h1>
        <a href="add_herec.php" class="btn btn-outline-warning">Pridať herca</a>
    </div>

    <?php if (count($herci) === 0): ?>
        <div class="alert alert-info">
            Zatiaľ nie sú v databáze žiadni herci.
        </div>
    <?php else: ?>
        <div class="table-responsive bg-white shadow-sm rounded-3">
            <table class="table mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Meno</th>
                        <th>Dátum narodenia</th>
                        <th>Bio</th>
                        <th style="width: 150px;">Akcie</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($herci as $herec): ?>
                    <tr>
                        <td><?= htmlspecialchars($herec['meno'] . ' ' . $herec['priezvisko']) ?></td>
                        <td>
                            <?php if (!empty($herec['datum_narodenia'])): ?>
                                <?= htmlspecialchars($herec['datum_narodenia']) ?>
                            <?php else: ?>
                                <span class="text-muted">neuvedené</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($herec['bio'])): ?>
                                <span class="text-muted small">
                                    <?= nl2br(htmlspecialchars($herec['bio'])) ?>
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit_herec.php?id=<?= (int)$herec['id_herec'] ?>" class="btn btn-sm btn-outline-secondary">Upraviť</a>
                            <a href="delete_herec.php?id=<?= (int)$herec['id_herec'] ?>"
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Naozaj chceš zmazať tohto herca?');">
                                Zmazať
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
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
