<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= $config['basePath'] ?>node_modules/bootstrap/dist/css/bootstrap.min.css">

    <title><?= $config['appName'] ?></title>
</head>
<body>

<header>
    <div class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container d-flex justify-content-between">
            <a href="<?= $config['basePath'] ?>" class="navbar-brand d-flex align-items-center">
                <strong><?= $config['appName'] ?></strong>
            </a>
            <a class="btn btn-primary" href="<?= $config['basePath'] ?>auth">
                Sign in
            </a>
        </div>
    </div>
</header>
