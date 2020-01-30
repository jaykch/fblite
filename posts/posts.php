<?php
require './utils/authentication.php';
require './utils/queries.php';

$conn = login_system();
$posts = fetch_posts($conn);

foreach ($posts as $post) {
    echo "<div class='post'>
                <p class=\"d-block\">$post[3]</p>
                <br>
          </div>";
}
