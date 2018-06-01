<?php
    global $connection;
    if(isset($_POST['create_post'])) {
        $post_title = $_POST['title'];
        $post_author = $_POST['author'];
        $post_category_id = $_POST['post_category'];
        $post_status = $_POST['post_status'];
 
        $post_image = $_FILES['post_image']['name'];
        $post_image_temp = $_FILES['post_image']['tmp_name'];

        $post_tags = $_POST['post_tags'];
        $post_content = $_POST['post_content'];
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

    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input type="text" class="form-control" name="user_firstname" required>
    </div>
    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>
    <div class="form-group">
        <label for="user_role">Role</label>
        <div>
            <select name="user_role" id="user_role">
                <?php
                        $query = "SELECT * FROM roles";
                        $select_role = mysqli_query($connection, $query);
                        confirmQuery($select_role);
                        while($row = mysqli_fetch_assoc($select_role)) {
                            $role_id = $row['role_id'];
                            $user_role = $row['user_role'];
                            echo "<option value='{$role_id}'>{$user_role}</option>";
                        }
                ?>
            </select>
        </div>
    </div>  
    <div class="form-group">
        <label for="user_image">User Image</label>
        <input type="file" class="form-control" name="user_image">
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_post" value="Add User">
    </div>                   
</form>