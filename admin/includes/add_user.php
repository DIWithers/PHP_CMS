<?php
    global $connection;
    if(isset($_POST['create_user'])) {
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_role = $_POST['user_role'];
        $username = $_POST['username'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST[''];

        if (!empty($_FILES['user_image']['name']) || is_uploaded_file($_FILES['user_image']['tmp_name'])) {
            $user_image = $_FILES['user_image']['name'];
            $user_image_temp = $_FILES['user_image']['tmp_name'];
    
            move_uploaded_file($user_image_temp, "../images/$user_image");
        }
        else {
            $user_image = 'badge.png';
        }
        
        $query = "INSERT INTO users(
            username,
            user_password,
            user_firstname,
            user_lastname, 
            user_email,
            user_image,
            role
            ) ";
        $query .= "VALUES( 
            '{$username}', 
            '{$user_password}', 
            '{$user_firstname}', 
            '{$user_lastname}', 
            '{$user_email}', 
            '{$user_image}', 
            '{$user_role}' 
            )";

        $create_user_query = mysqli_query($connection, $query);
        confirmQuery($create_user_query);

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
                <option value='subscriber'>Select Role</option>
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
        <input type="submit" class="btn btn-primary" name="create_user" value="Add User">
    </div>                   
</form>