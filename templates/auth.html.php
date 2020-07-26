<?php include 'head.html.php'; ?>

<main role="main">

    <div class="py-5 bg-light">
        <div class="container">

            <div class="row">
                <div class="col-12 col-md-6 offset-md-3">

                    <div class="mb-3">
                        <a href="<?= $config['basePath'] ?>">Home page</a>
                    </div>

                    <h1>Sign in</h1>

                    <?php if (!empty($data['message'])): ?>
                        <div class="alert alert-<?= $data['messageType'] ?>"><?= $data['message'] ?></div>
                    <?php endif; ?>

                    <form action="<?= $config['basePath'] ?>auth" method="post">
                        <div class="form-group">
                            <label for="inputUsername" class="sr-only">Username or email</label>
                            <input type="text" id="inputUsername" name="username" class="form-control" placeholder="Username or email" value="<?php echo isset($data['requestData']['username']) ? $data['requestData']['username'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="sr-only">Password</label>
                            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

</main>

</body>
</html>
