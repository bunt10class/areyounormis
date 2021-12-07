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
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
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