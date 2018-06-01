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
        $post_title = $_POST['title'];
        $post_author = $_POST['author'];
        $post_category = $_POST['post_category'];
        $post_status = $_POST['post_status'];
        $post_tags = $_POST['post_tags'];
        $post_content = $_POST['post_content'];
        
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
        header("Location: posts.php");
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
            <select name="user_role" id="user_role">
                <?php
                        $query = "SELECT * FROM users";
                        $select_users = mysqli_query($connection, $query);
                        confirmQuery($select_users);
                        while($row = mysqli_fetch_assoc($select_users)) {
                            $user_id = $row['user_id'];
                            $user_role = $row['user_role'];
                            echo "<option value='{$user_id}'>{$user_role}</option>";
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
        <label for="post_status">Post Staus</label>
        <input value="<?php echo $post_status; ?>" type="text" class="form-control" name="post_status">
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <img src="../images/<?php echo $post_image; ?>" width="100" alt="post image">
        <input type="file" class="form-control" name="post_image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea id="" cols="30" rows="10" class="form-control" name="post_content" required><?php echo $post_content; ?></textarea>
    </div>    
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="UPDATE">
    </div>                   
</form>