<?php
require "header.php";
?>

<?php

!isset($_SESSION["isAuthenticated"])? require "./login/index.php" : require "./dashboard.php";

?>

<footer>
    <?php
    // Set session variables
    $_SESSION["user"] = "jaykch";
    $_SESSION["userid"] = "1";
    echo "Session variables are set.";

    // Echo session variables that were set on previous page
    echo "User is " . $_SESSION["user"] . ".<br>";
    echo "Id is " . $_SESSION["userid"] . ".";

    ?>

</footer>
</body>
</html>
