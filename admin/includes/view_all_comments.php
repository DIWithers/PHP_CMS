<table class="table table-bordered table-hover">
                          <thead>
                              <tr>
                                  <th>Id</th>
                                  <th>Author</th>
                                  <th>Comment</th>
                                  <th>Email</th>
                                  <th>Status</th>
                                  <th>In Response To</th>
                                  <th>Date</th>
                                  <th>Approve</th>
                                  <th>Unapprove</th>
                                  <th>Delete</th>
                              </tr>
                          </thead>
                            <tbody>
                                <?php
                                    global $connection;
                                    $query = "SELECT * FROM comments";
                                    $select_comments = mysqli_query($connection, $query);

                                    while($row = mysqli_fetch_assoc($select_comments)) {
                                        $comment_id = $row['comment_id'];
                                        $comment_post_id = $row['comment_post_id'];
                                        $comment_author = $row['comment_author'];
                                        $comment_email = $row['comment_email'];
                                        $comment_content = $row['comment_content'];
                                        $comment_status = $row['comment_status'];
                                        $comment_date = $row['comment_date'];

                                        echo " <tr>
                                                    <td>{$comment_id}</td>
                                                    <td>{$comment_author}</td>
                                                    <td>{$comment_content}</td> ";

                                            //         $query = "SELECT * FROM categories WHERE cat_id = $post_category_id ";
                                            //         $select_categories_id = mysqli_query($connection, $query);
                                            //         $num_categories = mysqli_num_rows($select_categories_id);

                                            //         if ($num_categories > 0) {
                                            //         while($row = mysqli_fetch_assoc($select_categories_id)) {
                                                        
                                            //                 $cat_id = $row['cat_id'];
                                            //                 $cat_title = $row['cat_title'];
                                            //             } 
                                            //         }
                                            //         else {
                                            //             $cat_title = "None";
                                            //         }
                                            //   echo "<td>{$cat_title}</td>";
                                        echo "
                                                    <td>{$comment_email}</td>
                                                    <td>{$comment_status}</td>
                                                    <td>{$comment_post_id}</td>
                                                    <td>{$comment_date}</td>
                                                    <td><a href='comments.php?source='>Approve</a></td>
                                                    <td><a href='comments.php?source='>Unapprove</a></td>
                                                    <td><a href='comments.php?delete={$post_id}'>Delete</a></td>
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