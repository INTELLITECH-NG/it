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

			header("Location: categories.php");
		}
		
	}



 ?>