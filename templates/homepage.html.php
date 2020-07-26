<?php
    /** @var array $data */
    /** @var array $data['items'] */
?>
<?php include 'head.html.php'; ?>

<main role="main">

    <div class="py-5 bg-light">
        <div class="container">

            <h1>Welcome!</h1>

            <div class="row">

                <?php foreach ($data['items'] as $item): ?>
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-outline-secondary" href="<?= $config['basePath'] ?>tasks/view/<?= $item->getId() ?>">View</a>
                                        <a class="btn btn-sm btn-outline-secondary" href="<?= $config['basePath'] ?>tasks/edit/<?= $item->getId() ?>">Edit</a>
                                    </div>
                                    <small class="text-muted">
                                        <?= $item->getUsername() ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>

            </div>

            <nav aria-label="...">
                <ul class="pagination">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>

</main>

</body>
</html>
