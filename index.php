<?php
require "header.php";
?>

<?php
!isset($_SESSION["isAuthenticated"])? require "./login/index.php" : require "./dashboard.php";
?>

<footer>

</footer>
</body>
</html>
