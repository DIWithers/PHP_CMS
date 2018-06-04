<?php 
    if (isset($_POST['check_box_array'])) {
        foreach($_POST['check_box_array'] as $post_value_id) {
            $bulk_options = $_POST['bulk_options'];

            $queryAction['published'] = updatePostStatus($bulk_options, $post_value_id);
            $queryAction['draft'] = updatePostStatus($bulk_options, $post_value_id);
            
        }
    }
?>

<form action="" method="post">
    <table class="table table-bordered table-hover">
        <div id="bulkOptionContainer" class="col-xs-4">
            <select name="bulk_options" id="bulkOptions" class="form-control">
                <option value="">Select Options</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
            </select>
        </div>
        <div class="col-xs-4 post-options">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
        </div>


        <thead>
            <tr>
                <th>
                    <input id="selectAllBoxes" type="checkbox">
                </th>
                <th>Id</th>
                <th>Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
                global $connection;
                $query = "SELECT * FROM posts";
                $select_posts = mysqli_query($connection, $query);
                while($row = mysqli_fetch_assoc($select_posts)) {
                    $post_id = $row['post_id'];
                    $post_author = $row['post_author'];
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_comment_count = $row['post_comment_count'];
                    $post_date = $row['post_date'];  
                
                    echo "
                        <tr>
                            <td>
                                <input class='checkboxes' type='checkbox' name='check_box_array[]' value='{$post_id}'>
                                </input>
                            </td>
                            <td>{$post_id}</td>
                            <td>{$post_author}</td>
                            <td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td> ";

                            $query = "SELECT * FROM categories WHERE cat_id = $post_category_id ";
                            $select_categories_id = mysqli_query($connection, $query);
                            $num_categories = mysqli_num_rows($select_categories_id);

                            if ($num_categories > 0) {
                                while($row = mysqli_fetch_assoc($select_categories_id)) {
                                    
                                        $cat_id = $row['cat_id'];
                                        $cat_title = $row['cat_title'];
                                    } 
                                }
                            else {
                                $cat_title = "None";
                            }
                    echo "
                            <td>{$cat_title}</td>
                            <td>{$post_status}</td>
                            <td><img class='post-thumbnail' src='../images/{$post_image}' alt='post image'></td>
                            <td>{$post_tags}</td>
                            <td>{$post_comment_count}</td>
                            <td>{$post_date}</td>
                            <td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>
                            <td><a href='posts.php?delete={$post_id}'>Delete</a></td>
                        </tr> ";    
                }
            ?>   
        </tbody>
    </table>
    <?php
        if (isset($_GET['delete'])) {
            $post_id_to_delete = $_GET['delete'];
            $query = "DELETE FROM posts WHERE post_id = {$post_id_to_delete} ";
            $deletion_query = mysqli_query($connection, $query);
            header("Location: posts.php");
        }
    ?>                      
</form>