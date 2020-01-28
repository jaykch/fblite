<section id="login-form" class="container">
    <br>
    <form action="./login/login.php" method="post">
        <div class="form-row">
            <?php
            if (isset($_GET['error'])) {
                if ($_GET['error'] == "loginFailed") {
                    echo "<div class=\"col-md-12\"><p class=\"text-danger\">Incorrect username or password!</p></div>";
                }
            }
            ?>
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Username" name="username" required><br>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</section>