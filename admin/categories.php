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
                        <div class="col-xs-6">

                            <?php 
                                if (isset($_POST['submit'])) {
                                    $cat_title = $_POST['cat_title'];
                                    if ($cat_title == "" || empty($cat_title)) echo "<h5 class='text-danger'>Cannot add a blank category</h5>";
                                    else {
                                        $query = "INSERT INTO categories(cat_title) ";
                                        $query .= "VALUE('{$cat_title}') ";
                                        $create_category_query =  mysqli_query($connection, $query);
                                        if (!$create_category_query) die("QUERY FAILED: " . mysqli_error($connection));
                                    }
                                }
                            ?>

                            <form action="" method="post">
                                <div class="form-group">
                                <label for="cat_title">Add Category</label>
                                    <input type="text" class="form-control" name="cat_title">
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                                </div>
                            </form>
                        </div>
                        <div class="col-xs-6">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Category Title</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php
                                    $query = "SELECT * FROM categories";
                                    $select_categories = mysqli_query($connection, $query);

                                    while($row = mysqli_fetch_assoc($select_categories)) {
                                        $cat_id = $row['cat_id'];
                                        $cat_title = $row['cat_title'];
                                        
                                        echo "
                                            <tr>
                                            <td>{$cat_id}</td>
                                            <td>{$cat_title}</td>
                                            <td><a href='categories.php?delete={$cat_id}'>Delete</a></td>
                                            </tr>
                                        ";
                                        }                               
                                ?>
                                <?php 
                                if (isset($_GET['delete'])) {
                                    $cat_id_to_delete = $_GET['delete'];
                                $query = "DELETE FROM categories WHERE cat_id = {$cat_id_to_delete}";
                                $delete_query = mysqli_query($connection, $query);
                                header("Location: categories.php");
                                }
                                ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include "includes/admin_footer.php" ?>