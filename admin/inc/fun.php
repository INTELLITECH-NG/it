<?php 
/// Error Message Echo
function Error_Message() {
	if (isset($_SESSION['ErrorMessage'])) {
		$Output = "<div class='alert alert-danger'>";
		$Output .= htmlentities($_SESSION['ErrorMessage']);
		$Output .= "</div>";
		$_SESSION['ErrorMessage'] = null;
		return $Output;
	}
}

/// Success Meassage Echo
function Success_Message() {
	if (isset($_SESSION['SuccessMessage'])) {
		$Output = "<div class='alert alert-success'>";
		$Output .= htmlentities($_SESSION['SuccessMessage']);
		$Output .= "</div>";
		$_SESSION['SuccessMessage'] = null;
		return $Output;
	}
}
// Redirect Location
function Redirect($New_Location) {
	header("Location:" .$New_Location);
	exit;
}

// Add Category
function Add_category() {
			global $conn ;
			if (isset($_POST['submit'])) {
			$title = $_POST['main_title'];

			// Check if it is Empty
			if ($title == "" || empty($title)) {
			$_SESSION['ErrorMessage'] = "This Felid Should Not Be Empty";
			Redirect("categories");

			// Category Lenght
			}elseif (strlen($title) > 20) {
				$_SESSION['ErrorMessage'] = "This is too Long";
				Redirect("categories");
			}else {
				// Insert into Database
				$query = "INSERT INTO categories(title)";
				$query .= "VALUE('{$title}')" ;

				$create_category = mysqli_query($conn, $query);

			// Check for Error in Database
			if (!$create_category) {
			  die('Am A killer' . mysqli_error($conn));

			// Susscess Massage 
			}elseif ($create_category) {
				$_SESSION['SuccessMessage'] = "Category Added to Database";
				redirect("categories");
			}

		}
	}

}

// Table Function

function Table() {

	global $conn ;
		$query = "SELECT * FROM categories";
		$categories_query = mysqli_query($conn, $query);

		while ($row = mysqli_fetch_assoc($categories_query)) {
		$id = $row['id'];
		$title = $row['title'];

			echo "<tr>";
			echo "<td>$id</td>";
			echo "<td>$title</td>";
			echo "<td><a href='categories.php?edit={$id}'>Edit</a></td>";
			echo "<td><a href='categories.php?del={$id}'>Delete</a></td>";
			echo "</tr>";
		} 

		if (isset($_GET['del'])) {
			$the_id = $_GET['del'];

			$query = "DELETE FROM categories WHERE id = {$the_id}";
			$delete_category = mysqli_query($conn, $query) ;

			$_SESSION['ErrorMessage'] = "Category as Been Deleted";
			Redirect("categories");
		}
		
	}
// Add Post
function AddPost() {
	global $conn;
	if (isset($_POST['publish'])) {
		
		$title = $_POST['post_title'];
		$author = $_POST['Post_author'];
		$category = $_POST['category'];

		$image = $_FILES['Post_image']['name'];
		$image_temp = $_FILES['Post_image']['tmp_name'];
		move_uploaded_file($image_temp, "../upload/$image");

        $tag = $_POST['post_tag'];
        $status = $_POST['post_status'];
        $content = $_POST['post_content'];

        if ($title == "" || empty($title)) {
        	$_SESSION['ErrorMessage'] = "All This Fields Should Not Be Empty";
        	Redirect("addpost");
        }
        else {

        $query = "INSERT INTO post(category, author, date, tags, content, title, status, image) 
        VALUE('$category', '$author', now(), '$tag', '$content', '$title', '$status', '$image')";

        $create_post = mysqli_query($conn, $query);

        if (!$create_post) {
        	die("Am a Killer" . mysqli_error($conn));
        }elseif ($create_post) {
        	$_SESSION['SuccessMessage'] = "Post Added Successfuly";
        	redirect("viewpost");
        }
    }
}

}
// ViewPost
function ViewPost () {
	global $conn;
	$query = "SELECT * FROM categories";
	$categories_query = mysqli_query($conn, $query);

	while ($row = mysqli_fetch_assoc($categories_query)) {
		$id = $row['id'];
		$title = $row['title'];
		
		echo "<option value='$title'>$title</option>";
	}
}

function View_All_Post() {
      // View Post
      global $conn; 
      $query = "SELECT * FROM post";
      $Select_post_query = mysqli_query($conn, $query);

      while ($row = mysqli_fetch_assoc($Select_post_query)) {
      $id = $row['id'];
      $Cat_id = $row['category'];
      $title = $row['title'];
      $author = $row['author'];
      $date = $row['date'];
      $image = $row['image'];
      $content = $row['content'];
      $tags = $row['tags'];
      $comment = $row['comment_count'];
      $status = $row['status'];

      // Post Table

        echo "<tr>";
        echo "<td>$id</td>";
        echo "<td>$author</td>";
        echo "<td>$content</td>";
        echo "<td>$title</td>";
        echo "<td>$Cat_id</td>";
        echo "<td>$status</td>";
        echo "<td><img src='../upload/$image' alt='Post Image' width='125px'></td>";
        echo "<td>$tags</td>";
        echo "<td>$comment</td>";
        echo "<td>$date</td>";
        echo "<td><a href='editpost?edit={$id}'>Edit</a></td>";
        echo "<td><a href='viewpost?del={$id}'>Delete</a></td>";
        echo "</tr>";
    }

      /// Delete Post
          if (isset($_GET['del'])) {
          $the_id = $_GET['del'];

            $query = "DELETE FROM post WHERE id = {$the_id}";
            $delete_category = mysqli_query($conn, $query) ;

            $_SESSION['ErrorMessage'] = "Post as Been Deleted";
            Redirect("viewpost");
        }
    }
 ?>