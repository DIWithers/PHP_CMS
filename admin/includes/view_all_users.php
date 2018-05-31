<table class="table table-bordered table-hover">
                          <thead>
                              <tr>
                                  <th>Id</th>
                                  <th>Username</th>
                                  <th>Firstname</th>
                                  <th>Lastname</th>
                                  <th>Email</th>
                                  <th>Role</th>
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
                                                    <td>{$user_name}</td>
                                                    <td>{$user_firstname}</td>
                                                    <td>{$user_lastname}</td>
                                                    <td>{$user_email}</td>
                                                    <td>{$user_role}</td>
                                                </tr>
                                             ";
                                    }
                                ?>   
                            </tbody>
                      </table>
<?php

    if (isset($_GET['approve'])) {
        $comment_id_to_update = $_GET['approve'];
        $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$comment_id_to_update} ";
        $unapprove_query = mysqli_query($connection, $query);
        header("Location: comments.php");
    }
    if (isset($_GET['unapprove'])) {
        $comment_id_to_update = $_GET['unapprove'];
        $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$comment_id_to_update} ";
        $unapprove_query = mysqli_query($connection, $query);
        header("Location: comments.php");
    }

    if (isset($_GET['delete'])) {
        $comment_id_to_delete = $_GET['delete'];
        $query = "DELETE FROM comments WHERE comment_id = {$comment_id_to_delete} ";
        $deletion_query = mysqli_query($connection, $query);
        header("Location: comments.php");
    }
?>                      