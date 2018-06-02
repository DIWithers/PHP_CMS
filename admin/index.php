<!DOCTYPE html>
<html lang="en">
<body>
    <?php include "includes/admin_header.php" ?>
        <div id="wrapper">
            <?php include "includes/admin_navigation.php" ?>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">
                                Admin Portal
                            </h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-file-text fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <?php 
                                            $query = "SELECT * FROM posts";
                                            $select_all_posts = mysqli_query($connection, $query);
                                            $post_count = mysqli_num_rows($select_all_posts);
                                            ?>
                                            <div class='huge'><?php echo $post_count; ?></div>
                                            <div>Posts</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="posts.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-comments fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <?php 
                                                $query = "SELECT * FROM comments";
                                                $select_all_comments = mysqli_query($connection, $query);
                                                $comment_count = mysqli_num_rows($select_all_comments);
                                            ?>
                                            <div class='huge'><?php echo $comment_count; ?></div>
                                            <div>Comments</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="comments.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-yellow">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-user fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <?php 
                                                $query = "SELECT * FROM users";
                                                $select_all_users = mysqli_query($connection, $query);
                                                $user_count = mysqli_num_rows($select_all_users);
                                            ?>
                                            <div class='huge'><?php echo $user_count; ?></div>
                                            <div> Users</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="users.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-red">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-list fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <?php 
                                                $query = "SELECT * FROM categories";
                                                $select_all_categories = mysqli_query($connection, $query);
                                                $category_count = mysqli_num_rows($select_all_categories);
                                            ?>                                        
                                            <div class='huge'><?php echo $category_count; ?></div>
                                            <div>Categories</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="categories.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <?php 
                        $query = "SELECT * FROM posts WHERE post_status = 'draft'";
                        $select_all_draft_posts = mysqli_query($connection, $query);
                        $post_draft_count = mysqli_num_rows($select_all_draft_posts);

                        $query = "SELECT * FROM comments WHERE comment_status = 'unapproved'";
                        $select_all_unapproved_comments = mysqli_query($connection, $query);
                        $comment_unapproved_count = mysqli_num_rows($select_all_unapproved_comments);

                        $query = "SELECT * FROM users WHERE user_role = 'subscriber'";
                        $select_all_subscriber_users = mysqli_query($connection, $query);
                        $user_subscriber_count = mysqli_num_rows($select_all_subscriber_users);                        
                    ?>


                    <div class="row">
                        <script type="text/javascript">
                            google.charts.load('current', {'packages':['bar']});
                            google.charts.setOnLoadCallback(drawChart);

                            function drawChart() {

                                var data = google.visualization.arrayToDataTable([
                                ['Data', 'Total', 'Pending/Non-Admin'],
                                    
                                    <?php 
                                        $element_text = ['Posts', 'Comments', 'Users', 'Categories'];
                                        $element_count = [$post_count, $comment_count, $user_count, $category_count]; //find map equivalent!
                                        $pending_element_count = [$post_draft_count, $comment_unapproved_count, $user_subscriber_count, 0]; //find map equivalent!
                                        
                                        for ($i = 0; $i < count($element_text); $i++) {
                                            $category = $element_text[$i];
                                            $count = $element_count[$i];
                                            $pending_category = $pending_element_text[$i];
                                            $pending_count = $pending_element_count[$i];

                                            echo "['{$category}'" . "," . "{$count}" . "," . "{$pending_count}],";
                                        }
                                    ?>
                                ]);

                                var options = {
                                    chart: {
                                        title: '',
                                        subtitle: '',
                                    }
                                };

                                var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                                chart.draw(data, google.charts.Bar.convertOptions(options));
                            }

                        </script>      
                        <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>                                          
                    </div>

                </div>
            </div>
        </div>
    <?php include "includes/admin_footer.php" ?>
</body>
</html>