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

                    <form action="" method="post">
                        <div class="form-group">
                            <label for="inputEmail" class="sr-only">Email address</label>
                            <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="sr-only">Password</label>
                            <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
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
