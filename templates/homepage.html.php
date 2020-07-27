<?php
/** @var array $config */
/** @var array $data */
/** @var (App\Entity\Task)[] $data['items'] */
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

                    <?php foreach ($data['items'] as $item): ?>
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">

                                <?php if($item->getStatus() == 'finished'): ?>
                                    <div class="float-right">
                                        <span class="badge badge-success">Finished</span>
                                    </div>
                                <?php endif; ?>
                                <h4>
                                    <a name="task<?= $item->getId() ?>" href="#task<?= $item->getId() ?>">
                                        Task #<?= $item->getId() ?>
                                    </a>
                                </h4>

                                <?php if(\App\Controller\BaseController::getUser()): ?>
                                    <div class="float-right ml-3">
                                        <div class="btn-group">
                                            <a class="btn btn-sm btn-outline-secondary" href="<?= $config['basePath'] ?>tasks/edit/<?= $item->getId() ?>">Edit</a>
                                            <a class="btn btn-sm btn-outline-danger" href="#" onclick="confirmAction('<?= $config['basePath'] ?>tasks/delete/<?= $item->getId() ?>'); return false;">Delete</a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <p>
                                    Author:
                                    <b><?= $item->getUsername() ?></b>
                                    <span class="text-muted">(<?= $item->getEmail() ?>)</span>
                                </p>
                                <?php if($item->getEditedBy()): ?>
                                    <p class="text-muted">Edited by <b><?= $item->getEditedBy() ?></b>.</p>
                                <?php endif; ?>
                                <div>
                                    <?= $item->getDescription() ?>
                                </div>

                            </div>
                        </div>
                    <?php endforeach;?>

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

    function confirmAction(href) {
        if (confirm('Are you sure you want to delete this task?')) {
            window.location.href = href;
        }
    }
</script>

</body>
</html>
