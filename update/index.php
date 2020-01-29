<?php
// Start the session
session_start();
?>

<!doctype html>
<html land="en">
<head>
    <title>FB lite</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>

    <link rel="stylesheet" media="all" href="../layout.css"/>

</head>

<body>

<header>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item ml-auto">
                    <form action='../login/logout.php'>
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                    </li>
                </ul>
            </div>

        </nav>
    </div>
</header>


<section id="update-form" class="container">
    <div class="row">
        <div class="col-md-12">
            <br>
            <h1>Update your profile here!</h1>
            <form action="./update.php" method="post">
                <br>
                <div class="form-row">
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Username" name="username" required value=<?php echo $_SESSION['username']; ?>>
                        <!--                        Check if username error-->
                        <?php
                        if (isset($_GET['error'])) {
                            if ($_GET['error'] == "usernameTaken") {
                                echo "<small class=\"text-danger\">Username already exists!</small>";
                            }
                        }
                        ?>
                        <br>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-4">
                        <input type="text" name="location" class="form-control" placeholder="Location" required value=<?php echo $_SESSION['location']; ?> >
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="relationshipStatus" class="form-control"
                               placeholder="Relationship Status" value=<?php echo $_SESSION['relationshipStatus']; ?> ><br>

                    </div>
                    <div class="col-md-4">
                        <select class="form-control" name="visibilityStatus" required>
                            <option value="1" <?php if($_SESSION['visibilityStatus'] == 1) echo "selected"; ?>>Public</option>
                            <option value="2" <?php if($_SESSION['visibilityStatus'] == 2) echo "selected"; ?>>Friends Only</option>
                            <option value="3" <?php if($_SESSION['visibilityStatus'] == 3) echo "selected"; ?>>Private</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
            <br>
        </div>
    </div>
</section>
</body>
</html>
