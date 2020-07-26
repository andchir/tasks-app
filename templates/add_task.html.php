<?php
/** @var array $config */
/** @var array $data */
/** @var array $data['items'] */
?>
<?php include 'head.html.php'; ?>

<main role="main">

    <div class="py-5 bg-light">
        <div class="container">

            <div class="row">
                <div class="col-12 col-md-6 offset-md-3">

                    <div class="mb-3">
                        <a href="<?= $config['basePath'] ?>">Home page</a>
                    </div>

                    <h1>Add task</h1>

                    <?php if (!empty($data['message'])): ?>
                        <div class="alert alert-<?= $data['messageType'] ?>"><?= $data['message'] ?></div>
                    <?php endif; ?>

                    <form action="<?= $config['basePath'] ?>tasks/add" method="post">
                        <div class="form-group">
                            <label for="inputUsername">Username</label>
                            <input type="text" id="inputUsername" name="username" class="form-control" value="<?php echo isset($data['requestData']['username']) ? $data['requestData']['username'] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="inputEmail">Email address</label>
                            <input type="email" id="inputEmail" name="email" class="form-control" value="<?php echo isset($data['requestData']['email']) ? $data['requestData']['email'] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="inputDescription">Task description</label>
                            <textarea id="inputDescription" name="description" class="form-control" rows="9"><?php echo isset($data['requestData']['description']) ? $data['requestData']['description'] : ''; ?></textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-lg btn-primary" type="submit">Create</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

</main>

</body>
</html>
