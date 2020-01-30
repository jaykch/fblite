<div class="col-md-6">
    <h2>Posts</h2>
    <br>
    <form action="./posts/create.php" method="post">
                <textarea name="body" rows="3" class="form-control d-block" required
                          style="width: 100%" placeholder="Enter text here..."></textarea>
        <br>
        <button type="submit" class="btn btn-primary">Create post</button>
    </form>
    <br>
    <?php
    require ("./posts/posts.php")
    ?>
</div>