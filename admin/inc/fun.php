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
      $query = "SELECT * FROM post ORDER BY date";
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

        $query = "SELECT * FROM post WHERE id = '$Post' ORDER BY id";
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

/// View All Users
function View_All_User() {
      global $conn; 
      $query = "SELECT * FROM users";
      $Select_post_query = mysqli_query($conn, $query);

      while ($row = mysqli_fetch_assoc($Select_post_query)) {
      $id = mysqli_real_escape_string($conn, $row['id']);
      $username = mysqli_real_escape_string($conn, $row['username']);
      $firstname = mysqli_real_escape_string($conn, $row['firstname']);
      $date = mysqli_real_escape_string($conn, $row['date']);
      $lastname = mysqli_real_escape_string($conn, $row['lastname']);
      $email = mysqli_real_escape_string($conn, $row['email']);
      $image = mysqli_real_escape_string($conn, $row['image']);
      $role = mysqli_real_escape_string($conn, $row['role']);

      // User Table

        echo "<tr>";
        echo "<td>$id</td>";
        echo "<td>$username</td>";
        echo "<td>$firstname</td>";
        echo "<td>$lastname</td>";
        echo "<td>$email</td>";
        echo "<td><img src='../upload/$image' alt='Post Image' width='125px'></td>";
        echo "<td>$role</td>";
        echo "<td>$date</td>";
        echo "<td><a href='viewusers?ad={$id}'>Admin</a></td>";
        echo "<td><a href='viewusers?sub={$id}'>Subscriber</a></td>";
        echo "<td><a href='edituser?edit={$id}'>Edit</a></td>";
        echo "<td><a href='viewusers?del={$id}'>Delete</a></td>";
        echo "</tr>";
    }

      /// Delete User
          if (isset($_GET['del'])) {
          $the_id = mysqli_real_escape_string($conn, $_GET['del']);

            $query = "DELETE FROM users WHERE id = {$the_id}";
            $delete_user = mysqli_query($conn, $query) ;

            $_SESSION['ErrorMessage'] = "User as Been Deleted";
            Redirect("viewusers");
        }
     /// Change User to Admin
        if (isset($_GET['ad'])) {
        	$admin = mysqli_real_escape_string($conn, $_GET['ad']);

        	$admin_role = "UPDATE users SET role = 'Admin' WHERE id = $admin ";
        	$admiral = mysqli_query($conn, $admin_role);

        	$_SESSION['SuccessMessage'] = "User as Been Change to Admin";
        	Redirect("viewusers");
        }
     /// Change User to Subscriber
        if (isset($_GET['sub'])) {
        	$Subscribe = mysqli_real_escape_string($conn, $_GET['sub']);

        	$subscribe_role = "UPDATE users SET role = 'Subscriber' WHERE id = $Subscribe ";
        	$subscri = mysqli_query($conn, $subscribe_role);

        	$_SESSION['ErrorMessage'] = "User as Been Change to Subscribe";
        	Redirect("viewusers");
        }
    }

// Add Users
function AddUser() {
	global $conn;
	if (isset($_POST['adduser'])) {
		
		$firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
		$lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$role = mysqli_real_escape_string($conn, $_POST['role']);


        if ($firstname == "" || empty($firstname)) {
        	$_SESSION['ErrorMessage'] = "All This Fields Should Not Be Empty";
        	Redirect("viewusers");
        }
        else {

        $query = "INSERT INTO users(username, firstname, date, lastname, email, role) 
        VALUE('$username', '$firstname', now(), '$lastname', '$email', '$role')";

        $create_user = mysqli_query($conn, $query);

        if (!$create_user) {
        	die("Am a Killer" . mysqli_error($conn));
        }elseif ($create_user) {
        	$_SESSION['SuccessMessage'] = "$username Has Been Added Successfuly";
        	redirect("viewusers");
        }
    }
}

}

// View User Role

function ViewRole () {
	global $conn;
	$query = "SELECT * FROM users";
	$select_users = mysqli_query($conn, $query);

	while ($row = mysqli_fetch_assoc($select_users)) {
		$id = mysqli_real_escape_string($conn, $row['id']);
		$role = mysqli_real_escape_string($conn, $row['role']);
		
		echo "<option value='$id'>$role</option>";
	}
}

/// Login 
function Login () {
		global $conn;
	if (isset($_GET['login'])) {
		$username = mysqli_real_escape_string($conn, $_GET['username']);
		$password = mysqli_real_escape_string($conn, $_GET['password']);

		$query = "SELECT * FROM users WHERE username = '$username' ";
		$login_user = mysqli_query($conn, $query);

		if (!$login_user) {
			die("I Have Killed you" . mysqli_error($conn));
		}

		while ($row = mysqli_fetch_array($login_user)) {
			$id = $row['id'];
			$user = $row['username'];
			$word = $row['password'];
			$firstname = $row['firstname'];
			$lastname = $row['lastname'];
			$role = $row['role'];
		}
		if ($username !== $user && $password !== $word) {
			$_SESSION['ErrorMessage'] = "No User Like That in Our Database";
        	redirect("login");
		} else if ($username == $user && $password == $word) {
			$_SESSION['username'] = $user;
			$_SESSION['firstname'] = $firstname;
			$_SESSION['lastname'] = $lastname;
			$_SESSION['role'] = $role;
			$_SESSION['SuccessMessage'] = "$user Has Been Login Successfuly";
        	redirect("index");
		} else {
			$_SESSION['ErrorMessage'] = "Invalid Username or Password";
		}
	}
}

function Check_Admin () {
  global $conn;
  if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] !==  'Admin') {
      $_SESSION['ErrorMessage'] = "Your account cannot access Admin Panel";
      Redirect("login");
    }
  } elseif (!isset($_SESSION['role'])) {
    $_SESSION['ErrorMessage'] = "Login in your Admin Account";
    Redirect("login");
  }
 }
?>