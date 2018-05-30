<?php include "includes/sources.php"; ?>
<?php include "includes/admin_header.php" ?>
    <div id="wrapper">
        <?php include "includes/admin_navigation.php" ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                      <h1 class="page-header"> Welcome to Admin <small>Posts</small></h1>
                      <?php
                         $sources['add_post'] = "includes/add_post.php";
                         $sources['view_all_posts'] = "includes/view_all_posts.php";
                         $sources['edit_post'] = "includes/edit_post.php";
                    ?>
                     <?php 
                        if(isset($_GET['source'])) {
                            $source = $_GET['source']; 
                            include $sources[$source];
                        }
                        else include "includes/view_all_comments.php";
                     ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include "includes/admin_footer.php" ?>