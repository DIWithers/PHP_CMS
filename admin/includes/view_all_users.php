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
                                  <th>Edit</th>
                                  <th>Set As Sub</th>
                                  <th>Set As Admin</th>
                                  <th>Delete</th>
                              </tr>
                          </thead>
                            <tbody>
                                <?php
                                    global $connection;
                                    $query = "SELECT * FROM users";
                                    $select_users = mysqli_query($connection, $query);

                                    while($row = mysqli_fetch_assoc($select_users)) {
                                        $user_id = $row['user_id'];
                                        $username = $row['username'];
                                        $user_firstname = $row['user_firstname'];
                                        $user_lastname = $row['user_lastname'];
                                        $user_email = $row['user_email'];
                                        $user_image = $row['user_image'];
                                        $user_role = $row['user_role'];
                                        $user_password = $row['user_password'];

                                        echo " <tr>
                                                    <td>{$user_id}</td>
                                                    <td><img class='post-thumbnail' src='../images/{$user_image}' alt='user image'></td>
                                                    <td>{$username}</td>
                                                    <td>{$user_firstname}</td>
                                                    <td>{$user_lastname}</td>
                                                    <td>{$user_email}</td>
                                                    <td>{$user_role}</td>
                                                    <td><a href='users.php?source=edit_user&u_id={$user_id}'>Edit</a></td>
                                                    <td><a href='users.php?subscriber=$user_id'>Subscriber</a></td>
                                                    <td><a href='users.php?admin=$user_id'>Admin</a></td>
                                                    <td><a href='users.php?delete={$user_id}'>Delete</a></td>
                                                </tr>
                                             ";
                                    }
                                ?>   
                            </tbody>
                      </table>
<?php

    if (isset($_GET['subscriber'])) {
        $user_id_to_update = $_GET['subscriber'];
        $query = "UPDATE users SET user_role = 'Subscriber' WHERE user_id = {$user_id_to_update} ";
        $unapprove_query = mysqli_query($connection, $query);
        header("Location: users.php");
    }
    if (isset($_GET['admin'])) {
        $user_id_to_update = $_GET['admin'];
        $query = "UPDATE users SET user_role = 'Admin' WHERE user_id = {$user_id_to_update} ";
        $unapprove_query = mysqli_query($connection, $query);
        header("Location: users.php");
    }

    if (isset($_GET['delete'])) {
        $user_id_to_delete = $_GET['delete'];
        $query = "DELETE FROM users WHERE user_id = {$user_id_to_delete} ";
        $deletion_query = mysqli_query($connection, $query);
        header("Location: users.php");
    }
?>                      