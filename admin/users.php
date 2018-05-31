<?php include "includes/sources.php"; ?>
<?php include "includes/admin_header.php" ?>
    <div id="wrapper">
        <?php include "includes/admin_navigation.php" ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                      <h1 class="page-header"> Welcome to Admin <small>Users</small></h1>
                      <?php
                         $sources['add_user'] = "includes/add_user.php";
                         $sources['edit_user'] = "includes/edit_user.php";
                    ?>
                     <?php 
                        if(isset($_GET['source'])) {
                            $source = $_GET['source']; 
                            include $sources[$source];
                        }
                        else include "includes/view_all_users.php";
                     ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include "includes/admin_footer.php" ?>