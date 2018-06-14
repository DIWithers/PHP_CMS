<?php
    function confirmQuery($result) {
        global $connection;
        if (!$result) die("QUERY FAILED: " . mysqli_error($connection)); 
    } 

    function addCategoryIfSubmitted() {
        global $connection;
        if (isset($_POST['submit'])) {
            $cat_title = $_POST['cat_title'];
            if ($cat_title == "" || empty($cat_title)) echo "<h5 class='text-danger'>Cannot add a blank category</h5>";
            else {
                $query = "INSERT INTO categories(cat_title) ";
                $query .= "VALUE('{$cat_title}') ";
                $create_category_query =  mysqli_query($connection, $query);
                confirmQuery($create_category_query);
            }
        }
    }

    function openEditFormIfClicked() {
        if (isset($_GET['edit'])) {
            $cat_id = $_GET['edit'];
            include "includes/update_categories.php";
        }
    }

    function deleteCategoryIfClicked() {
        global $connection;
        if (isset($_GET['delete'])) {
            $cat_id_to_delete = $_GET['delete'];
            $query = "DELETE FROM categories WHERE cat_id = {$cat_id_to_delete}";
            $delete_query = mysqli_query($connection, $query);
            header("Location: categories.php");
        }
    }

    function listAllCategories() {
        global $connection;
        $query = "SELECT * FROM categories";
        $select_categories = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_categories)) {
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];
            echo "
                <tr>
                <td>{$cat_id}</td>
                <td>{$cat_title}</td>
                <td><a href='categories.php?delete={$cat_id}'>Delete</a></td>
                <td><a href='categories.php?edit={$cat_id}'>Edit</a></td>
                </tr>
            ";
        } 
    }

    function deletePost($post_id_to_delete) {
        global $connection;
        $query = "DELETE FROM posts WHERE post_id =" . mysqli_real_escape_string($connection, $post_id_to_delete) . " ";
        $deletion_query = mysqli_query($connection, $query);
        header("Location: posts.php");
        $confirmQuery($deletion_query);
    }

    function resetPostCount($post_id_to_update) {
        global $connection;
        $query = "UPDATE posts SET post_views_count = 0 WHERE post_id =" . mysqli_real_escape_string($connection, $post_id_to_update) . " ";
        $reset_query = mysqli_query($connection, $query);
        header("Location: posts.php");
        // $confirmQuery($reset_query);
    }

    function clonePost($post_id_to_clone) {
        global $connection;
        $query = "SELECT * FROM posts";
        $select_posts = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_posts)) {
            $post_id = $row['post_id'];
            $post_author = $row['post_author'];
            $post_title = $row['post_title'];
            $post_category_id = $row['post_category_id'];
            $post_status = $row['post_status'];
            $post_image = $row['post_image'];
            $post_tags = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];
            $post_date = $row['post_date'];  
        }
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
                    Post Cloned Successfully!     
                </h3>
            </a>
            </div>
            <div class='buffer'></div>
        ";
    }

    function updatePostStatus($option, $post_id) {
        global $connection;
        $query = "UPDATE posts SET post_status = '{$option}' WHERE post_id = '{$post_id}'";
        $update_post_query = mysqli_query($connection, $query);
        confirmQuery($update_post_query);
    }

    function generateRandomSalt() {
        $salt_characters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0']; //0-35
        $randSalt = "$2y$10$";
        for ($i = 0; $i < 22; $i++) {
            $randSalt .= $salt_characters[rand(0, count($salt_characters))];
        }
        return $randSalt;
    }
?>