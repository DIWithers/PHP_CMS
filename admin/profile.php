<?php include "includes/sources.php"; ?>
<?php include "includes/admin_header.php" ?>

<?php 
    $username = $_SESSION['username'];
    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $select_user_profile_query = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($select_user_profile_query)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
        $user_password = $row['user_password'];
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
            WHERE user_id = $user_id";

        $update_user_query = mysqli_query($connection, $query);
        confirmQuery($update_user_query);
        header("Location: profile.php");
    }
?>
    <div id="wrapper">
        <?php include "includes/admin_navigation.php" ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                <div class="col-lg-12">
                    <h1>Profile</h1>
                </div>
                <div class="col-lg-12">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Image</th>
                                <th>Username</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Email</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php echo "
                                <td>{$user_id}</td>
                                <td><img class='post-thumbnail' src='../images/{$user_image}' alt='user image'></td>
                                <td>{$username}</td>
                                <td>{$user_firstname}</td>
                                <td>{$user_lastname}</td>
                                <td>{$user_email}</td>
                                <td>{$user_role}</td>
                                ";
                                ?>
                            </tr>
                        </tbody>
                        </thead>
                        </table>
                </div>
                    <div class="col-lg-12">
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
                                <input type="submit" class="btn btn-primary" name="edit_user" value="Update Profile">
                            </div>                   
                        </form>                       
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include "includes/admin_footer.php" ?>