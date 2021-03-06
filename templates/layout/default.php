<?php
/** @var \Core\Template\TemplateRenderer $this */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $this->data['title'] ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { padding-top: 70px; }
        .app { display: flex; min-height: 100vh; flex-direction: column; }
        .content { flex: 1; }
        .footer { padding-bottom: 1em; }
    </style>

</head>
<body class="app">

<header class="header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="content">
    <main class="container">
        <?= $this->data['content'] ?>
    </main>
</div>

<footer class="footer">
    <div class="container">
        <hr>
        <p> areyounormis, 2021 </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>