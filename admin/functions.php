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
        $query = "DELETE FROM posts WHERE post_id = {$post_id_to_delete} ";
        $deletion_query = mysqli_query($connection, $query);
        header("Location: posts.php");
        // $confirmQuery($deletion_query);
    }

    function updatePostStatus($option, $post_id) {
        global $connection;
        $query = "UPDATE posts SET post_status = '{$option}' WHERE post_id = '{$post_id}'";
        $update_post_query = mysqli_query($connection, $query);
        confirmQuery($update_post_query);
    }
?>