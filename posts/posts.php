<?php
require './utils/authentication.php';
require './utils/queries.php';

$conn = login_system();
$posts = fetch_posts($conn);

foreach ($posts as $post) {
    $username = fetch_username($conn, $post[2]);
    $comments = fetch_reply($conn, $post[0]);
    $postLikes = count(fetch_likes($conn, $post[0]));
    $hasUserLikedPost = has_user_liked($conn, $post[0]);
    echo "
                <div class='post card'>
                    <div class='card-header'>
                        <h5 class='card-title'>$username :</h5>
                    </div>
                    <div class='card-body'>
                        <p class='card-text'>$post[3]</p>                       
                        <form action='./posts/createReply.php' method='post'>
                        <input type='text' hidden name='parentId' value=$post[0] />
                        <textarea name='body' rows='1' class='form-control d-block' required
                          style='width: 100%' placeholder='Enter text here...'></textarea>
                        <button type='submit' class='btn btn-primary reply'>Reply</button>
                        </form>
                        ";

    foreach ($comments as $comment) {
        $commenter = fetch_username($conn, $comment[2]);
        $replies = fetch_reply($conn, $comment[0]);
        $commentLikes = count(fetch_likes($conn, $comment[0]));
        $hasUserLikedComment = has_user_liked($conn, $comment[0]);
        echo "
                <div class='comment card'>
                    <div class='card-header'>
                        <h5 class='card-title'>$commenter :</h5>
                    </div>
                    <div class='card-body'>
                        <p class='card-text'>$comment[3]</p>
                        <form action='./posts/createReply.php' method='post'>
                        <input type='text' hidden name='parentId' value=$comment[0] />
                        <textarea name='body' rows='1' class='form-control d-block' required
                          style='width: 100%' placeholder='Enter text here...'></textarea>
                        <button type='submit' class='btn btn-primary reply'>Reply</button>
                        </form> 
                        ";
        foreach ($replies as $reply) {
            $replier = fetch_username($conn, $reply[2]);
            $replyLikes = count(fetch_likes($conn, $reply[0]));
            $hasUserLikedReply = has_user_liked($conn, $reply[0]);
            echo "
                <div class='replies card'>
                    <div class='card-header'>
                        <h5 class='card-title'>$replier :</h5>
                    </div>
                    <div class='card-body'>
                        <p class='card-text'>$reply[3]</p> 
                        ";

            echo "  </div>
                    <div class='card-footer'>
                    <form action='./posts/createLike.php' method='post'>
                        <input type='text' hidden name='postId' value=$reply[0] />
                        ";
            if ($hasUserLikedReply) {
                echo "<button type='submit' class='like-button' style='filter: grayscale(100%);' disabled>&#128077;</button>";
            } else {
                echo "<button type='submit' class='like-button'>&#128077;</button>";
            };
            echo "  </form>
                    <span>&nbsp; ($replyLikes) &nbsp;</span>
                    <p class='card-text ml-auto'>$reply[4]</p>
                    </div>
                </div>    
                 <br>            
          ";
        }

        echo "  </div>
                    <div class='card-footer'>
                    <form action='./posts/createLike.php' method='post'>
                        <input type='text' hidden name='postId' value=$comment[0] />
                        ";
        if ($hasUserLikedComment) {
            echo "<button type='submit' class='like-button' style='filter: grayscale(100%);' disabled>&#128077;</button>";
        } else {
            echo "<button type='submit' class='like-button'>&#128077;</button>";
        };
        echo "      </form>
                    <span>&nbsp; ($commentLikes) &nbsp;</span>
                    <p class='card-text ml-auto'>$comment[4]</p>
                    </div>
                </div>    
                 <br>            
          ";
    }

    echo "  </div>
                    <div class='card-footer'>
                    <form action='./posts/createLike.php' method='post'>
                        <input type='text' hidden name='postId' value=$post[0] />
          ";
    if ($hasUserLikedPost) {
        echo "<button type='submit' class='like-button' style='filter: grayscale(100%);' disabled>&#128077;</button>";
    } else {
        echo "<button type='submit' class='like-button'>&#128077;</button>";
    };
    echo "    </form>
                    <span>&nbsp; ($postLikes) &nbsp;</span>
                    <p class='card-text ml-auto'>$post[4]</p>
                    </div>
                </div>    
                 <br>            
          ";
}
