<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>
<?php ob_start(); ?>
<?php session_start(); ?>


      <div class="container">
        <div class="row">
            <div class="col-md-8">

                 <?php 
                    $query = "SELECT * FROM posts WHERE post_status = 'published'";
                    $select_all_posts_query = mysqli_query($connection, $query);

                    $num_posts = mysqli_num_rows($select_all_posts_query);
                    if ($num_posts == 0) {
                        echo "<h1 class='text-center'>No posts available</h1>";
                    }
                    else {
                        while($row = mysqli_fetch_assoc($select_all_posts_query)) { 
                            $post_id = $row['post_id'];
                            $post_title = $row['post_title'];
                            $post_author = $row['post_author'];
                            $post_date = $row['post_date'];
                            $post_image = $row['post_image'];
                            $post_content = substr($row['post_content'], 0, 120) . "...";
                            $post_status = $row['post_status'];
                     ?>
    
                    <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                    </h1>
                    <h2>
                        <a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="author_posts.php?author=<?php echo $post_author ?>&p_id=<?php echo $post_id ?>"><?php echo $post_author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                    <hr>
                    <a href="post.php?p_id=<?php echo $post_id ?>">
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="blog image">
                    </a>
                    <hr>
                    <p><?php echo $post_content ?></p>
                    <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <?php 
                        if ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'Admin' ) {
                            echo "<a class='btn btn-primary' href='admin/posts.php?source=edit_post&p_id=$post_id'>Edit Post <span class='glyphicon glyphicon-pencil side-buffer'></span></a>";
                        }
                    ?>
                     <hr>                        
                     <?php }
                     } ?>


                <ul class="pager">
                    <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li>
                    <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li>
                </ul>

            </div>
            <?php include "includes/sidebar.php"; ?>
            </div>
        </div>
        <hr>
            <?php include "includes/footer.php"; ?>

