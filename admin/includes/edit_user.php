<?php
    global $connection;

    if (isset($_GET['u_id'])) {
       $user_id_to_edit = $_GET['u_id'];

       $query = "SELECT * FROM users WHERE user_id = $user_id_to_edit";
       $select_user_by_id = mysqli_query($connection, $query);
       while($row = mysqli_fetch_assoc($select_user_by_id)) {
           $user_id = $row['user_id'];
           $username = $row['username'];
           $user_password = $row['user_password'];
           $user_firstname = $row['user_firstname'];
           $user_lastname = $row['user_lastname'];
           $user_email = $row['user_email'];
           $user_image = $row['user_image'];
           $user_role = $row['user_role'];
       }
    }


    if(isset($_POST['edit_user'])) {
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_role = $_POST['selected_role'];
        $username = $_POST['username'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];

        if (!empty($_FILES['user_image']['name']) || is_uploaded_file($_FILES['user_image']['tmp_name'])) {
            $user_image = $_FILES['user_image']['name'];
            $user_image_temp = $_FILES['user_image']['tmp_name'];
    
            move_uploaded_file($user_image_temp, "../images/$user_image");
        }
        
        $query = "UPDATE users SET 
            username = '{$username}',
            user_password = '{$user_password}',
            user_firstname = '{$user_firstname}',
            user_lastname = '{$user_lastname}',
            user_email = '{$user_email}', 
            user_image = '{$user_image}', 
            user_role = '{$user_role}'
            WHERE user_id = $user_id_to_edit";

        $update_user_query = mysqli_query($connection, $query);
        confirmQuery($update_user_query);
        header("Location: users.php");
        

    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input value="<?php echo $user_firstname; ?>" type="text" class="form-control" name="user_firstname" required>
    </div>
    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input value="<?php echo $user_lastname; ?>" type="text" class="form-control" name="user_lastname">
    </div>
    <div class="form-group">
        <label for="user_role">Role</label>
        <div>
            <select name="selected_role" id="user_role">
                <option value='subscriber'>Select Role</option>
                <?php
                        $query = "SELECT * FROM roles";
                        $select_role = mysqli_query($connection, $query);
                        confirmQuery($select_role);
                        while($row = mysqli_fetch_assoc($select_role)) {
                            $role_id = $row['role_id'];
                            $dropdown_role = $row['user_role'];
                            if ($user_role === $dropdown_role) echo "<option value='{$dropdown_role}' selected>{$dropdown_role}</option>";
                            else echo "<option value='{$dropdown_role}'>{$dropdown_role}</option>";
                        }
                ?>
            </select>
        </div>
    </div>  
    <div class="form-group">
        <label for="user_image">User Image</label>
        <input value="<?php echo $user_image; ?>" type="file" class="form-control" name="user_image">
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input value="<?php echo $username; ?>" type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input value="<?php echo $user_email; ?>" type="email" class="form-control" name="user_email">
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" value="<?php echo $user_password; ?>" class="form-control" name="user_password">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="edit_user" value="Update User">
    </div>                   
</form>