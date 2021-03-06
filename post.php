<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>
<?php include "includes/db.php"; ?>


      <div class="container">
        <div class="row">
            <div class="col-md-8">

                 <?php 
                if (isset($_GET['p_id'])){
                    $post_id = $_GET['p_id'];

                    $views_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = $post_id";
                    $update_views_query = mysqli_query($connection, $views_query);
                    if (!$update_views_query) die("QUERY FAILED: " . mysqli_error($connection)); 

                    $query = "SELECT * FROM posts WHERE post_id = $post_id";
                    $select_all_posts_query = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                 ?>

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>
                <h2>
                    <a href="#"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                by <a href="author_posts.php?author=<?php echo $post_author ?>&p_id=<?php echo $post_id ?>"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="blog image">
                <hr>
                <p><?php echo $post_content ?></p>
                 <hr>                        
                   <?php 
                    }
                }
                else {
                    header("Location: index.php");
                } ?>

                <?php 
                    if (isset($_POST['create_comment'])) {
                        $post_id = $_GET['p_id'];
                        $comment_author = mysqli_real_escape_string($connection,$_POST['comment_author']);
                        $comment_email = mysqli_real_escape_string($connection,$_POST['comment_author_email']);
                        $comment_content = mysqli_real_escape_string($connection,$_POST['comment_content']);
                        $comment_status = "unapproved";

                        $query = "INSERT INTO comments (
                            comment_post_id,
                            comment_author,
                            comment_email,
                            comment_content,
                            comment_status, 
                            comment_date)";
                        $query .= "VALUES ( 
                            {$post_id}, 
                            '{$comment_author}', 
                            '{$comment_email}', 
                            '{$comment_content}', 
                            'unapproved', 
                            now()) ";

                        $create_comment_query =  mysqli_query($connection, $query);
                        if (!$create_comment_query) {
                            die("QUERY FAILED: " . mysqli_error($connection));
                        }
                        
                        $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
                        $query .= "WHERE post_id = $post_id";
                        $update_comment_count = mysqli_query($connection, $query);
                    }
                 ?>

                <div class="well">
                    <form action="" method="post" role="form">
                        <div class="form-group">
                            <label for="comment_author">Author</label>
                            <input type="text" name="comment_author" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="comment_email">Email</label>
                            <input type="email" name="comment_author_email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="comment_email">Comment</label>
                            <textarea name="comment_content" class="form-control" rows="3" required></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Leave Comment</button>
                    </form>
                </div>

                <hr>

                <?php 
                    $query = "SELECT * FROM comments WHERE comment_post_id = {$post_id} ";
                    $query .= "AND comment_status = 'approved' ";
                    $query .= "ORDER BY comment_id DESC ";
                    $select_comment_query = mysqli_query($connection, $query);
                    if (!$select_comment_query) die ('QUERY FAILED: ' . mysqli_error($connection));
                    while ($row = mysqli_fetch_assoc($select_comment_query)) {
                        $comment_date =  $row['comment_date'];
                        $comment_content = $row['comment_content'];
                        $comment_author = $row['comment_author'];
                ?>

                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                </div>

                <?php } ?>

            </div>
            <?php include "includes/sidebar.php"; ?>
        </div>
    </div>
    <hr>
    <?php include "includes/footer.php"; ?>

