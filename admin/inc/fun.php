<?php
/// Function for session
ob_start();
session_start();

/// Date and Time
function Datetime () {
	global $conn;
	date_default_timezone_set("Africa/Lagos");
	$CurrentTime = time();
	//$Datetime = strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);
	$Datetime = strftime("%B-%d-%Y %h:%M:%S", $CurrentTime);
	$Datetime;
}


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
			$title = mysqli_real_escape_string($conn, $_POST['main_title']);

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

//Categories Table Function

function Table() {

	global $conn ;
		$query = "SELECT * FROM categories";
		$categories_query = mysqli_query($conn, $query);

		while ($row = mysqli_fetch_assoc($categories_query)) {
		$id = $row['id'];
		$title = mysqli_real_escape_string($conn, $row['title']);

			echo "<tr>";
			echo "<td>$id</td>";
			echo "<td>$title</td>";
			echo "<td><a href='categories.php?edit={$id}'>Edit</a></td>";
			echo "<td><a href='categories.php?del={$id}'>Delete</a></td>";
			echo "</tr>";
		} 

		if (isset($_GET['del'])) {
			$the_id = mysqli_real_escape_string($conn, $_GET['del']);

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
		
		$title = mysqli_real_escape_string($conn, $_POST['post_title']);
		$author = mysqli_real_escape_string($conn, $_POST['Post_author']);
		$category = mysqli_real_escape_string($conn, $_POST['category']);

		$image = $_FILES['Post_image']['name'];
		$image_temp = $_FILES['Post_image']['tmp_name'];
		move_uploaded_file($image_temp, "../upload/$image");

        $tag = mysqli_real_escape_string($conn, $_POST['post_tag']);
        $status = mysqli_real_escape_string($conn, $_POST['post_status']);
        /*$comment = 5;*/
        $content = mysqli_real_escape_string($conn, $_POST['post_content']);

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
		$id = mysqli_real_escape_string($conn, $row['id']);
		$title = mysqli_real_escape_string($conn, $row['title']);
		
		echo "<option value='$id'>$title</option>";
	}
}

/// View Post
function View_All_Post() {
      global $conn; 
      $query = "SELECT * FROM post";
      $Select_post_query = mysqli_query($conn, $query);

      while ($row = mysqli_fetch_assoc($Select_post_query)) {
      $id = mysqli_real_escape_string($conn, $row['id']);
      $Cat_id = mysqli_real_escape_string($conn, $row['category']);
      $title = mysqli_real_escape_string($conn, $row['title']);
      $author = mysqli_real_escape_string($conn, $row['author']);
      $date = mysqli_real_escape_string($conn, $row['date']);
      $image = mysqli_real_escape_string($conn, $row['image']);
      $content = mysqli_real_escape_string($conn, $row['content']);
      $tags = mysqli_real_escape_string($conn, $row['tags']);
      $comment = mysqli_real_escape_string($conn, $row['comment_count']);
      $status = mysqli_real_escape_string($conn, $row['status']);

      // Post Table

        echo "<tr>";
        echo "<td>$id</td>";
        echo "<td>$author</td>";
        echo "<td>$content</td>";
        echo "<td>$title</td>";

        /// View Category from post where id
        $query = "SELECT * FROM categories WHERE id = '$Cat_id'";
        $categories_view = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_array($categories_view)) {
        	
        	$cat_id = $row['id'];
        	$cat_title = $row['title'];

        	echo "<td>$cat_title</td>";
	} /// View category Post
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
          $the_id = mysqli_real_escape_string($conn, $_GET['del']);

            $query = "DELETE FROM post WHERE id = {$the_id}";
            $delete_category = mysqli_query($conn, $query) ;

            $_SESSION['ErrorMessage'] = "Post as Been Deleted";
            Redirect("viewpost");
        }
    }
/// View Comment
function View_Comment () {
      global $conn; 
      $query = "SELECT * FROM comment";
      $Select_post_query = mysqli_query($conn, $query);

      while ($row = mysqli_fetch_assoc($Select_post_query)) {
      $id = mysqli_real_escape_string($conn, $row['id']);
      $Post = mysqli_real_escape_string($conn, $row['post']);
      $date = mysqli_real_escape_string($conn, $row['date']);
      $author = mysqli_real_escape_string($conn, $row['author']);
      $email = mysqli_real_escape_string($conn, $row['email']);
      $comment = mysqli_real_escape_string($conn, $row['comment']);;
      $status = mysqli_real_escape_string($conn, $row['status']);

      // Comment Table

        echo "<tr>";
        echo "<td>$id</td>";
        echo "<td>$author</td>";
        echo "<td>$comment</td>";
        echo "<td>$email</td>";
        echo "<td>$status</td>";

        $query = "SELECT * FROM post WHERE id = '$Post'";
        $select_post_id = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($select_post_id)) {
        	$post_id = $row['id'];
        	$post_title = $row['title'];

        	echo "<td><a href='../Post?post=$post_id'>$post_title</a></td>";
        }
        

        echo "<td>$date</td>";
        echo "<td><a href='comment?approve={$id}'>Approve</a></td>";
        echo "<td><a href='comment?unapprove={$id}'>Unapprove</a></td>";
        echo "<td><a href='comment?del={$id}'>Delete</a></td>";
        echo "</tr>";
    }

      /// Delete Comment
          if (isset($_GET['del'])) {
          $the_id = mysqli_real_escape_string($conn, $_GET['del']);

            $query = "DELETE FROM comment WHERE id = {$the_id}";
            $delete_comment = mysqli_query($conn, $query) ;

            $_SESSION['ErrorMessage'] = "Comment as Been Deleted";
            Redirect("comment");
        }

    /// Unapprove Comment
        if (isset($_GET['unapprove'])) {
        	$unapprove_id = mysqli_real_escape_string($conn, $_GET['unapprove']);

        	$query = "UPDATE comment SET status = 'unapproved' WHERE id = $unapprove_id ";
        	$unapprove_comment = mysqli_query($conn, $query);

        	$_SESSION['ErrorMessage'] = "Comment Has been Un-Approve";
        	Redirect("comment");

        }
    /// Approve Comment
        if (isset($_GET['approve'])) {
        	$approve_id = mysqli_real_escape_string($conn, $_GET['approve']);

        	$query = "UPDATE comment SET status = 'approved' WHERE id = $approve_id ";
        	$approve_comment = mysqli_query($conn, $query);

        	$_SESSION['SuccessMessage'] = "Comment Has been Approve";
        	Redirect("comment");
        }
    }

/// View Category in Blog Page
function Category () {
	global $conn;
	$query = "SELECT * FROM categories LIMIT 4";
	$categories_query = mysqli_query($conn, $query);

	while ($row = mysqli_fetch_assoc($categories_query)) {
		$cat_id = $row['id'];
		$cat_title = $row['title'];
		echo "<li><a href='Category?category=$cat_id'>{$cat_title}</a></li>";
	}
}

/// Post Comment to Database
function Comment_database () {
	global $conn;
	if (isset($_POST['comment'])) {

		$the_post_id = $_GET['post'];
		$author = $_POST['author'];
		$email = $_POST['email'];
		$content = $_POST['content'];

		$query = "INSERT INTO comment (post, date, author, email, comment, status)";

		$query .= "VALUES ('$the_post_id', now(), '$author', '$email', '$content', 'unapprove')";

		$create_comment = mysqli_query($conn, $query);

		if (!$create_comment) {

			die('Query Failed' .mysqli_error($conn));

		}

		$query = "UPDATE post SET comment_count = comment_count + 1 WHERE id = $the_post_id";
		$count_comment = mysqli_query($conn, $query);
	}
}

?>