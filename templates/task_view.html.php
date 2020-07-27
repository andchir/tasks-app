<?php
/** @var array $config */
/** @var array $data */
/** @var App\Entity\Task $data['item'] */
?>
<?php include 'head.html.php'; ?>

<main role="main">

    <div class="py-5 bg-light">
        <div class="container">

            <div class="mb-3">
                <a href="<?= $config['basePath'] ?>">Home page</a>
            </div>

            <?php if($data['item'] && $data['item']->getStatus() == 'finished'): ?>
                <div class="float-right">
                    <span class="badge badge-success">Finished</span>
                </div>
            <?php endif; ?>
            <h1>Task #<?= $data['itemId'] ?></h1>

            <?php if (!empty($data['message'])): ?>
                <div class="alert alert-<?= $data['messageType'] ?>"><?= $data['message'] ?></div>
            <?php endif; ?>

            <?php if (!empty($data['item'])): ?>

                <?php if(\App\Controller\BaseController::getUser()): ?>
                    <div class="float-right ml-3">
                        <a class="btn btn-sm btn-outline-secondary" href="<?= $config['basePath'] ?>tasks/edit/<?= $data['item']->getId() ?>">Edit</a>
                    </div>
                <?php endif; ?>
                <p>
                    Author:
                    <b><?= $data['item']->getUsername() ?></b>
                    <span class="text-muted">(<?= $data['item']->getEmail() ?>)</span>
                </p>
                <?php if($data['item']->getEditedBy()): ?>
                    <p class="text-muted">Edited by <b><?= $data['item']->getEditedBy() ?></b>.</p>
                <?php endif; ?>
                <p>
                    <?= $data['item']->getDescription() ?>
                </p>

            <?php endif; ?>

        </div>
    </div>

</main>

</body>
</html>
