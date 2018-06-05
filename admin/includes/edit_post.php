<?php 
    if(isset($_GET['p_id'])) {
        $post_id_to_edit = $_GET['p_id'];

        $query = "SELECT * FROM posts WHERE post_id = $post_id_to_edit";
        $select_posts_by_id = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_posts_by_id)) {
            $post_id = $row['post_id'];
            $post_author = $row['post_author'];
            $post_title = $row['post_title'];
            $post_cat = $row['post_category_id'];
            $post_status = $row['post_status'];
            $post_image = $row['post_image'];
            $post_content = $row['post_content'];
            $post_tags = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];
            $post_date = $row['post_date'];  
        }
    }
    if(isset($_POST['update_post'])) {
        $post_title = str_replace("'", "''", $_POST['title']);
        $post_author = str_replace("'", "''", $_POST['author']);
        $post_category = $_POST['post_category'];
        $post_status = $_POST['post_status'];
        $post_tags = str_replace("'", "''", $_POST['post_tags']);
        $post_content = str_replace("'", "''", $_POST['post_content']);
        
        if (!empty($_FILES['post_image']['name']) || is_uploaded_file($_FILES['post_image']['tmp_name'])) {
            $post_image = $_FILES['post_image']['name'];
            $post_image_temp = $_FILES['post_image']['tmp_name'];
    
            move_uploaded_file($post_image_temp, "../images/$post_image");
        }
        
        $query = "UPDATE posts SET 
            post_category_id = '{$post_category}', 
            post_title = '{$post_title}', 
            post_author = '{$post_author}', 
            post_date = now(), 
            post_image = '{$post_image}', 
            post_content = '{$post_content}', 
            post_tags = '{$post_tags}', 
            post_status = '{$post_status}' 
            WHERE post_id = {$post_id_to_edit}";

        $update_post_query = mysqli_query($connection, $query);
        confirmQuery($update_post_query);
        echo "
            <div class='text-center'>
                <h3>
                    Post Updated Successfully!     
                    <a href='../post.php?p_id={$post_id}'>
                        <button class='btn btn-success'>View Post</button>
                    </a>
                    or
                    <a href='posts.php'>
                        <button class='btn btn-success'>Edit More Posts</button>
                    </a>
                </h3>
            </div>
        ";
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input value="<?php echo $post_title ?>"  type="text" class="form-control" name="title" required>
    </div>
    <div class="form-group">
        <label for="post_category_id">Post Category Id</label>
        <div>
            <select name="post_category" id="post_category">
                <?php
                        $query = "SELECT * FROM categories";
                        $select_categories = mysqli_query($connection, $query);
                        confirmQuery($select_categories);
                        while($row = mysqli_fetch_assoc($select_categories)) {
                            $cat_id = $row['cat_id'];
                            $cat_title = $row['cat_title'];
                            if ($post_cat === $cat_id) echo "<option value='{$cat_id}' selected>{$cat_title}</option>";
                            else echo "<option value='{$cat_id}'>{$cat_title}</option>";
                        }
                ?>
            </select>
        </div>
    </div> 
    <div class="form-group">
        <label for="author">Post Author</label>
        <input value="<?php echo $post_author; ?>" type="text" class="form-control" name="author">
    </div>

    <div class="form-group">
        <label for "post_status">Post status</label>
        <div>
            <select name="post_status" id="post_status">
                <?php
                    $query = "SELECT * FROM post_status";
                    $select_post_status = mysqli_query($connection, $query);
                    confirmQuery($select_post_status);
                    while($row = mysqli_fetch_assoc($select_post_status)) {
                        $status_id = $row['post_status_id'];
                        $db_post_status = $row['status'];
                        if ($post_status === $db_post_status) echo "<option value='{$db_post_status}' selected>{$db_post_status}</option>";
                        else echo "<option value='{$db_post_status}'>{$db_post_status}</option>";
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group buffer">
        <label for="post_image">Post Image</label>
        <img src="../images/<?php echo $post_image; ?>" width="100" alt="post image">
        <div class="buffer">
            <input type="file" class="form-control" name="post_image">
        </div>
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea id="edit_post_editor" style="display: none" cols="30" rows="10" class="form-control" name="post_content" required><?php echo $post_content; ?></textarea>
    </div>    
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="UPDATE">
    </div>                   
</form>