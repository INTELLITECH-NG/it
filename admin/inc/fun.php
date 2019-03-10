<?php 
// Add Category
function Add_category() {
			global $conn ;
			if (isset($_POST['submit'])) {
			$title = $_POST['main_title'];

			if ($title == "" || empty($title)) {
			echo "This Felid Should Not Be Empty";
			}else {
				$query = "INSERT INTO categories(title)";
				$query .= "VALUE('{$title}')" ;

				$create_category = mysqli_query($conn, $query);

			if (!$create_category) {
			  die('Am A killer' . mysqli_error($conn));
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

			header("Location: categories");
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

        $query = "INSERT INTO post(category, author, date, tags, content, title, status, image) 
        VALUE('$category', '$author', now(), '$tag', '$content', '$title', '$status', '$image')";

        $create_category = mysqli_query($conn, $query);
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


 ?>