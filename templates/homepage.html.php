<?php
/** @var array $config */
/** @var array $data */
?>
<?php include 'head.html.php'; ?>

<main role="main">

    <div class="py-5 bg-light">
        <div class="container">

            <div class="float-right">
                <a class="btn btn-success" href="<?= $config['basePath'] ?>tasks/add">Add task</a>
            </div>
            <div class="mb-3">
                Order by:&nbsp;
                <select class="custom-select w-auto" onchange="onOrderChange(this)">
                    <option value="username"<?php if($data['orderBy'] == 'username'): ?> selected<?php endif; ?>>Username</option>
                    <option value="email"<?php if($data['orderBy'] == 'email'): ?> selected<?php endif; ?>>Email</option>
                    <option value="status"<?php if($data['orderBy'] == 'status'): ?> selected<?php endif; ?>>Status</option>
                </select>
            </div>

            <?php if(count($data['items']) > 0): ?>

                <div class="row">

                    <?php foreach ($data['items'] as $item): ?>
                        <div class="col-md-4">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-body">
                                    <?php if($item->getStatus() == 'finished'): ?>
                                        <div class="text-right">
                                            <span class="badge badge-success">Finished</span>
                                        </div>
                                    <?php endif; ?>
                                    <p class="card-text">
                                        <?= $item->getDescriptionShort() ?>
                                    </p>
                                    <?php if($item->getEditedBy()): ?>
                                        <p class="text-right text-muted">Edited by <b><?= $item->getEditedBy() ?></b>.</p>
                                    <?php endif; ?>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group mr-2">
                                            <a class="btn btn-sm btn-outline-secondary" href="<?= $config['basePath'] ?>tasks/view/<?= $item->getId() ?>">View</a>
                                            <?php if(\App\Controller\BaseController::getUser()): ?>
                                                <a class="btn btn-sm btn-outline-secondary" href="<?= $config['basePath'] ?>tasks/edit/<?= $item->getId() ?>">Edit</a>
                                            <?php endif; ?>
                                        </div>
                                        <small class="text-muted text-right">
                                            <?= $item->getUsername() ?> (<?= $item->getEmail() ?>)
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>

                </div>

                <?php include 'pagination.html.php'; ?>

            <?php else: ?>

                <div class="alert alert-info">Empty.</div>

            <?php endif; ?>

        </div>
    </div>

</main>

<script>
    function onOrderChange(selectEl) {
        var loc = window.location;
        var currentUrl = loc.protocol + '//';
        currentUrl += loc.hostname + loc.pathname;
        loc.href = currentUrl + '?orderby=' + selectEl.value;
    }
</script>

</body>
</html>
