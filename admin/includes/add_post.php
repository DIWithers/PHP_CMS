<?php
    global $connection;
    if(isset($_POST['create_post'])) {
        $post_title = str_replace("'", "''", $_POST['title']) ;
        $post_author = str_replace("'", "''", $_POST['author']);
        $post_category_id = $_POST['post_category'];
        $post_status = $_POST['post_status'];
 
        $post_image = $_FILES['post_image']['name'];
        $post_image_temp = $_FILES['post_image']['tmp_name'];

        $post_tags = str_replace("'", "''", $_POST['post_tags']);
        $post_content = str_replace("'", "''", $_POST['post_content']);
        $post_date = date('d-m-y');

        move_uploaded_file($post_image_temp, "../images/$post_image");
        
        $query = "INSERT INTO posts(
            post_category_id,
            post_title,
            post_author,
            post_date,
            post_image, 
            post_content,
            post_tags,
            post_status)  ";
        $query .= "VALUES( 
            {$post_category_id}, 
            '{$post_title}', 
            '{$post_author}', 
            now(), 
            '{$post_image}', 
            '{$post_content}', 
            '{$post_tags}', 
            '{$post_status}') ";

        $create_post_query = mysqli_query($connection, $query);
        confirmQuery($create_post_query);
        $new_post_id = mysqli_insert_id($connection);
        echo "
        <div class='bg-success text-center'>
            <h3>
                Post Updated Successfully!     
                <a href='../post.php?p_id={$new_post_id}'>
                    <button class='btn btn-success'>View Post</button>
                </a>
            </h3>
        </a>
        </div>
        <div class='buffer'></div>
    ";

    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title" required>
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
                            echo "<option value='{$cat_id}'>{$cat_title}</option>";
                        }
                ?>
            </select>
        </div>
    </div>  
    <div class="form-group">
        <label for="author">Post Author</label>
        <input type="text" class="form-control" name="author">
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
                        $db_post_status = $row['status'];
                        echo "<option value='{$db_post_status}'>{$db_post_status}</option>";
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" class="form-control" name="post_image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea id="editor" cols="30" rows="10" class="form-control" name="post_content"></textarea>
    </div>    
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_post" value="Publish">
    </div>                   
</form>