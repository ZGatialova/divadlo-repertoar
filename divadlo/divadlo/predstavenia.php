<?php
require_once __DIR__ . '/includes/db.php';


$sql = "SELECT p.*, h.nazov 
        FROM predstavenia p
        JOIN hry h ON p.id_hry = h.id_hry
        ORDER BY p.datum, p.cas";
$stmt = $pdo->query($sql);
$predstavenia = $stmt->fetchAll();
?>
<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Predstavenia – repertoár divadla</title>
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
                <li class="nav-item"><a class="nav-link" href="herci.php">Herci</a></li>
                <li class="nav-item"><a class="nav-link active" href="predstavenia.php">Predstavenia</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 mb-0">Plán predstavení</h1>
        <a href="add_predstavenie.php" class="btn btn-outline-warning">Pridať predstavenie</a>
    </div>

    <?php if (count($predstavenia) === 0): ?>
        <div class="alert alert-info">
            Zatiaľ nie sú v databáze naplánované žiadne predstavenia.
        </div>
    <?php else: ?>
        <div class="table-responsive bg-white shadow-sm rounded-3">
            <table class="table mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Hra</th>
                        <th>Dátum</th>
                        <th>Čas</th>
                        <th>Miesto</th>
                        <th style="width: 150px;">Akcie</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($predstavenia as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['nazov']) ?></td>
                        <td><?= htmlspecialchars($p['datum']) ?></td>
                        <td><?= htmlspecialchars(substr($p['cas'], 0, 5)) ?></td>
                        <td><?= htmlspecialchars($p['miesto'] ?? '') ?></td>
                        <td>
                            <a href="edit_predstavenie.php?id=<?= (int)$p['id_predstavenie'] ?>" class="btn btn-sm btn-outline-secondary">Upraviť</a>
                            <a href="delete_predstavenie.php?id=<?= (int)$p['id_predstavenie'] ?>"
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Naozaj chceš zmazať toto predstavenie?');">
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
