<?php
/// Function for session
ob_start();
session_start();

/// Date and Time
function Datetime() {
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

/// Success Message Echo
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
    header("Location:" . $New_Location);
    exit;
}

// Add Category
function Add_category() {
    global $conn;
    if (isset($_POST['submit'])) {
        $title = mysqli_real_escape_string($conn, $_POST['main_title']);

        // Check if it is Empty
        if ($title == "" || empty($title)) {
            $_SESSION['ErrorMessage'] = "This Felid Should Not Be Empty";
            Redirect("categories");

            // Category Lenght
        } elseif (strlen($title) > 20) {
            $_SESSION['ErrorMessage'] = "This is too Long";
            Redirect("categories");
        } else {
            // Insert into Database
            $query = "INSERT INTO categories(title)";
            $query .= "VALUE('{$title}')";

            $create_category = mysqli_query($conn, $query);

            // Check for Error in Database
            if (!$create_category) {
                die('Am A killer' . mysqli_error($conn));

                // Susscess Massage 
            } elseif ($create_category) {
                $_SESSION['SuccessMessage'] = "Category Added to Database";
                redirect("categories");
            }
        }
    }
}

//Categories Table Function

function Table() {

    global $conn;
    $query = "SELECT * FROM categories";
    $categories_query = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($categories_query)) {
        $id = $row['id'];
        $title = mysqli_real_escape_string($conn, $row['title']);

        echo "<tr>";
        echo "<td>$id</td>";
        echo "<td>$title</td>";
        echo "<td><a href='categories.php?edit={$id}' class='btn btn-dark'>Edit</a></td>";
        echo "<td><a href='categories.php?del={$id}' class='btn btn-danger'>Delete</a></td>";
        echo "</tr>";
    }

    if (isset($_GET['del'])) {
        if (isset($_SESSION['role'])) {
            if (isset($_SESSION['role']) == 'Admin') {
                $the_id = mysqli_real_escape_string($conn, $_GET['del']);
                $query = "DELETE FROM categories WHERE id = {$the_id}";
                $delete_category = mysqli_query($conn, $query);

                $_SESSION['ErrorMessage'] = "Category as Been Deleted";
                Redirect("categories");
            }
        }
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
        /* $comment = 5; */
        $content = mysqli_real_escape_string($conn, $_POST['post_content']);

        if ($title == "" || empty($title)) {
            $_SESSION['ErrorMessage'] = "All This Fields Should Not Be Empty";
            Redirect("addpost");
        } else {

            $query = "INSERT INTO post(category, author, date, tags, content, title, status, image) 
        VALUE('$category', '$author', now(), '$tag', '$content', '$title', '$status', '$image')";

            $create_post = mysqli_query($conn, $query);

            if (!$create_post) {
                die("Am a Killer" . mysqli_error($conn));
            } elseif ($create_post) {
                $_SESSION['SuccessMessage'] = "Post Added Successfuly";
                redirect("viewpost");
            }
        }
    }
}

// ViewPost
function ViewPost() {
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
    $query = "SELECT * FROM post ORDER BY date DESC";
    $Select_post_query = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($Select_post_query)) {
        $id = mysqli_real_escape_string($conn, $row['id']);
        $Cat_id = mysqli_real_escape_string($conn, $row['category']);
        $title = mysqli_real_escape_string($conn, $row['title']);
        $author = mysqli_real_escape_string($conn, $row['author']);
        $date = mysqli_real_escape_string($conn, $row['date']);
        $image = mysqli_real_escape_string($conn, $row['image']);
        $content = substr($row['content'], 0, 15);
        $tags = mysqli_real_escape_string($conn, $row['tags']);
        $comment = mysqli_real_escape_string($conn, $row['comment_count']);
        $status = mysqli_real_escape_string($conn, $row['status']);
        $view_count = mysqli_real_escape_string($conn, $row['view_count']);

        // Post Table

        echo "<tr>";
        echo "<td><input type='checkbox' class='checkBoxes' name='checkBoxArray[]' value='$id'></td>";
        echo "<td>$id</td>";
        echo "<td>$author</td>";
        /* echo "<td>$content</td>"; */
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

        $Query = "SELECT * FROM comment WHERE post = $id ";
        $send_comment = mysqli_query($conn, $Query);
        $row = mysqli_fetch_array($send_comment);
        $comment_id = $row['id'];
        $count_comment = mysqli_num_rows($send_comment);

        echo "<td><a href='viewcomment?id=$id'>$count_comment</a></td>";

        echo "<td><a href='viewpost?reset={$id}' onClick=\"javascript: return confirm('Are you sure you want to Reset View count') \">$view_count</a></td>";
        echo "<td>$date</td>";
        echo "<td><a href='../Post?post={$id}' class='btn btn-dark' target='_blank'>View Post</a></td>";
        echo "<td><a href='editpost?edit={$id}' class='btn btn-info'>Edit</a></td>";
        ?>

        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <?php
            echo '<td><input type="submit" value="Delete" name="del" class="btn btn-danger"></td>';
            ?>
        </form>

        <?php
        echo "<td><a href='viewpost?draft={$id}' class='btn btn-secondary'>Draft</a></td>";
        echo "<td><a href='viewpost?publish={$id}' class='btn btn-success'>Published</a></td>";
        echo "</tr>";
    }

    /// Delete Post
    if (isset($_POST['del'])) {
        if (isset($_SESSION['role'])) {
            if (isset($_SESSION['role']) == 'Admin') {
                $the_id = mysqli_real_escape_string($conn, $_POST['id']);
                $query = "DELETE FROM post WHERE id = {$the_id}";
                $delete_category = mysqli_query($conn, $query);

                $_SESSION['ErrorMessage'] = "Post as Been Deleted";
                Redirect("viewpost");
            }
        }
    }
    /// Reset Count
    if (isset($_GET['reset'])) {
        if (isset($_SESSION['role'])) {
            if (isset($_SESSION['role']) == 'Admin') {
                $the_id = mysqli_real_escape_string($conn, $_GET['reset']);

                $reset = "UPDATE post SET view_count = 0 WHERE id = $the_id ";
                $reset_count = mysqli_query($conn, $reset);

                $_SESSION['SuccessMessage'] = "View Reset";
                Redirect("viewpost");
            }
        }
    }
    /// Draft Post
    if (isset($_GET['draft'])) {
        if (isset($_SESSION['role'])) {
            if (isset($_SESSION['role']) == 'Admin') {
                $draft_id = mysqli_real_escape_string($conn, $_GET['draft']);

                $query = "UPDATE post SET status = 'Draft' WHERE id = $draft_id ";
                $draft = mysqli_query($conn, $query);

                $_SESSION['ErrorMessage'] = "Post Has Been Draft";
                Redirect("viewpost");
            }
        }
    }


    /// Published Post 
    if (isset($_GET['publish'])) {
        $publish_id = mysqli_real_escape_string($conn, $_GET['publish']);

        $query = "UPDATE post SET status = 'Published' WHERE id = '$publish_id' ";
        $publish = mysqli_query($conn, $query);

        $_SESSION['SuccessMessage'] = "Post Has Been Published";
        Redirect("viewpost");
    }

    /// CheckBox 
    if (isset($_POST['checkBoxArray'])) {
        foreach ($_POST['checkBoxArray'] as $checkboxValue) {
            $bulk_options = $_POST['bulk_options'];

            switch ($bulk_options) {
                case 'Published':
                    $Publish = "UPDATE post SET status = '$bulk_options' WHERE id = '$checkboxValue' ";
                    $publish = mysqli_query($conn, $Publish);

                    $_SESSION['SuccessMessage'] = "Published Successfully";
                    Redirect("viewpost");
                    break;

                case 'Draft':
                    $Draft = "UPDATE post SET status = '$bulk_options' WHERE id = '$checkboxValue' ";
                    $draft = mysqli_query($conn, $Draft);

                    $_SESSION['ErrorMessage'] = "Draft Successfully";
                    Redirect("viewpost");
                    break;

                case 'Delete':
                    $Delete = "DELETE FROM post WHERE id = '$checkboxValue' ";
                    $delete = mysqli_query($conn, $Delete);

                    $_SESSION['ErrorMessage'] = "Deleted Successfully";
                    Redirect("viewpost");
                    break;

                case 'Clone':
                    $Clone = "SELECT * FROM post WHERE id = '$checkboxValue' ";
                    $clone = mysqli_query($conn, $Clone);

                    while ($row = mysqli_fetch_array($clone)) {
                        $Cat_id = mysqli_real_escape_string($conn, $row['category']);
                        $title = $row['title'];
                        $author = mysqli_real_escape_string($conn, $row['author']);
                        $image = mysqli_real_escape_string($conn, $row['image']);
                        $content = $row['content'];
                        $tags = mysqli_real_escape_string($conn, $row['tags']);
                        $comment = mysqli_real_escape_string($conn, $row['comment_count']);
                        $status = mysqli_real_escape_string($conn, $row['status']);
                    }

                    $clonedb = "INSERT INTO post(category, title, author, date, image, content, tags, comment_count, status)
              VALUE('$Cat_id', '$title', '$author', now(), '$image', '$content', '$tags', '$comment', '$status')";

                    $clone_db = mysqli_query($conn, $clonedb);

                    $_SESSION['SuccessMessage'] = "Successfully Added";
                    Redirect("viewpost");

                    if (!$clone_db) {
                        die("Am a Killer " . mysqli_error($conn));
                    }
                    break;
            }
        }
    }
}

/// View Comment
function View_Comment() {
    global $conn;
    $query = "SELECT * FROM comment";
    $Select_post_query = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($Select_post_query)) {
        $id = mysqli_real_escape_string($conn, $row['id']);
        $Post = mysqli_real_escape_string($conn, $row['post']);
        $date = mysqli_real_escape_string($conn, $row['date']);
        $author = mysqli_real_escape_string($conn, $row['author']);
        $email = mysqli_real_escape_string($conn, $row['email']);
        $comment = mysqli_real_escape_string($conn, $row['comment']);
        $status = mysqli_real_escape_string($conn, $row['status']);

        // Comment Table

        echo "<tr>";
        echo "<td>$id</td>";
        echo "<td>$author</td>";
        echo "<td>$comment</td>";
        echo "<td>$email</td>";
        if ($status == 'Approved') {
            echo "<td><span class='btn btn-outline-success'>$status</span></td>";
        } else {
            echo "<td><span class='btn btn-outline-warning'>$status</span></td>";
        }

        $query = "SELECT * FROM post WHERE id = '$Post' ORDER BY id";
        $select_post_id = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($select_post_id)) {
            $post_id = $row['id'];
            $post_title = $row['title'];

            echo "<td><a href='../Post?post=$post_id'>$post_title</a></td>";
        }


        echo "<td>$date</td>";
        echo "<td><a href='comment?Approve={$id}' class='btn btn-success'>Approve</a></td>";
        echo "<td><a href='comment?Unapprove={$id}' class='btn btn-dark'>Unapprove</a></td>";
        echo "<td><a onClick=\"javascript: return confirm('Are you Sure you want to delete'); \" href='comment?del={$id}' class='btn btn-danger'>Delete</a></td>";
        echo "</tr>";
    }

    /// Delete Comment
    if (isset($_GET['del'])) {
        if (isset($_SESSION['role'])) {
            if (isset($_SESSION['role']) == 'Admin') {
                $the_id = mysqli_real_escape_string($conn, $_GET['del']);

                $query = "DELETE FROM comment WHERE id = {$the_id}";
                $delete_comment = mysqli_query($conn, $query);

                $_SESSION['ErrorMessage'] = "Comment as Been Deleted";
                Redirect("comment");
            }
        }
    }

    /// Unapprove Comment
    if (isset($_GET['Unapprove'])) {
        $unapprove_id = mysqli_real_escape_string($conn, $_GET['Unapprove']);

        $query = "UPDATE comment SET status = 'Unapproved' WHERE id = $unapprove_id ";
        $unapprove_comment = mysqli_query($conn, $query);

        $_SESSION['ErrorMessage'] = "Comment Has been Un-Approve";
        Redirect("comment");
    }
    /// Approve Comment
    if (isset($_GET['Approve'])) {
        $approve_id = mysqli_real_escape_string($conn, $_GET['Approve']);

        $query = "UPDATE comment SET status = 'Approved' WHERE id = $approve_id ";
        $approve_comment = mysqli_query($conn, $query);

        $_SESSION['SuccessMessage'] = "Comment Has been Approve";
        Redirect("comment");
    }
}

/// Comment Page
function Comment_View() {
    global $conn;
    $query = "SELECT * FROM comment WHERE post =" . mysqli_real_escape_string($conn, $_GET['id']) . "";
    $Select_post_query = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($Select_post_query)) {
        $id = mysqli_real_escape_string($conn, $row['id']);
        $Post = mysqli_real_escape_string($conn, $row['post']);
        $date = mysqli_real_escape_string($conn, $row['date']);
        $author = mysqli_real_escape_string($conn, $row['author']);
        $email = mysqli_real_escape_string($conn, $row['email']);
        $comment = mysqli_real_escape_string($conn, $row['comment']);
        ;
        $status = mysqli_real_escape_string($conn, $row['status']);

        // Comment Table

        echo "<tr>";
        echo "<td>$id</td>";
        echo "<td>$author</td>";
        echo "<td>$comment</td>";
        echo "<td>$email</td>";
        if ($status == 'Approved') {
            echo "<td><span class='btn btn-outline-success'>$status</span></td>";
        } else {
            echo "<td><span class='btn btn-outline-warning'>$status</span></td>";
        }

        $query = "SELECT * FROM post WHERE id = '$Post' ORDER BY id";
        $select_post_id = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($select_post_id)) {
            $post_id = $row['id'];
            $post_title = $row['title'];

            echo "<td><a href='../Post?post=$post_id'>$post_title</a></td>";
        }


        echo "<td>$date</td>";
        echo "<td><a href='viewcomment?Approve={$id}&id=" . $_GET['id'] . "' class='btn btn-success'>Approve</a></td>";
        echo "<td><a href='viewcomment?Unapprove={$id}&id=" . $_GET['id'] . "' class='btn btn-dark'>Unapprove</a></td>";
        echo "<td><a onClick=\"javascript: return confirm('Are you Sure you want to delete'); \" href='viewcomment?del={$id}&id=" . $_GET['id'] . "' class='btn btn-danger'>Delete</a></td>";
        echo "</tr>";
    }

    /// Delete Comment
    if (isset($_GET['del'])) {
        if (isset($_SESSION['role'])) {
            if (isset($_SESSION['role']) == 'Admin') {
                $the_id = mysqli_real_escape_string($conn, $_GET['del']);

                $query = "DELETE FROM comment WHERE id = {$the_id}";
                $delete_comment = mysqli_query($conn, $query);

                $_SESSION['ErrorMessage'] = "Comment as Been Deleted";
                Redirect("viewcomment?id=" . $_GET['id'] . "");
            }
        }
    }

    /// Unapprove Comment
    if (isset($_GET['Unapprove'])) {
        $unapprove_id = mysqli_real_escape_string($conn, $_GET['Unapprove']);

        $query = "UPDATE comment SET status = 'Unapproved' WHERE id = $unapprove_id ";
        $unapprove_comment = mysqli_query($conn, $query);

        $_SESSION['ErrorMessage'] = "Comment Has been Un-Approve";
        Redirect("viewcomment?id=" . $_GET['id'] . "");
    }
    /// Approve Comment
    if (isset($_GET['Approve'])) {
        $approve_id = mysqli_real_escape_string($conn, $_GET['Approve']);

        $query = "UPDATE comment SET status = 'Approved' WHERE id = $approve_id ";
        $approve_comment = mysqli_query($conn, $query);

        $_SESSION['SuccessMessage'] = "Comment Has been Approve";
        Redirect("viewcomment?id=" . $_GET['id'] . "");
    }
}

/// View Category in Blog Page
function Category() {
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
function Comment_database() {
    global $conn;
    if (isset($_POST['comment'])) {

        $the_post_id = mysqli_real_escape_string($conn, $_GET['post']);
        $author = mysqli_real_escape_string($conn, $_POST['author']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);

        if (!empty($author) && !empty($email) && !empty($content)) {

            $query = "INSERT INTO comment (post, date, author, email, comment, status)";
            $query .= "VALUES ('$the_post_id', now(), '$author', '$email', '$content', 'unapprove')";
            $create_comment = mysqli_query($conn, $query);

            if (!$create_comment) {
                die('Query Failed' . mysqli_error($conn));
            }

            /* $query = "UPDATE post SET comment_count = comment_count + 1 WHERE id = $the_post_id";
              $count_comment = mysqli_query($conn, $query);
             */
            echo "<script>alert('Commented Successfully')</script>";
        }
    }
}

/// View All Users
function View_All_User() {
    global $conn;
    $query = "SELECT * FROM users ORDER BY date";
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
        if ($role == 'Admin') {
            echo "<td><span class='btn btn-outline-success'>$role</span></td>";
        } else {
            echo "<td><span class='btn btn-outline-warning'>$role</span></td>";
        }
        echo "<td>$date</td>";
        echo "<td><a href='viewusers?ad={$id}' class='btn btn-success'>Admin</a></td>";
        echo "<td><a href='viewusers?sub={$id}' class='btn btn-secondary'>Subscriber</a></td>";
        echo "<td><a href='edituser?edit={$id}' class='btn btn-dark'>Edit</a></td>";
        echo "<td><a href='viewusers?del={$id}' class='btn btn-danger'>Delete</a></td>";
        echo "</tr>";
    }

    /// Delete User
    if (isset($_GET['del'])) {
        if (isset($_SESSION['role'])) {
            if (isset($_SESSION['role']) == 'Admin') {
                $the_id = mysqli_real_escape_string($conn, $_GET['del']);

                $query = "DELETE FROM users WHERE id = {$the_id}";
                $delete_user = mysqli_query($conn, $query);

                $_SESSION['ErrorMessage'] = "User as Been Deleted";
                Redirect("viewusers");
            }
        }
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
        $subscribe = mysqli_query($conn, $subscribe_role);

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
        } else {


            $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
            /*
              $rand = "SELECT randSalt FROM users";
              $select_rand = mysqli_query($conn, $rand);

              if (!$select_rand) {
              die("Am a killer " . mysqli_error($conn));
              }

              $row = mysqli_fetch_array($select_rand);
              $salt = $row['randSalt'];
              $password = crypt($password, $salt); */

            $query = "INSERT INTO users(username, firstname, date, lastname, email, role, password) 
        VALUE('$username', '$firstname', now(), '$lastname', '$email', '$role', '$password')";

            $create_user = mysqli_query($conn, $query);

            if (!$create_user) {
                die("Am a Killer" . mysqli_error($conn));
            } elseif ($create_user) {
                $_SESSION['SuccessMessage'] = "$username Has Been Added Successfuly";
                redirect("viewusers");
            }
        }
    }
}

// View User Role

function ViewRole() {
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
function Admin_Login() {
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
            $user = mysqli_real_escape_string($conn, $row['username']);
            $word = mysqli_real_escape_string($conn, $row['password']);
            $firstname = mysqli_real_escape_string($conn, $row['firstname']);
            $lastname = mysqli_real_escape_string($conn, $row['lastname']);
            $role = mysqli_real_escape_string($conn, $row['role']);
            $email = mysqli_real_escape_string($conn, $row['email']);
        }

        if ($user == "" || empty($user) && $word == "" || empty($word)) {
            $_SESSION['ErrorMessage'] = "Login";
            Redirect("login");
        } elseif (password_verify($password, $word)) {

            $_SESSION['username'] = $user;
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;
            $_SESSION['role'] = $role;
            $_SESSION['SuccessMessage'] = "$user Has Been Granted Access";
            redirect("index");
        } else {
            $_SESSION['ErrorMessage'] = "Invalid Username or Password";
        }
    }
}

function Check_Admin() {
    global $conn;
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Subscriber') {
            $_SESSION['ErrorMessage'] = "Access Denied";
            Redirect("login");
        }
    } elseif (!isset($_SESSION['role'])) {
        $_SESSION['ErrorMessage'] = "Login in your Account";
        Redirect("login");
    }
}

function Username_exist($username) {
    global $conn;
    $Query = "SELECT username FROM users WHERE username = '$username' ";
    $Exist = mysqli_query($conn, $Query);

    if (mysqli_num_rows($Exist) > 0) {
        return true;
    } else {
        return false;
    }
}

function Email_exist($email) {
    global $conn;
    $Query = "SELECT email FROM users WHERE email = '$email' ";
    $Exist = mysqli_query($conn, $Query);

    if (mysqli_num_rows($Exist) > 0) {
        return true;
    } else {
        return false;
    }
}

function Reg_User() {
    global $conn;
    if (isset($_POST['reguser'])) {
        $firstname = mysqli_real_escape_string($conn, trim($_POST['firstname']));
        $lastname = mysqli_real_escape_string($conn, trim($_POST['lastname']));
        $username = mysqli_real_escape_string($conn, trim($_POST['username']));
        $password = mysqli_real_escape_string($conn, trim($_POST['password']));
        $email = mysqli_real_escape_string($conn, trim($_POST['email']));
        $role = "Subscriber";

        if (Username_exist($username)) {
            $_SESSION['ErrorMessage'] = "Username Already Existing";
            Redirect("register");
        } else {

            if (Email_exist($email)) {
                $_SESSION['ErrorMessage'] = "Email Address is Already Exist";
                Redirect("register");
            } else {

                if ($firstname == "" || empty($firstname) && $lastname == "" || empty($lastname) && $username == "" || empty($username) && $password == "" || empty($password) && $email == "" || empty($email)) {

                    $_SESSION['ErrorMessage'] = "All Fields Must be Fill";
                    Redirect("register");
                } else {

                    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

                    $Query = "INSERT INTO users(firstname, lastname, username, password, email, date, role)
                    VALUE('$firstname', '$lastname', '$username', '$password', '$email', now(), '$role')";

                    $user_reg = mysqli_query($conn, $Query);
                    $_SESSION['SuccessMessage'] = "Registration Successfully";
                    Redirect("login");

                    if (!$user_reg) {
                        die("Am a Killer " . mysqli_error($conn));
                    } elseif (Username_exist($username)) {
                        $_SESSION['ErrorMessage'] = "Error Creating User";
                    }
                }
            }
        }
    }
}

function Contact() {
    global $conn;
    if (isset($_POST['contact'])) {
        $to = 'configureall@gmail.com';
        $subject = wordwrap($_POST['subject'], 70);
        $message = $_POST['message'];
        $name = $_POST['name'];
        $header = "From: " . $_POST['email'];

        mail($to, $subject, $message, $header, $name);

        echo "<script>alert('Mail Send Successfully')</script>";
    }
}

function is_admin($user) {
    global $conn;
    $Query = "SELECT role FROM users WHERE username = '$user' ";
    $send = mysqli_query($conn, $Query);

    $row = mysqli_fetch_array($send);

    if ($row['role'] == 'Admin') {
        return true;
    } else {
        return false;
    }
}

function Email_exist_intern($email_intern) {
    global $conn;
    $Query = "SELECT email FROM intern WHERE email = '$email_intern' ";
    $Intern = mysqli_query($conn, $Query);

    if (mysqli_num_rows($Intern) > 0) {
        return true;
    } else {
        return false;
    }
}

function random_strings($length_of_string) { 
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
    return substr(str_shuffle($str_result), 0, $length_of_string); 
}

function validate_intern($conn) {
    $errors = [];
    $min = 3;
    $max = 20;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $firstname = mysqli_real_escape_string($conn, trim(ucfirst($_POST['firstName'])));
        $lastname = mysqli_real_escape_string($conn, trim(ucfirst($_POST['lastName'])));
        $track = mysqli_real_escape_string($conn, trim($_POST['track']));
        $level = mysqli_real_escape_string($conn, trim($_POST['level']));
        $email_intern = mysqli_real_escape_string($conn, trim($_POST['email']));
        date_default_timezone_set("Africa/Lagos");
        $date = date("h:i:s a m/d/Y");
        $badge = random_strings(8);
        $forward = '<body>
        <head>
        <title></title>
        <!--[if !mso]><!-- -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--<![endif]-->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style type="text/css">
            #outlook a {
                padding: 0;
            }
            
            .ReadMsgBody {
                width: 100%;
            }
            
            .ExternalClass {
                width: 100%;
            }
            
            .ExternalClass * {
                line-height: 100%;
            }
            
            body {
                margin: 0;
                padding: 0;
                -webkit-text-size-adjust: 100%;
                -ms-text-size-adjust: 100%;
            }
            
            table,
            td {
                border-collapse: collapse;
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
            }
            
            img {
                border: 0;
                height: auto;
                line-height: 100%;
                outline: none;
                text-decoration: none;
                -ms-interpolation-mode: bicubic;
            }
            
            p {
                display: block;
                margin: 13px 0;
            }
        </style>
        <!--[if !mso]><!-->
        <style type="text/css">
            @media only screen and (max-width:480px) {
                @-ms-viewport {
                    width: 320px;
                }
                @viewport {
                    width: 320px;
                }
            }
        </style>
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,500,700" rel="stylesheet" type="text/css">
        <style type="text/css">
            @import url(https://fonts.googleapis.com/css?family=Lato:300,400,500,700);
        </style>
        <!--<![endif]-->
        <style type="text/css">
            @media all and (min-width: 480px) {
                .sf-main {
                    padding: 30px 90px;
                }
                .sf-wrapper {
                    box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.06);
                }
            }
        </style>
        <style type="text/css">
            @media only screen and (min-width:480px) {
                .mj-column-per-100 {
                    width: 100%!important;
                }
            }
        </style>
    </head>

    <body style="background: #EDF0F2;">
        <div class="mj-container" style="background-color:#EDF0F2;">
            <div style="margin:0px auto;max-width:600px;background:#EDF0F2;">
                <table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:#EDF0F2;" align="center" border="0">
                    <tbody>
                        <tr>
                            <td style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:20px 0px;padding-top:30px;">
                                <div class="mj-column-per-100 outlook-group-fix" style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%;">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="margin:0px auto;border-radius:6px;max-width:600px;" class="sf-wrapper">
                <table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;border-radius:6px;background:#fff;" align="center" border="0">
                    <tbody>
                        <tr>
                            <td style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:20px 0px;">
                                <div style="margin:0px auto;max-width:600px;" class="sf-main">
                                    <table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;" align="center" border="0">
                                        <tbody>
                                            <tr>
                                                <td style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:20px 0px;">
                                                    <div class="mj-column-per-100 outlook-group-fix" style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%;">
                                                        <table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="word-wrap:break-word;font-size:0px;">
                                                                        <div style="font-size:1px;line-height:20px;white-space:nowrap;">&nbsp;</div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="word-wrap:break-word;font-size:0px;padding:10px 25px;" align="left">
                                                                        <div style="cursor:auto;color:#3A3D3E;font-family:Lato, Arial, sans-serif;font-size:25px;font-weight:900;line-height:1.2;text-align:left;">Welcome to INTELLITECH.NG Internship</div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="word-wrap:break-word;font-size:0px;padding:10px 25px;" align="left">
                                                                        <div style="cursor:auto;color:#3A3D3E;font-family:Lato, Arial, sans-serif;font-size:15px;font-weight:400;line-height:22px;text-align:left;">Hi <span style="font-weight: bold;">' . $firstname . ' ' . $lastname . '</span>,<br> We received below details from you today at ' . $date . '</div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="word-wrap:break-word;font-size:0px;padding:10px 25px;">
                                                                        <p style="font-size:1px;margin:0px auto;border-top:2px solid #EDF0F2;width:100%;"></p>
                                                                        <!--[if mso | IE]><table role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" style="font-size:1px;margin:0px auto;border-top:2px solid #EDF0F2;width:100%;" width="600"><tr><td style="height:0;line-height:0;"> </td></tr></table><![endif]-->
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="word-wrap:break-word;font-size:0px;padding:10px 25px;" align="left">
                                                                        <div style="cursor:auto;color:#3A3D3E;font-family:Lato, Arial, sans-serif;font-size:15px;font-weight:700;line-height:22px;text-align:left;">Here are your information:</div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="word-wrap:break-word;font-size:0px;padding:10px 25px;" align="left">
                                                                        <table cellpadding="0" cellspacing="0" style="cellspacing:0px;color:#3A3D3E;font-family:Lato, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;" width="100%" border="0">
                                                                            <tbody>
                                                                                <tr style="text-align: left;">
                                                                                    <th style="color: #949698; font-weight: normal; font-weight: 400; padding-bottom: 12px;">Badge Id:</th>
                                                                                    <td style="padding-bottom: 12px;">' . $badge . '</td>
                                                                                </tr>
                                                                                <tr style="text-align: left;">
                                                                                    <th style="color: #949698; font-weight: normal; font-weight: 400; padding-bottom: 12px;">Track:</th>
                                                                                    <td style="padding-bottom: 12px;">' . $track . '</td>
                                                                                </tr>
                                                                                <tr style="text-align: left;">
                                                                                    <th style="color: #949698;  font-weight: normal; font-weight: 400; padding-bottom: 12px;">Level:</th>
                                                                                    <td style="padding-bottom: 12px;">' . $level . '</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="word-wrap:break-word;font-size:0px;padding:10px 25px;">
                                                                        <p style="font-size:1px;margin:0px auto;border-top:2px solid #EDF0F2;width:100%;"></p>
                                                                        <!--[if mso | IE]><table role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" style="font-size:1px;margin:0px auto;border-top:2px solid #EDF0F2;width:100%;" width="600"><tr><td style="height:0;line-height:0;"> </td></tr></table><![endif]-->
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="word-wrap:break-word;font-size:0px;padding:10px 25px;" align="left">
                                                                        <div style="cursor:auto;color:#3A3D3E;font-family:Lato, Arial, sans-serif;font-size:15px;font-weight:400;line-height:22px;text-align:left;"><span style="font-style: italic;">Thanks for the bold step taking to change your world.</span><br><span style="font-weight: bold;">The INTELLITECH Team</span></div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <table class="sf-footer" role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;" border="0">
                <tbody>
                    <tr>
                        <td>
                            <div style="margin:0px auto;max-width:600px;">
                                <table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;" align="center" border="0">
                                    <tbody>
                                        <tr>
                                            <td style="text-align:center;vertical-align:top;border-top:1px solid #EDF0F2;direction:ltr;font-size:0px;padding:30px;">
                                                <div class="mj-column-per-100 outlook-group-fix" style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%;">
                                                    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
                                                        <tbody>
                                                            <tr>
                                                                <td style="word-wrap:break-word;font-size:0px;padding:10px 25px;padding-bottom:0px;" align="center">
                                                                    <div style="cursor:auto;color:#3A3D3E;font-family:Lato, Arial, sans-serif;font-size:15px;font-weight:400;line-height:22px;text-align:center;"><span style="font-weight: 900;">Questions?</span><br> send us mail at <a href="mailto:internship@intellitech.ng" style="color:#3587CC; text-decoration: none;" target="_blank">internship@intellitech.ng</a>.</div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="word-wrap:break-word;font-size:0px;padding:10px 25px;padding-top:30px;" align="center">
                                                                    <div style="cursor:auto;color:#818585;font-family:Lato, Arial, sans-serif;font-size:12px;font-weight:400;line-height:22px;text-align:center;">1 Dr Peter Odili Road, BY CAC, Trans Amadi, Port Harcourt, Nigeria</div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>';

        if (strlen($firstname) < $min) {
            echo "<script>Swal.fire('Oops!','Your First Name cannot be less than {$min} words','error')</script>";
        } else {
            
            if (strlen($firstname) > $max) {
                echo "<script>Swal.fire('Oops!','Your First Name cannot be more than {$max} word','error')</script>";
            } else {
                
                if (strlen($lastname) < $min) {
                    echo "<script>Swal.fire('Oops!','Your Last Name cannot be less than {$min} words','error')</script>";
                } else {
                    
                    if (strlen($lastname) > $max) {
                        echo "<script>Swal.fire('Oops!','Your Last Name cannot be more than {$max} words','error')</script>";

                    } else {
                        
                        if (Email_exist_intern($email_intern)) {
                            echo "<script>Swal.fire('Oops!','This Email Address has already been Registered','error')</script>";
                        } else {
                            
                            if ($firstname == "" || empty($firstname) && $lastname == "" || empty($lastname) && $track == "" || empty($track) && $level == "" || empty($level) && $email_intern == "" || empty($email_intern)) {
                                echo "<script>Swal.fire('Oops!','All Fields Must be Filled','error')</script>";
                            } else {

                                $Query = "INSERT INTO intern(badge, firstname, lastname, track, level, date, email)
                                VALUE('$badge','$firstname', '$lastname', '$track', '$level', '$date', '$email_intern')";
            
                                $intern_reg = mysqli_query($conn, $Query);

                                require_once 'PHPMailerAutoload.php';

                                $mail = new PHPMailer;

                                $mail->SMTPDebug = 0;                               // Enable verbose debug output

                                $mail->isSMTP();                                      // Set mailer to use SMTP
                                $mail->Host = 'intellitech.ng';  // Specify main and backup SMTP servers
                                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                                $mail->Username = '#######';                 // SMTP username
                                $mail->Password = '######';                           // SMTP password
                                $mail->SMTPSecure = 'ssl';
                                $mail->Mailer = "smtp";                            // Enable TLS encryption, `ssl` also accepted
                                $mail->SMTPKeepAlive = true;
                                $mail->Port = 465;                                    // TCP port to connect to

                                $mail->setFrom('####### Email', 'INTELLITECH');
                                $mail->addAddress($email_intern, $firstname . '' . $lastname);     // Add a recipient
                                $mail->isHTML(true);                                  // Set email format to HTML

                                $mail->Subject = 'INTERNSHIP';
                                $mail->Body    = $forward;

                                if (!$mail->send()) {
                                    echo "<script>Swal.fire('Oops!','Registration Declined','error')</script>";
                                    
                                } else {
                                    echo "<script>Swal.fire('Good job','Registration Successfully','success')</script>";
                                }
                            }
                        }
                    }
                }
            } 
        }
    }
}

function View_All_Interns() {
    global $conn;
    $query = "SELECT * FROM intern ORDER BY id";
    $Select_post_query = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($Select_post_query)) {
        $id = mysqli_real_escape_string($conn, $row['id']);
        $firstname = mysqli_real_escape_string($conn, $row['firstname']);
        $lastname = mysqli_real_escape_string($conn, $row['lastname']);
        $track = mysqli_real_escape_string($conn, $row['track']);
        $level = mysqli_real_escape_string($conn, $row['level']);
        $email = mysqli_real_escape_string($conn, $row['email']);
        $date = mysqli_real_escape_string($conn, $row['date']);

        // User Table

        echo "<tr>";
        echo "<td>$id</td>";
        echo "<td>$firstname</td>";
        echo "<td>$lastname</td>";
        echo "<td>$track</td>";
        echo "<td>$level</td>";
        echo "<td>$email</td>";
        echo "<td>$date</td>";
        echo "</tr>";
    }
}

//send mail
function sendMail() {
    global $conn;
    if (isset($_POST['sendmail'])) {
        include 'MailUtility.php';
        
        $removedSpaces = preg_replace('/\s/', '', $_POST['recipients']);
        $to = explode(',', $removedSpaces);
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        foreach($to as $email){
            $mail = new MailUtility();
            $result = $mail->sendMail($email, $subject, $message);
            if ($result) {
                $_SESSION['SuccessMessage'] = "Emails Sent successfully.";
                
            } else {
                $_SESSION['ErrorMessage'] = "couldn't send some emails.";
            }
            unset($mail);
        }       
    }
}

// Send Mail to interns
function mailInterns() {
    global $conn;
    if (isset($_POST['mailInterns'])) {

        //grab emails and names from database
        $query = 'SELECT `email`,`firstname`,`lastname`,`track`,`level` FROM intern WHERE `send` = 0';
        $select_intern = mysqli_query($conn, $query);

        //start a loop to send an email to each individual
        while ($row = mysqli_fetch_array($select_intern))  {
                      
            $fname = $row['firstname'];
            $lname = $row['lastname'];
            $email = $row['email'];
            $track = $row['track'];
            $level = $row['level'];


            if (mysqli_num_rows($select_intern) > 0) {

                require_once 'PHPMailerAutoload.php';

                $mail = new PHPMailer;

                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host = 'intellitech.ng';
                $mail->SMTPAuth = true;
                $mail->Username = '#########';
                $mail->Password = '######';
                $mail->SMTPSecure = 'ssl';
                $mail->Mailer = "smtp";
                $mail->SMTPKeepAlive = true;
                $mail->Port = 465;

                $mail->setFrom('internship@intellitech.ng', 'INTELLITECH');
                $mail->addAddress($email, $fname . ' ' . $lname);
                $mail->isHTML(true);

                $mail->Subject = 'INTERNSHIP Next Level';

                if ($track == 'Frontend Web Development' && $level == 'Beginner') {
                    $mail->Body = '<style type="text/css">
                    body,
                    p,
                    div {
                        font-family: arial;
                        font-size: 14px;
                    }
                    
                    body {
                        color: #000000;
                    }
                    
                    body a {
                        color: #1188E6;
                        text-decoration: none;
                    }
        
                    p {
                        margin: 0;
                        padding: 0;
                    }
        
                    table.wrapper {
                        width: 100% !important;
                        table-layout: fixed;
                        -webkit-font-smoothing: antialiased;
                        -webkit-text-size-adjust: 100%;
                        -moz-text-size-adjust: 100%;
                        -ms-text-size-adjust: 100%;
                    }
        
                    img.max-width {
                        max-width: 100% !important;
                    }
    
                    .column.of-2 {
                        width: 50%;
                    }
        
                    .column.of-3 {
     
                        width: 33.333%;
     
                    }
              
                    .column.of-4 {      
                        width: 25%;
                    }
        

                    @media screen and (max-width:480px) {        
                        .preheader .rightColumnContent,        
                        .footer .rightColumnContent {        
                            text-align: left !important;
                        }

                        .preheader .rightColumnContent div,
                        .preheader .rightColumnContent span,
                        .footer .rightColumnContent div,
            
                        .footer .rightColumnContent span {
                            text-align: left !important;

                        }
                        .preheader .rightColumnContent,
                        .preheader .leftColumnContent {
                            font-size: 80% !important;
                            padding: 5px 0;
                        }
           
                        table.wrapper-mobile {
                            width: 100% !important;
                            table-layout: fixed;
                        }
            
                        img.max-width {
                            height: auto !important;
                            max-width: 480px !important;
                        }
           
                        a.bulletproof-button {
                            display: block !important;
                            width: auto !important;
                            font-size: 80%;
                            padding-left: 0 !important;
                            padding-right: 0 !important;
                        }
                        
                        .columns {
                            width: 100% !important;
                        }
            .column {
                display: block !important;
                width: 100% !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
        }
    </style>
    <!--user entered Head Start-->

    <!--End Head user entered-->
</head>

<body>
    <center class="wrapper" data-link-color="#1188E6" data-body-style="font-size: 14px; font-family: arial; color: #000000; background-color: #f4f4f5;">
        <div class="webkit">
            <table cellpadding="0" cellspacing="0" border="0" width="100%" class="wrapper" bgcolor="#f4f4f5">
                <tr>
                    <td valign="top" bgcolor="#f4f4f5" width="100%">
                        <table width="100%" role="content-container" class="outer" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="100%">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td>
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%; max-width:600px;" align="center">
                                                    <tr>
                                                        <td role="modules-container" style="padding: 0px 0px 0px 0px; color: #000000; text-align: left;" bgcolor="#fff" width="100%" align="left">

                                                            <table class="module preheader preheader-hide" role="module" data-type="preheader" border="0" cellpadding="0" cellspacing="0" width="100%" style="display: none !important; mso-hide: all; visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0;">
                                                                <tr>
                                                                    <td role="module-content">
                                                                        <p></p>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <table class="wrapper" role="module" data-type="image" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="font-size:6px;line-height:10px;padding:20px 0px 30px 30px;background-color:#F4F4F5;" valign="top" align="left">
                                                                        <img class="max-width" border="0" style="display:block;color:#000000;text-decoration:none;font-family:Helvetica, arial, sans-serif;font-size:16px;max-width:10% !important;width:10%;height:auto !important;" src="https://intellitech.ng/images/OFFICIAL LOGO.png" alt="" width="120">
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 18px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div><span
                                                                                style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">Hi ' . $fname . ' ' . $lname . ',</span><br
                                                                                style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;" />
                                                                            <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;" />
                                                                            <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">
                                                                                This is where it all begins! A hands-on
                                                                                introduction to all of the essential
                                                                                tools you\'ll need to build real, working
                                                                                websites. You\'ll learn what web
                                                                                developers actually do – the foundations
                                                                                you\'ll need for later courses.
                                                                            </span>
                                                                        </div>

                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 18px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div>
                                                                            <div><span style="font-size:14px;"><strong>The Front End</strong><br>
                                                                                In this section you\'ll spend a good deal
                                                                                of time getting familiar with the major
                                                                                client-side (browser-based) languages
                                                                                like HTML, CSS, and Javascript. You\'ll
                                                                                get to build a webpage with HTML/CSS and
                                                                                learn some programming fundamentals with
                                                                                Javascript.</span>
                                                                            </div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>HTML and CSS </strong><br>
                                                                                Good web design doesn\'t happen by
                                                                                accident. Learn how to make all that
                                                                                work you\'ve done on the backend look
                                                                                great in a web browser! You\'ll be
                                                                                equipped to deeply understand and create
                                                                                your own design frameworks.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>Javascript</strong><br>
                                                                                Make your websites dynamic and
                                                                                interactive with JavaScript! You\'ll
                                                                                create features and stand-alone
                                                                                applications. This course will wrap
                                                                                everything you\'ve learned at The Odin
                                                                                Project into one, final capstone
                                                                                project.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>Git Basics </strong><br>
                                                                               In this section you will learn the basics
                                                                               of Git and how you can upload your future
                                                                               projects to Github so you can share your
                                                                               work and collaborate with others on
                                                                               projects easily.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>Tying it All Together </strong><br>
                                                                               Now that you\'ve had a healthy taste of
                                                                               all the major components in a web
                                                                               application, we\'ll take a step back and
                                                                               remember where they all fit into the
                                                                               bigger picture.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>Deploying your first Web App</strong><br>
                                                                               Live, on the web, you can show people you
                                                                               know what you\'ve built and have them
                                                                               marvel at your new skills.
                                                                            </span></div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table border="0" cellPadding="0" cellSpacing="0" class="module" data-role="module-button" data-type="button" role="module" style="table-layout:fixed" width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" class="outer-td" style="padding:15px 15px 015px 15px">
                                                                            <table border="0" cellPadding="0" cellSpacing="0" class="button-css__deep-table___2OZyb wrapper-mobile" style="text-align:center">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center" bgcolor="#62bfe6" class="inner-td" style="border-radius:0px;font-size:16px;text-align:center;background-color:inherit">
                                                                                            <a style="background-color:#62bfe6;border:1px solid #333333;border-color:#62bfe6;border-radius:0px;border-width:0px;color:#ffffff;display:inline-block;font-family:arial,helvetica,sans-serif;font-size:14px;font-weight:bold;letter-spacing:0px;line-height:16px;padding:15px 18px 15px 18px;text-align:center;text-decoration:none;width:80%"
                                                                                                href="https://join.slack.com/t/intellitechng/shared_invite/zt-d1atymxg-KRRZq8vDmzJzrTsBehzbrQ" target="_blank">JOIN THE SLACK</a></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 030px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div>
                                                                            <div><br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                                <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">Sincerely,</span>
                                                                                <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                                <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">The INTELLITECH Team</span>
                                                                                <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </center>

</body>';
                } elseif ($track == 'Frontend Web Development' && $level == 'Intermediate') {
                    $mail->Body = '<style type="text/css">
        body,
        p,
        div {
            font-family: arial;
            font-size: 14px;
        }
        
        body {
            color: #000000;
        }
        
        body a {
            color: #1188E6;
            text-decoration: none;
        }
        
        p {
            margin: 0;
            padding: 0;
        }
        
        table.wrapper {
            width: 100% !important;
            table-layout: fixed;
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: 100%;
            -moz-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        
        img.max-width {
            max-width: 100% !important;
        }
        
        .column.of-2 {
            width: 50%;
        }
        
        .column.of-3 {
            width: 33.333%;
        }
        
        .column.of-4 {
            width: 25%;
        }
        
        @media screen and (max-width:480px) {
            .preheader .rightColumnContent,
            .footer .rightColumnContent {
                text-align: left !important;
            }
            .preheader .rightColumnContent div,
            .preheader .rightColumnContent span,
            .footer .rightColumnContent div,
            .footer .rightColumnContent span {
                text-align: left !important;
            }
            .preheader .rightColumnContent,
            .preheader .leftColumnContent {
                font-size: 80% !important;
                padding: 5px 0;
            }
            table.wrapper-mobile {
                width: 100% !important;
                table-layout: fixed;
            }
            img.max-width {
                height: auto !important;
                max-width: 480px !important;
            }
            a.bulletproof-button {
                display: block !important;
                width: auto !important;
                font-size: 80%;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            .columns {
                width: 100% !important;
            }
            .column {
                display: block !important;
                width: 100% !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
        }
    </style>
    <!--user entered Head Start-->

    <!--End Head user entered-->
</head>

<body>
    <center class="wrapper" data-link-color="#1188E6" data-body-style="font-size: 14px; font-family: arial; color: #000000; background-color: #f4f4f5;">
        <div class="webkit">
            <table cellpadding="0" cellspacing="0" border="0" width="100%" class="wrapper" bgcolor="#f4f4f5">
                <tr>
                    <td valign="top" bgcolor="#f4f4f5" width="100%">
                        <table width="100%" role="content-container" class="outer" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="100%">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td>
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%; max-width:600px;" align="center">
                                                    <tr>
                                                        <td role="modules-container" style="padding: 0px 0px 0px 0px; color: #000000; text-align: left;" bgcolor="#fff" width="100%" align="left">

                                                            <table class="module preheader preheader-hide" role="module" data-type="preheader" border="0" cellpadding="0" cellspacing="0" width="100%" style="display: none !important; mso-hide: all; visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0;">
                                                                <tr>
                                                                    <td role="module-content">
                                                                        <p></p>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <table class="wrapper" role="module" data-type="image" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="font-size:6px;line-height:10px;padding:20px 0px 30px 30px;background-color:#F4F4F5;" valign="top" align="left">
                                                                        <img class="max-width" border="0" style="display:block;color:#000000;text-decoration:none;font-family:Helvetica, arial, sans-serif;font-size:16px;max-width:10% !important;width:10%;height:auto !important;" src="https://intellitech.ng/images/OFFICIAL LOGO.png"
                                                                            alt="" width="120">
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 18px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div><span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">Hi ' . $fname . ' ' . $lname . ',</span><br
                                                                                style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;" />
                                                                            <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;" />
                                                                            <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">
                                                                                In this section, you\'ll learn what a
                                                                                framework is, why we use them, and get
                                                                                acquainted with the ones we\'ll be
                                                                                covering in future courses.
                                                                            </span>
                                                                        </div>

                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 18px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div>
                                                                            <div><span style="font-size:14px;"><strong>Git</strong><br>
                                                                                In this section you will learn the
                                                                                advance of Git and how you can upload
                                                                                your future projects to Github so you
                                                                                can share your work and collaborate with
                                                                                others on projects easily.</span>
                                                                            </div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>Bootstraps</strong><br>
                                                                                Good web design doesn\'t happen by
                                                                                accident. Learn how to make all that
                                                                                work you\'ve done on the backend look
                                                                                great in a web browser! You\'ll be
                                                                                equipped to deeply understand and create
                                                                                your own design frameworks.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>Javascript Framework</strong><br>
                                                                                Make your websites dynamic and
                                                                                interactive with JavaScript! You\'ll
                                                                                create features and stand-alone
                                                                                applications. This course will wrap
                                                                                everything you\'ve learned at The Odin
                                                                                Project into one, final capstone
                                                                                project.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>Tying it All Together </strong><br>
                                                                               Now that you\'ve had a healthy taste of
                                                                               all the major components in a web
                                                                               application, we\'ll take a step back and
                                                                               remember where they all fit into the
                                                                               bigger picture.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>Deploying your first Web App</strong><br>
                                                                               Live, on the web, you can show people you
                                                                               know what you\'ve built and have them
                                                                               marvel at your new skills.
                                                                            </span></div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table border="0" cellPadding="0" cellSpacing="0" class="module" data-role="module-button" data-type="button" role="module" style="table-layout:fixed" width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" class="outer-td" style="padding:15px 15px 015px 15px">
                                                                            <table border="0" cellPadding="0" cellSpacing="0" class="button-css__deep-table___2OZyb wrapper-mobile" style="text-align:center">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center" bgcolor="#62bfe6" class="inner-td" style="border-radius:0px;font-size:16px;text-align:center;background-color:inherit">
                                                                                            <a style="background-color:#62bfe6;border:1px solid #333333;border-color:#62bfe6;border-radius:0px;border-width:0px;color:#ffffff;display:inline-block;font-family:arial,helvetica,sans-serif;font-size:14px;font-weight:bold;letter-spacing:0px;line-height:16px;padding:15px 18px 15px 18px;text-align:center;text-decoration:none;width:80%"
                                                                                                href="https://join.slack.com/t/intellitechng/shared_invite/zt-d1atymxg-KRRZq8vDmzJzrTsBehzbrQ" target="_blank">JOIN THE SLACK</a></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 030px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div>
                                                                            <div><br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                                <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">Sincerely,</span>
                                                                                <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                                <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">The INTELLITECH Team</span>
                                                                                <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </center>



</body>';
                } elseif ($track == 'Frontend Web Development' && $level == 'Advanced') {
                    $mail->Body = '<style type="text/css">
        body,
        p,
        div {
            font-family: arial;
            font-size: 14px;
        }
        
        body {
            color: #000000;
        }
        
        body a {
            color: #1188E6;
            text-decoration: none;
        }
        
        p {
            margin: 0;
            padding: 0;
        }
        
        table.wrapper {
            width: 100% !important;
            table-layout: fixed;
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: 100%;
            -moz-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        
        img.max-width {
            max-width: 100% !important;
        }
        
        .column.of-2 {
            width: 50%;
        }
        
        .column.of-3 {
            width: 33.333%;
        }
        
        .column.of-4 {
            width: 25%;
        }
        
        @media screen and (max-width:480px) {
            .preheader .rightColumnContent,
            .footer .rightColumnContent {
                text-align: left !important;
            }
            .preheader .rightColumnContent div,
            .preheader .rightColumnContent span,
            .footer .rightColumnContent div,
            .footer .rightColumnContent span {
                text-align: left !important;
            }
            .preheader .rightColumnContent,
            .preheader .leftColumnContent {
                font-size: 80% !important;
                padding: 5px 0;
            }
            table.wrapper-mobile {
                width: 100% !important;
                table-layout: fixed;
            }
            img.max-width {
                height: auto !important;
                max-width: 480px !important;
            }
            a.bulletproof-button {
                display: block !important;
                width: auto !important;
                font-size: 80%;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            .columns {
                width: 100% !important;
            }
            .column {
                display: block !important;
                width: 100% !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
        }
    </style>
    <!--user entered Head Start-->

    <!--End Head user entered-->
</head>

<body>
    <center class="wrapper" data-link-color="#1188E6" data-body-style="font-size: 14px; font-family: arial; color: #000000; background-color: #f4f4f5;">
        <div class="webkit">
            <table cellpadding="0" cellspacing="0" border="0" width="100%" class="wrapper" bgcolor="#f4f4f5">
                <tr>
                    <td valign="top" bgcolor="#f4f4f5" width="100%">
                        <table width="100%" role="content-container" class="outer" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="100%">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td>
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%; max-width:600px;" align="center">
                                                    <tr>
                                                        <td role="modules-container" style="padding: 0px 0px 0px 0px; color: #000000; text-align: left;" bgcolor="#fff" width="100%" align="left">

                                                            <table class="module preheader preheader-hide" role="module" data-type="preheader" border="0" cellpadding="0" cellspacing="0" width="100%" style="display: none !important; mso-hide: all; visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0;">
                                                                <tr>
                                                                    <td role="module-content">
                                                                        <p></p>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <table class="wrapper" role="module" data-type="image" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="font-size:6px;line-height:10px;padding:20px 0px 30px 30px;background-color:#F4F4F5;" valign="top" align="left">
                                                                        <img class="max-width" border="0" style="display:block;color:#000000;text-decoration:none;font-family:Helvetica, arial, sans-serif;font-size:16px;max-width:10% !important;width:10%;height:auto !important;" src="https://intellitech.ng/images/OFFICIAL LOGO.png"
                                                                            alt="" width="120">
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 18px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div><span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">Hi ' . $fname . ' ' . $lname . ',</span><br
                                                                                style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;" />
                                                                            <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;" />
                                                                            <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">
                                                                                In this section, you\'ll build a web application with a
                                                                                framework , why we use them, and get
                                                                                acquainted with the ones we\'ll be
                                                                                covering in future.
                                                                            </span>
                                                                        </div>

                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 18px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div>
                                                                            <div><span style="font-size:14px;"><strong>Git</strong><br>
                                                                                Git is a distributed revision control
                                                                                and source code management (SCM) system
                                                                                with an emphasis on speed, data
                                                                                integrity, and support for distributed,
                                                                                non-linear workflows. Git was initially
                                                                                designed and developed by Linus Torvalds
                                                                                for Linux kernel development in 2005,
                                                                                and has since become the most widely
                                                                                adopted version control system for
                                                                                software development. Students learn out
                                                                                to use Git to store their code and
                                                                                revisions, including creating a
                                                                                repository, initializing a repository,
                                                                                and adding, committing, and
                                                                                pushing/pulling files..</span>
                                                                            </div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>Web Design and Project Planning</strong><br>
                                                                                Students will learn use the advance principles
                                                                                of design for the web. They will also
                                                                                gain a foundation in project planning by
                                                                                learning how to create user stories,
                                                                                feature lists, wireframes and using
                                                                                basic tools for building database
                                                                                diagrams. This module is spread
                                                                                throughout the course.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>Test-Driven Development</strong><br>
                                                                                Test-driven development is a software
                                                                                development process that integrates
                                                                                coding, design and testing together into
                                                                                one workflow. Students will learn the
                                                                                basics of TDD with variables and data
                                                                                types in frameworks, writing tests for
                                                                                user defined functions, learn to test
                                                                                with objects and arrays, and the basics
                                                                                of code.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>Tying it All Together </strong><br>
                                                                               Now that you\'ve had a healthy taste of
                                                                               all the major components in a web
                                                                               application, we\'ll take a step back and
                                                                               remember where they all fit into the
                                                                               bigger picture.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>Full Stack Capstone</strong><br>
                                                                               Students will work on small teams to
                                                                               construct a full stack web application
                                                                               for their final project. This web
                                                                               application will have full functionality
                                                                               and a number of key features.
                                                                            </span></div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table border="0" cellPadding="0" cellSpacing="0" class="module" data-role="module-button" data-type="button" role="module" style="table-layout:fixed" width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" class="outer-td" style="padding:15px 15px 015px 15px">
                                                                            <table border="0" cellPadding="0" cellSpacing="0" class="button-css__deep-table___2OZyb wrapper-mobile" style="text-align:center">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center" bgcolor="#62bfe6" class="inner-td" style="border-radius:0px;font-size:16px;text-align:center;background-color:inherit">
                                                                                            <a style="background-color:#62bfe6;border:1px solid #333333;border-color:#62bfe6;border-radius:0px;border-width:0px;color:#ffffff;display:inline-block;font-family:arial,helvetica,sans-serif;font-size:14px;font-weight:bold;letter-spacing:0px;line-height:16px;padding:15px 18px 15px 18px;text-align:center;text-decoration:none;width:80%"
                                                                                                href="https://join.slack.com/t/intellitechng/shared_invite/zt-d1atymxg-KRRZq8vDmzJzrTsBehzbrQ" target="_blank">JOIN THE SLACK</a></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 030px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div>
                                                                            <div><br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                                <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">Sincerely,</span>
                                                                                <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                                <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">The INTELLITECH Team</span>
                                                                                <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </center>



</body>';
                } elseif ($track == 'Backend Web Development' && $level == 'Beginner') {
                    $mail->Body = '<style type="text/css">
        body,
        p,
        div {
            font-family: arial;
            font-size: 14px;
        }
        
        body {
            color: #000000;
        }
        
        body a {
            color: #1188E6;
            text-decoration: none;
        }
        
        p {
            margin: 0;
            padding: 0;
        }
        
        table.wrapper {
            width: 100% !important;
            table-layout: fixed;
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: 100%;
            -moz-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        
        img.max-width {
            max-width: 100% !important;
        }
        
        .column.of-2 {
            width: 50%;
        }
        
        .column.of-3 {
            width: 33.333%;
        }
        
        .column.of-4 {
            width: 25%;
        }
        
        @media screen and (max-width:480px) {
            .preheader .rightColumnContent,
            .footer .rightColumnContent {
                text-align: left !important;
            }
            .preheader .rightColumnContent div,
            .preheader .rightColumnContent span,
            .footer .rightColumnContent div,
            .footer .rightColumnContent span {
                text-align: left !important;
            }
            .preheader .rightColumnContent,
            .preheader .leftColumnContent {
                font-size: 80% !important;
                padding: 5px 0;
            }
            table.wrapper-mobile {
                width: 100% !important;
                table-layout: fixed;
            }
            img.max-width {
                height: auto !important;
                max-width: 480px !important;
            }
            a.bulletproof-button {
                display: block !important;
                width: auto !important;
                font-size: 80%;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            .columns {
                width: 100% !important;
            }
            .column {
                display: block !important;
                width: 100% !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
        }
    </style>
    <!--user entered Head Start-->

    <!--End Head user entered-->
</head>

<body>
    <center class="wrapper" data-link-color="#1188E6" data-body-style="font-size: 14px; font-family: arial; color: #000000; background-color: #f4f4f5;">
        <div class="webkit">
            <table cellpadding="0" cellspacing="0" border="0" width="100%" class="wrapper" bgcolor="#f4f4f5">
                <tr>
                    <td valign="top" bgcolor="#f4f4f5" width="100%">
                        <table width="100%" role="content-container" class="outer" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="100%">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td>
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%; max-width:600px;" align="center">
                                                    <tr>
                                                        <td role="modules-container" style="padding: 0px 0px 0px 0px; color: #000000; text-align: left;" bgcolor="#fff" width="100%" align="left">

                                                            <table class="module preheader preheader-hide" role="module" data-type="preheader" border="0" cellpadding="0" cellspacing="0" width="100%" style="display: none !important; mso-hide: all; visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0;">
                                                                <tr>
                                                                    <td role="module-content">
                                                                        <p></p>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <table class="wrapper" role="module" data-type="image" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="font-size:6px;line-height:10px;padding:20px 0px 30px 30px;background-color:#F4F4F5;" valign="top" align="left">
                                                                        <img class="max-width" border="0" style="display:block;color:#000000;text-decoration:none;font-family:Helvetica, arial, sans-serif;font-size:16px;max-width:10% !important;width:10%;height:auto !important;" src="https://intellitech.ng/images/OFFICIAL LOGO.png"
                                                                            alt="" width="120">
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 18px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div><span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">Hi ' . $fname . ' ' . $lname . ',</span><br
                                                                                style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;" />
                                                                            <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;" />
                                                                            <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">
                                                                                In this section, you\'ll Learn about how
                                                                                a computer uses logic, syntax, and data
                                                                                and how you too can use them to do
                                                                                amazing things.
                                                                            </span>
                                                                        </div>

                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 18px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div>
                                                                            <div><span style="font-size:14px;"><strong>Html and Bootstrap</strong><br>
                                                                                Good web design doesn\'t happen by
                                                                                accident. Learn how to make all that
                                                                                work you\'ve done on the backend look
                                                                                great in a web browser! You\'ll be
                                                                                equipped to deeply understand and create
                                                                                your own design using frameworks.</span>
                                                                            </div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>Javascript </strong><br>
                                                                                Make your websites dynamic and
                                                                                interactive with JavaScript! You\'ll
                                                                                create features and stand-alone
                                                                                applications. This course will wrap
                                                                                everything you\'ve learned at The Odin
                                                                                Project into one, final capstone
                                                                                project.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>Git</strong><br>
                                                                                In this section you will learn the
                                                                                basics of Git and how you can upload
                                                                                your future projects to GitHub so you
                                                                                can share your work and collaborate with
                                                                                others on projects easily.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>PHP</strong><br>
                                                                               Students will learn to program using php,
                                                                               a programming language designed as a
                                                                               general¬-purpose programming language and
                                                                               also used for web development. Php
                                                                               includes free libraries with the core
                                                                               build. Php is an Internet-¬aware system
                                                                               with modules built in for accessing File
                                                                               Transfer Protocol (FTP) servers, many
                                                                               database servers, embedded SQL libraries
                                                                               such as embedded PostgreSQL, MySQL,
                                                                               Microsoft SQL and SQLite, LDAP servers,
                                                                               and others.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>MySQL</strong><br>
                                                                               Students will learn to use MySQL or its
                                                                               equivalent, a relational database
                                                                               management system and ships with no GUI
                                                                               tools to administer. MySQL databases or
                                                                               manage data contained within the
                                                                               databases and is a central component of
                                                                               most web development software stacks.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>Tying it All Together </strong><br>
                                                                               Now that you\'ve had a healthy taste of
                                                                               all the major components in a web
                                                                               application, we\'ll take a step back and
                                                                               remember where they all fit into the
                                                                               bigger picture.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>Deploying your first Web App</strong><br>
                                                                               Live, on the web, you can show people you
                                                                               know what you\'ve built and have them
                                                                               marvel at your new skills.
                                                                            </span></div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table border="0" cellPadding="0" cellSpacing="0" class="module" data-role="module-button" data-type="button" role="module" style="table-layout:fixed" width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" class="outer-td" style="padding:15px 15px 015px 15px">
                                                                            <table border="0" cellPadding="0" cellSpacing="0" class="button-css__deep-table___2OZyb wrapper-mobile" style="text-align:center">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center" bgcolor="#62bfe6" class="inner-td" style="border-radius:0px;font-size:16px;text-align:center;background-color:inherit">
                                                                                            <a style="background-color:#62bfe6;border:1px solid #333333;border-color:#62bfe6;border-radius:0px;border-width:0px;color:#ffffff;display:inline-block;font-family:arial,helvetica,sans-serif;font-size:14px;font-weight:bold;letter-spacing:0px;line-height:16px;padding:15px 18px 15px 18px;text-align:center;text-decoration:none;width:80%"
                                                                                                href="https://join.slack.com/t/intellitechng/shared_invite/zt-d1atymxg-KRRZq8vDmzJzrTsBehzbrQ" target="_blank">JOIN THE SLACK</a></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 030px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div>
                                                                            <div><br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                                <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">Sincerely,</span>
                                                                                <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                                <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">The INTELLITECH Team</span>
                                                                                <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </center>



</body>

</html>';
                } elseif ($track == 'Backend Web Development' && $level == 'Intermediate') {
                    $mail->Body = '<style type="text/css">
        body,
        p,
        div {
            font-family: arial;
            font-size: 14px;
        }
        
        body {
            color: #000000;
        }
        
        body a {
            color: #1188E6;
            text-decoration: none;
        }
        
        p {
            margin: 0;
            padding: 0;
        }
        
        table.wrapper {
            width: 100% !important;
            table-layout: fixed;
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: 100%;
            -moz-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        
        img.max-width {
            max-width: 100% !important;
        }
        
        .column.of-2 {
            width: 50%;
        }
        
        .column.of-3 {
            width: 33.333%;
        }
        
        .column.of-4 {
            width: 25%;
        }
        
        @media screen and (max-width:480px) {
            .preheader .rightColumnContent,
            .footer .rightColumnContent {
                text-align: left !important;
            }
            .preheader .rightColumnContent div,
            .preheader .rightColumnContent span,
            .footer .rightColumnContent div,
            .footer .rightColumnContent span {
                text-align: left !important;
            }
            .preheader .rightColumnContent,
            .preheader .leftColumnContent {
                font-size: 80% !important;
                padding: 5px 0;
            }
            table.wrapper-mobile {
                width: 100% !important;
                table-layout: fixed;
            }
            img.max-width {
                height: auto !important;
                max-width: 480px !important;
            }
            a.bulletproof-button {
                display: block !important;
                width: auto !important;
                font-size: 80%;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            .columns {
                width: 100% !important;
            }
            .column {
                display: block !important;
                width: 100% !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
        }
    </style>
    <!--user entered Head Start-->

    <!--End Head user entered-->
</head>

<body>
    <center class="wrapper" data-link-color="#1188E6" data-body-style="font-size: 14px; font-family: arial; color: #000000; background-color: #f4f4f5;">
        <div class="webkit">
            <table cellpadding="0" cellspacing="0" border="0" width="100%" class="wrapper" bgcolor="#f4f4f5">
                <tr>
                    <td valign="top" bgcolor="#f4f4f5" width="100%">
                        <table width="100%" role="content-container" class="outer" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="100%">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td>
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%; max-width:600px;" align="center">
                                                    <tr>
                                                        <td role="modules-container" style="padding: 0px 0px 0px 0px; color: #000000; text-align: left;" bgcolor="#fff" width="100%" align="left">

                                                            <table class="module preheader preheader-hide" role="module" data-type="preheader" border="0" cellpadding="0" cellspacing="0" width="100%" style="display: none !important; mso-hide: all; visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0;">
                                                                <tr>
                                                                    <td role="module-content">
                                                                        <p></p>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <table class="wrapper" role="module" data-type="image" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="font-size:6px;line-height:10px;padding:20px 0px 30px 30px;background-color:#F4F4F5;" valign="top" align="left">
                                                                        <img class="max-width" border="0" style="display:block;color:#000000;text-decoration:none;font-family:Helvetica, arial, sans-serif;font-size:16px;max-width:10% !important;width:10%;height:auto !important;" src="https://intellitech.ng/images/OFFICIAL LOGO.png"
                                                                            alt="" width="120">
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 18px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div><span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">Hi ' . $fname . ' ' . $lname . ',</span><br
                                                                                style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;" />
                                                                            <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;" />
                                                                            <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">
                                                                                In this section, you\'ll Learn about how
                                                                                a computer uses logic, syntax, and data
                                                                                and how you too can use them to do
                                                                                amazing things.
                                                                            </span>
                                                                        </div>

                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 18px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div>

                                                                            <div><span style="font-size:14px;"><strong>Git</strong><br>
                                                                                In this section you will learn the
                                                                                basics of Git and how you can upload
                                                                                your future projects to GitHub so you
                                                                                can share your work and collaborate with
                                                                                others on projects easily.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>PHP</strong><br>
                                                                               Students will learn to program using php,
                                                                               a programming language designed as a
                                                                               general¬-purpose programming language and
                                                                               also used for web development. Php
                                                                               includes free libraries with the core
                                                                               build. Php is an Internet-¬aware system
                                                                               with modules built in for accessing File
                                                                               Transfer Protocol (FTP) servers, many
                                                                               database servers, embedded SQL libraries
                                                                               such as embedded PostgreSQL, MySQL,
                                                                               Microsoft SQL and SQLite, LDAP servers,
                                                                               and others.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>Object-oriented Programming (OOP) with Php</strong><br>
                                                                               Utilizing the powerful and yet
                                                                               easy-to-learn php programming language,
                                                                               you will learn the principles of working
                                                                               with data and the techniques that
                                                                               professional developers use to structure
                                                                               their applications.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>MySQL</strong><br>
                                                                               Students will learn to use MySQL or its
                                                                               equivalent, a relational database
                                                                               management system and ships with no GUI
                                                                               tools to administer. MySQL databases or
                                                                               manage data contained within the
                                                                               databases and is a central component of
                                                                               most web development software stacks.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>Tying it All Together </strong><br>
                                                                               Now that you\'ve had a healthy taste of
                                                                               all the major components in a web
                                                                               application, we\'ll take a step back and
                                                                               remember where they all fit into the
                                                                               bigger picture.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>Deploying your first Web App</strong><br>
                                                                               Live, on the web, you can show people you
                                                                               know what you\'ve built and have them
                                                                               marvel at your new skills.
                                                                            </span></div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table border="0" cellPadding="0" cellSpacing="0" class="module" data-role="module-button" data-type="button" role="module" style="table-layout:fixed" width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" class="outer-td" style="padding:15px 15px 015px 15px">
                                                                            <table border="0" cellPadding="0" cellSpacing="0" class="button-css__deep-table___2OZyb wrapper-mobile" style="text-align:center">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center" bgcolor="#62bfe6" class="inner-td" style="border-radius:0px;font-size:16px;text-align:center;background-color:inherit">
                                                                                            <a style="background-color:#62bfe6;border:1px solid #333333;border-color:#62bfe6;border-radius:0px;border-width:0px;color:#ffffff;display:inline-block;font-family:arial,helvetica,sans-serif;font-size:14px;font-weight:bold;letter-spacing:0px;line-height:16px;padding:15px 18px 15px 18px;text-align:center;text-decoration:none;width:80%"
                                                                                                href="https://join.slack.com/t/intellitechng/shared_invite/zt-d1atymxg-KRRZq8vDmzJzrTsBehzbrQ" target="_blank">JOIN THE SLACK</a></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 030px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div>
                                                                            <div><br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                                <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">Sincerely,</span>
                                                                                <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                                <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">The INTELLITECH Team</span>
                                                                                <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </center>



</body>

</html>';
                } elseif ($track == 'Backend Web Development' && $level == 'Advanced') {
                    $mail ->Body = '<style type="text/css">
        body,
        p,
        div {
            font-family: arial;
            font-size: 14px;
        }
        
        body {
            color: #000000;
        }
        
        body a {
            color: #1188E6;
            text-decoration: none;
        }
        
        p {
            margin: 0;
            padding: 0;
        }
        
        table.wrapper {
            width: 100% !important;
            table-layout: fixed;
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: 100%;
            -moz-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        
        img.max-width {
            max-width: 100% !important;
        }
        
        .column.of-2 {
            width: 50%;
        }
        
        .column.of-3 {
            width: 33.333%;
        }
        
        .column.of-4 {
            width: 25%;
        }
        
        @media screen and (max-width:480px) {
            .preheader .rightColumnContent,
            .footer .rightColumnContent {
                text-align: left !important;
            }
            .preheader .rightColumnContent div,
            .preheader .rightColumnContent span,
            .footer .rightColumnContent div,
            .footer .rightColumnContent span {
                text-align: left !important;
            }
            .preheader .rightColumnContent,
            .preheader .leftColumnContent {
                font-size: 80% !important;
                padding: 5px 0;
            }
            table.wrapper-mobile {
                width: 100% !important;
                table-layout: fixed;
            }
            img.max-width {
                height: auto !important;
                max-width: 480px !important;
            }
            a.bulletproof-button {
                display: block !important;
                width: auto !important;
                font-size: 80%;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            .columns {
                width: 100% !important;
            }
            .column {
                display: block !important;
                width: 100% !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
        }
    </style>
    <!--user entered Head Start-->

    <!--End Head user entered-->
</head>

<body>
    <center class="wrapper" data-link-color="#1188E6" data-body-style="font-size: 14px; font-family: arial; color: #000000; background-color: #f4f4f5;">
        <div class="webkit">
            <table cellpadding="0" cellspacing="0" border="0" width="100%" class="wrapper" bgcolor="#f4f4f5">
                <tr>
                    <td valign="top" bgcolor="#f4f4f5" width="100%">
                        <table width="100%" role="content-container" class="outer" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="100%">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td>
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%; max-width:600px;" align="center">
                                                    <tr>
                                                        <td role="modules-container" style="padding: 0px 0px 0px 0px; color: #000000; text-align: left;" bgcolor="#fff" width="100%" align="left">

                                                            <table class="module preheader preheader-hide" role="module" data-type="preheader" border="0" cellpadding="0" cellspacing="0" width="100%" style="display: none !important; mso-hide: all; visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0;">
                                                                <tr>
                                                                    <td role="module-content">
                                                                        <p></p>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <table class="wrapper" role="module" data-type="image" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="font-size:6px;line-height:10px;padding:20px 0px 30px 30px;background-color:#F4F4F5;" valign="top" align="left">
                                                                        <img class="max-width" border="0" style="display:block;color:#000000;text-decoration:none;font-family:Helvetica, arial, sans-serif;font-size:16px;max-width:10% !important;width:10%;height:auto !important;" src="https://intellitech.ng/images/OFFICIAL LOGO.png"
                                                                            alt="" width="120">
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 18px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div><span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">Hi ' . $fname . ' ' . $lname . ',</span><br
                                                                                style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;" />
                                                                            <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;" />
                                                                            <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">
                                                                                In this section, you\'ll build a web
                                                                                application with a
                                                                                framework , why we use them, and get
                                                                                acquainted with the ones we\'ll be
                                                                                covering in future.
                                                                            </span>
                                                                        </div>

                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 18px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div>

                                                                            <div><span style="font-size:14px;"><strong>Git</strong><br>
                                                                                In this section you will learn the
                                                                                advance of Git and how you can upload
                                                                                your future projects to GitHub so you
                                                                                can share your work and collaborate with
                                                                                others on projects easily.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>Web Design and Project Planning</strong><br>
                                                                               Students will learn the basic principles
                                                                               of design for the web. They will also
                                                                               gain a foundation in project planning by
                                                                               learning how to create user stories,
                                                                               feature lists, wireframes and using basic
                                                                               tools for building database diagrams.
                                                                               This module is spread throughout the
                                                                               course.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>Test-Driven Development</strong><br>
                                                                               Test-driven development is a software
                                                                               development process that integrates
                                                                               coding, design and testing together into
                                                                               one workflow. Students will learn the
                                                                               basics of TDD with variables and data
                                                                               types in JavaScript, writing tests for
                                                                               user defined functions, learn to test
                                                                               with objects and arrays, and the basics
                                                                               of testing code.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>


                                                                            <div><span style="font-size:14px;"><strong>Tying it All Together </strong><br>
                                                                               Now that you\'ve had a healthy taste of
                                                                               all the major components in a web
                                                                               application, we\'ll take a step back and
                                                                               remember where they all fit into the
                                                                               bigger picture.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>Full Stack Capstone</strong><br>
                                                                               Students will work on small teams to
                                                                               construct a full stack web application
                                                                               for their final project. This web
                                                                               application will have full functionality
                                                                               and a number of key features.
                                                                            </span></div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table border="0" cellPadding="0" cellSpacing="0" class="module" data-role="module-button" data-type="button" role="module" style="table-layout:fixed" width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" class="outer-td" style="padding:15px 15px 015px 15px">
                                                                            <table border="0" cellPadding="0" cellSpacing="0" class="button-css__deep-table___2OZyb wrapper-mobile" style="text-align:center">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center" bgcolor="#62bfe6" class="inner-td" style="border-radius:0px;font-size:16px;text-align:center;background-color:inherit">
                                                                                            <a style="background-color:#62bfe6;border:1px solid #333333;border-color:#62bfe6;border-radius:0px;border-width:0px;color:#ffffff;display:inline-block;font-family:arial,helvetica,sans-serif;font-size:14px;font-weight:bold;letter-spacing:0px;line-height:16px;padding:15px 18px 15px 18px;text-align:center;text-decoration:none;width:80%"
                                                                                                href="https://join.slack.com/t/intellitechng/shared_invite/zt-d1atymxg-KRRZq8vDmzJzrTsBehzbrQ" target="_blank">JOIN THE SLACK</a></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 030px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div>
                                                                            <div><br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                                <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">Sincerely,</span>
                                                                                <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                                <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">The INTELLITECH Team</span>
                                                                                <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </center>



</body>

</html>';
                } elseif ($track == 'Mobile App Development') {
                    $mail->Body    = '<style type="text/css">
        body,
        p,
        div {
            font-family: arial;
            font-size: 14px;
        }
        
        body {
            color: #000000;
        }
        
        body a {
            color: #1188E6;
            text-decoration: none;
        }
        
        p {
            margin: 0;
            padding: 0;
        }
        
        table.wrapper {
            width: 100% !important;
            table-layout: fixed;
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: 100%;
            -moz-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        
        img.max-width {
            max-width: 100% !important;
        }
        
        .column.of-2 {
            width: 50%;
        }
        
        .column.of-3 {
            width: 33.333%;
        }
        
        .column.of-4 {
            width: 25%;
        }
        
        @media screen and (max-width:480px) {
            .preheader .rightColumnContent,
            .footer .rightColumnContent {
                text-align: left !important;
            }
            .preheader .rightColumnContent div,
            .preheader .rightColumnContent span,
            .footer .rightColumnContent div,
            .footer .rightColumnContent span {
                text-align: left !important;
            }
            .preheader .rightColumnContent,
            .preheader .leftColumnContent {
                font-size: 80% !important;
                padding: 5px 0;
            }
            table.wrapper-mobile {
                width: 100% !important;
                table-layout: fixed;
            }
            img.max-width {
                height: auto !important;
                max-width: 480px !important;
            }
            a.bulletproof-button {
                display: block !important;
                width: auto !important;
                font-size: 80%;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            .columns {
                width: 100% !important;
            }
            .column {
                display: block !important;
                width: 100% !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
        }
    </style>
    <!--user entered Head Start-->

    <!--End Head user entered-->
</head>

<body>
    <center class="wrapper" data-link-color="#1188E6" data-body-style="font-size: 14px; font-family: arial; color: #000000; background-color: #f4f4f5;">
        <div class="webkit">
            <table cellpadding="0" cellspacing="0" border="0" width="100%" class="wrapper" bgcolor="#f4f4f5">
                <tr>
                    <td valign="top" bgcolor="#f4f4f5" width="100%">
                        <table width="100%" role="content-container" class="outer" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="100%">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td>
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%; max-width:600px;" align="center">
                                                    <tr>
                                                        <td role="modules-container" style="padding: 0px 0px 0px 0px; color: #000000; text-align: left;" bgcolor="#fff" width="100%" align="left">

                                                            <table class="module preheader preheader-hide" role="module" data-type="preheader" border="0" cellpadding="0" cellspacing="0" width="100%" style="display: none !important; mso-hide: all; visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0;">
                                                                <tr>
                                                                    <td role="module-content">
                                                                        <p></p>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <table class="wrapper" role="module" data-type="image" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="font-size:6px;line-height:10px;padding:20px 0px 30px 30px;background-color:#F4F4F5;" valign="top" align="left">
                                                                        <img class="max-width" border="0" style="display:block;color:#000000;text-decoration:none;font-family:Helvetica, arial, sans-serif;font-size:16px;max-width:10% !important;width:10%;height:auto !important;" src="https://intellitech.ng/images/OFFICIAL LOGO.png"
                                                                            alt="" width="120">
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 18px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div><span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">Hi ' . $fname . ' ' . $lname . ',</span><br
                                                                                style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;" />
                                                                            <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;" />
                                                                            <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">
                                                                                Mobile app development can be both
                                                                                profitable and fun. In this beginner
                                                                                introductory course, you will learn to
                                                                                create and deploy an app to a physical
                                                                                device. You learn how to setup
                                                                                development environments for both
                                                                                Android and Apple Apps.

                                                                                <ul>
                                                                                    <li>Setting up development environment for Android using Android Studio</li>
                                                                                    <li>Setting up development environment for Apple using Xcode</li>
                                                                                    <li>Create new projects in Android Studio</li>
                                                                                    <li>Design App</li>
                                                                                    <li>Create variables</li>
                                                                                    <li>Create array</li>
                                                                                    <li>Code the app logic</li>
                                                                                    <li>Test app on virtual devices</li>
                                                                                    <li>Deploy app to a real device</li>
                                                                                </ul>
                                                                            </span> Knowing how to write code is simply the beginning of building an app. The best result comes
                                                                            from writing and practicing clean code and documentation. This is how you can organize your practice session:
                                                                        </div>

                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 18px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div>

                                                                            <div><span style="font-size:14px;"><strong>Develop an App Idea</strong><br>
                                                                                Start by developing an app idea. Find
                                                                                out the problems that people are facing
                                                                                in daily life. List them out, and
                                                                                shortlist the one that makes the most
                                                                                sense. And once you have decided, start
                                                                                mapping out your app.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>Lay Out the Details of the App</strong><br>
                                                                               Another important thing while developing
                                                                               a protocol is to make sure that your app
                                                                               is easy to understand. Users should be
                                                                               able to figure the navigation without any
                                                                               reference to other pages. Besides, you
                                                                               need to figure out the features of the
                                                                               app as well. It’s crucial that you build
                                                                               an excellent user interface if you want
                                                                               your users to stick around.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>Collaborate or Hire the People You Need</strong><br>
                                                                               When you are starting, it may not be
                                                                               possible for you to develop the complete
                                                                               app all by yourself. For instance, you
                                                                               may be good at coding but may lack the
                                                                               design skills. It’s better to take help
                                                                               from someone who is already an expert in
                                                                               the field.
                                                                               <div>&nbsp;</div>
                                                                               You can either hire an expert or
                                                                               collaborate with people that agree to
                                                                               help you.

                                                                            </span></div>

                                                                            <div>&nbsp;</div>


                                                                            <div><span style="font-size:14px;"><strong>Test Your App</strong><br>
                                                                               Once you have completed developing the
                                                                               app, you need to go to the testing part.
                                                                               Bugs are unavoidable in first cut of any
                                                                               software.
                                                                               <div>&nbsp;</div>
                                                                               You can have your friends download the
                                                                               app and let them play through it. If they
                                                                               notice any glitches, they can communicate
                                                                               the same to you. The feedback will help
                                                                               you learn what works and what doesn’t in
                                                                               an app.

                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>Convert to Other Platforms</strong><br>
                                                                               So once you have mastered a single
                                                                               platform, it’s time to try your hand at
                                                                               other areas as well. Otherwise, you will
                                                                               miss out on customers if you don’t. Each
                                                                               platform has its own set of features and
                                                                               you will have to modify your app
                                                                               accordingly.
                                                                            </span></div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table border="0" cellPadding="0" cellSpacing="0" class="module" data-role="module-button" data-type="button" role="module" style="table-layout:fixed" width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" class="outer-td" style="padding:15px 15px 015px 15px">
                                                                            <table border="0" cellPadding="0" cellSpacing="0" class="button-css__deep-table___2OZyb wrapper-mobile" style="text-align:center">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center" bgcolor="#62bfe6" class="inner-td" style="border-radius:0px;font-size:16px;text-align:center;background-color:inherit">
                                                                                            <a style="background-color:#62bfe6;border:1px solid #333333;border-color:#62bfe6;border-radius:0px;border-width:0px;color:#ffffff;display:inline-block;font-family:arial,helvetica,sans-serif;font-size:14px;font-weight:bold;letter-spacing:0px;line-height:16px;padding:15px 18px 15px 18px;text-align:center;text-decoration:none;width:80%"
                                                                                                href="https://join.slack.com/t/intellitechng/shared_invite/zt-d1atymxg-KRRZq8vDmzJzrTsBehzbrQ" target="_blank">JOIN THE SLACK</a></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 030px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div>
                                                                            <div><br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                                <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">Sincerely,</span>
                                                                                <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                                <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">The INTELLITECH Team</span>
                                                                                <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </center>



</body>';
                } elseif ($track == 'Digital Marketing') {
                    $mail->Body = '<style type="text/css">
        body,
        p,
        div {
            font-family: arial;
            font-size: 14px;
        }
        
        body {
            color: #000000;
        }
        
        body a {
            color: #1188E6;
            text-decoration: none;
        }
        
        p {
            margin: 0;
            padding: 0;
        }
        
        table.wrapper {
            width: 100% !important;
            table-layout: fixed;
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: 100%;
            -moz-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        
        img.max-width {
            max-width: 100% !important;
        }
        
        .column.of-2 {
            width: 50%;
        }
        
        .column.of-3 {
            width: 33.333%;
        }
        
        .column.of-4 {
            width: 25%;
        }
        
        @media screen and (max-width:480px) {
            .preheader .rightColumnContent,
            .footer .rightColumnContent {
                text-align: left !important;
            }
            .preheader .rightColumnContent div,
            .preheader .rightColumnContent span,
            .footer .rightColumnContent div,
            .footer .rightColumnContent span {
                text-align: left !important;
            }
            .preheader .rightColumnContent,
            .preheader .leftColumnContent {
                font-size: 80% !important;
                padding: 5px 0;
            }
            table.wrapper-mobile {
                width: 100% !important;
                table-layout: fixed;
            }
            img.max-width {
                height: auto !important;
                max-width: 480px !important;
            }
            a.bulletproof-button {
                display: block !important;
                width: auto !important;
                font-size: 80%;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            .columns {
                width: 100% !important;
            }
            .column {
                display: block !important;
                width: 100% !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
        }
    </style>
    <!--user entered Head Start-->

    <!--End Head user entered-->
</head>

<body>
    <center class="wrapper" data-link-color="#1188E6" data-body-style="font-size: 14px; font-family: arial; color: #000000; background-color: #f4f4f5;">
        <div class="webkit">
            <table cellpadding="0" cellspacing="0" border="0" width="100%" class="wrapper" bgcolor="#f4f4f5">
                <tr>
                    <td valign="top" bgcolor="#f4f4f5" width="100%">
                        <table width="100%" role="content-container" class="outer" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="100%">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td>
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%; max-width:600px;" align="center">
                                                    <tr>
                                                        <td role="modules-container" style="padding: 0px 0px 0px 0px; color: #000000; text-align: left;" bgcolor="#fff" width="100%" align="left">

                                                            <table class="module preheader preheader-hide" role="module" data-type="preheader" border="0" cellpadding="0" cellspacing="0" width="100%" style="display: none !important; mso-hide: all; visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0;">
                                                                <tr>
                                                                    <td role="module-content">
                                                                        <p></p>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <table class="wrapper" role="module" data-type="image" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="font-size:6px;line-height:10px;padding:20px 0px 30px 30px;background-color:#F4F4F5;" valign="top" align="left">
                                                                        <img class="max-width" border="0" style="display:block;color:#000000;text-decoration:none;font-family:Helvetica, arial, sans-serif;font-size:16px;max-width:10% !important;width:10%;height:auto !important;" src="https://intellitech.ng/images/OFFICIAL LOGO.png"
                                                                            alt="" width="120">
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 18px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div><span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">Hi ' . $fname . ' ' . $lname . ',</span><br
                                                                                style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;" />
                                                                            <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;" />
                                                                            <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">
                                                                                In this section you will learn complete
                                                                                digital marketing and everything you
                                                                                need to become a digital marketing
                                                                                expert.
                                                                            </span>
                                                                        </div>
                                                                        <div>&nbsp;</div>
                                                                        With the skills acquire in our digital marketing, you can:
                                                                        <ul>
                                                                            <li>GROW your own business</li>
                                                                            <li>LAND a job in this hot marketing industry</li>
                                                                            <li>HELP a client increase their business
                                                                        </ul>
                                                                        We want to help you grow your business with social media marketing, content marketing, email marketing, and more!
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 18px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div>
                                                                            We promise to do everything we can to help you with all of these digital marketing & social media marketing strategies:

                                                                            <ol>
                                                                                <li>BRANDING</li>
                                                                                <li>WEBSITES</li>
                                                                                <li>EMAIL MARKETING</li>
                                                                                <li>BLOGGING</li>
                                                                                <li>COPYWRITING</li>
                                                                                <li>SEO (Search Engine Optimization)</li>
                                                                                <li>YOUTUBE</li>
                                                                                <li>VIDEO MARKETING </li>
                                                                                <li>FACEBOOK PAGES</li>
                                                                                <li>FACEBOOK GROUPS</li>
                                                                                <li>FACEBOOK ADS</li>
                                                                                <li>FACEBOOK FOR LOCAL BUSINESSES </li>
                                                                                <li>GOOGLE ADS</li>
                                                                                <li>GOOGLE ANALYTICS </li>
                                                                                <li>TWITTER</li>
                                                                                <li>INSTAGRAM</li>
                                                                                <li>GOOGLE PLUS</li>
                                                                                <li>PINTEREST</li>
                                                                                <li>LINKEDIN</li>
                                                                                <li>PERISCOPE</li>
                                                                                <li>LIVE-STREAMING ON SOCIAL MEDIA</li>
                                                                                <li>PODCASTING</li>
                                                                                <li>QUORA</li>
                                                                            </ol>
                                                                            <div><span style="font-size:14px;"><strong>GET READY TO TAKE ACTION</strong><br>
                                                                                Throughout the entire lecture, you\'ll be
                                                                                taking action!
                                                                                <div>&nbsp;</div>
                                                                                You\'ll learn the proper techniques and
                                                                                strategies for each section. Then you\'ll
                                                                                see how these strategies are used in the
                                                                                real world with case studies. Finally,
                                                                                you\'ll take action yourself, and see
                                                                                real results!

                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>NOW IS THE TIME TO START USING DIGITAL MARKETING & SOCIAL MEDIA MARKETING TO GROW YOUR BUSINESS!</strong><br>
                                                                               Whether you\'re completely brand new to
                                                                               all of these topics, or you use a few of
                                                                               them, now is the perfect time to take
                                                                               action.
                                                                               <div>&nbsp;</div>
                                                                               Join now so that you can take advantage
                                                                               of the skills you learn to grow your
                                                                               business!

                                                                            </span></div>


                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table border="0" cellPadding="0" cellSpacing="0" class="module" data-role="module-button" data-type="button" role="module" style="table-layout:fixed" width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" class="outer-td" style="padding:15px 15px 015px 15px">
                                                                            <table border="0" cellPadding="0" cellSpacing="0" class="button-css__deep-table___2OZyb wrapper-mobile" style="text-align:center">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center" bgcolor="#62bfe6" class="inner-td" style="border-radius:0px;font-size:16px;text-align:center;background-color:inherit">
                                                                                            <a style="background-color:#62bfe6;border:1px solid #333333;border-color:#62bfe6;border-radius:0px;border-width:0px;color:#ffffff;display:inline-block;font-family:arial,helvetica,sans-serif;font-size:14px;font-weight:bold;letter-spacing:0px;line-height:16px;padding:15px 18px 15px 18px;text-align:center;text-decoration:none;width:80%"
                                                                                                href="https://join.slack.com/t/intellitechng/shared_invite/zt-d1atymxg-KRRZq8vDmzJzrTsBehzbrQ" target="_blank">JOIN THE SLACK</a></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 030px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div>
                                                                            <div><br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                                <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">Sincerely,</span>
                                                                                <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                                <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">The INTELLITECH Team</span>
                                                                                <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </center>



</body>';
                } elseif ($track == 'UI/UX Design') {
                    $mail ->Body = '<style type="text/css">
        body,
        p,
        div {
            font-family: arial;
            font-size: 14px;
        }
        
        body {
            color: #000000;
        }
        
        body a {
            color: #1188E6;
            text-decoration: none;
        }
        
        p {
            margin: 0;
            padding: 0;
        }
        
        table.wrapper {
            width: 100% !important;
            table-layout: fixed;
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: 100%;
            -moz-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        
        img.max-width {
            max-width: 100% !important;
        }
        
        .column.of-2 {
            width: 50%;
        }
        
        .column.of-3 {
            width: 33.333%;
        }
        
        .column.of-4 {
            width: 25%;
        }
        
        @media screen and (max-width:480px) {
            .preheader .rightColumnContent,
            .footer .rightColumnContent {
                text-align: left !important;
            }
            .preheader .rightColumnContent div,
            .preheader .rightColumnContent span,
            .footer .rightColumnContent div,
            .footer .rightColumnContent span {
                text-align: left !important;
            }
            .preheader .rightColumnContent,
            .preheader .leftColumnContent {
                font-size: 80% !important;
                padding: 5px 0;
            }
            table.wrapper-mobile {
                width: 100% !important;
                table-layout: fixed;
            }
            img.max-width {
                height: auto !important;
                max-width: 480px !important;
            }
            a.bulletproof-button {
                display: block !important;
                width: auto !important;
                font-size: 80%;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            .columns {
                width: 100% !important;
            }
            .column {
                display: block !important;
                width: 100% !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
        }
    </style>
    <!--user entered Head Start-->

    <!--End Head user entered-->
</head>

<body>
    <center class="wrapper" data-link-color="#1188E6" data-body-style="font-size: 14px; font-family: arial; color: #000000; background-color: #f4f4f5;">
        <div class="webkit">
            <table cellpadding="0" cellspacing="0" border="0" width="100%" class="wrapper" bgcolor="#f4f4f5">
                <tr>
                    <td valign="top" bgcolor="#f4f4f5" width="100%">
                        <table width="100%" role="content-container" class="outer" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="100%">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td>
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%; max-width:600px;" align="center">
                                                    <tr>
                                                        <td role="modules-container" style="padding: 0px 0px 0px 0px; color: #000000; text-align: left;" bgcolor="#fff" width="100%" align="left">

                                                            <table class="module preheader preheader-hide" role="module" data-type="preheader" border="0" cellpadding="0" cellspacing="0" width="100%" style="display: none !important; mso-hide: all; visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0;">
                                                                <tr>
                                                                    <td role="module-content">
                                                                        <p></p>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <table class="wrapper" role="module" data-type="image" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="font-size:6px;line-height:10px;padding:20px 0px 30px 30px;background-color:#F4F4F5;" valign="top" align="left">
                                                                        <img class="max-width" border="0" style="display:block;color:#000000;text-decoration:none;font-family:Helvetica, arial, sans-serif;font-size:16px;max-width:10% !important;width:10%;height:auto !important;" src="https://intellitech.ng/images/OFFICIAL LOGO.png"
                                                                            alt="" width="120">
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 18px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div><span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">Hi ' . $fname . ' ' . $lname . ',</span><br
                                                                                style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;" />
                                                                            <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;" />
                                                                            <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">
                                                                                User experience (UX) refers to any
                                                                                interaction a user has with a product or
                                                                                service. UX design considers all the
                                                                                different elements that shape this
                                                                                experience, and how they make the user
                                                                                feel. Be it an easy-to-navigate website
                                                                                or an ergonomic kettle, UX design can
                                                                                make or break the success of a business
                                                                                or brand.
                                                                            </span>
                                                                        </div>

                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 18px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div>

                                                                            <div><span style="font-size:14px;"><strong>An Introduction To UX And Design Thinking</strong><br>
                                                                                Learn how to describe the UX design and
                                                                                design thinking processes. Apply the
                                                                                first stage of the design thinking
                                                                                process to a real-world problem and
                                                                                start thinking like a UX designer.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>How To Conduct Effective User Research</strong><br>
                                                                               Discover user-centered design and
                                                                               strategies for conducting effective user
                                                                               research. Compare and evaluate research
                                                                               methods for different design scenarios.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>How To Build User Personas</strong><br>
                                                                               Learn the processes for creating
                                                                               effective, meaningful user personas and
                                                                               user stories based on user\'s goals and
                                                                               needs.

                                                                            </span></div>

                                                                            <div>&nbsp;</div>


                                                                            <div><span style="font-size:14px;"><strong>How To Analyze Information Architecture</strong><br>
                                                                               Analyze how users navigate a site and the
                                                                               theory and best practices behind how
                                                                               information is best structured for a
                                                                               user\'s consumption.

                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>How To Make Wireframes And Prototypes</strong><br>
                                                                               Learn how to turn your theoretical
                                                                               knowledge into something tangible and
                                                                               usable by creating effective prototypes
                                                                               and wireframes that support user goals.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>How To Do Usability Testing</strong><br>
                                                                               Learn how usability testing should be
                                                                               carried out and how to draft a testing
                                                                               plan for your product.
                                                                            </span></div>
                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>How To Present Your Work</strong><br>
                                                                               Present your design process and solution
                                                                               to stakeholders in a clear, engaging, and
                                                                               convincing manner, substantiating the
                                                                               decisions you\'ve made every step of the
                                                                               way.
                                                                            </span></div>

                                                                            <div>&nbsp;</div>

                                                                            <div><span style="font-size:14px;"><strong>A Career In UX Design?</strong><br>
                                                                               Draft a personal design profile to map
                                                                               out a path for your continuing design
                                                                               education and decide whether you would
                                                                               like to pursue a creative, rewarding
                                                                               career in UX.
                                                                            </span></div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table border="0" cellPadding="0" cellSpacing="0" class="module" data-role="module-button" data-type="button" role="module" style="table-layout:fixed" width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" class="outer-td" style="padding:15px 15px 015px 15px">
                                                                            <table border="0" cellPadding="0" cellSpacing="0" class="button-css__deep-table___2OZyb wrapper-mobile" style="text-align:center">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center" bgcolor="#62bfe6" class="inner-td" style="border-radius:0px;font-size:16px;text-align:center;background-color:inherit">
                                                                                            <a style="background-color:#62bfe6;border:1px solid #333333;border-color:#62bfe6;border-radius:0px;border-width:0px;color:#ffffff;display:inline-block;font-family:arial,helvetica,sans-serif;font-size:14px;font-weight:bold;letter-spacing:0px;line-height:16px;padding:15px 18px 15px 18px;text-align:center;text-decoration:none;width:80%"
                                                                                                href="https://join.slack.com/t/intellitechng/shared_invite/zt-d1atymxg-KRRZq8vDmzJzrTsBehzbrQ" target="_blank">JOIN THE SLACK</a></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                                                                <tr>
                                                                    <td style="padding:18px 30px 030px 30px;line-height:22px;text-align:inherit;" height="100%" valign="top" bgcolor="">
                                                                        <div>
                                                                            <div><br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                                <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">Sincerely,</span>
                                                                                <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                                <span style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">The INTELLITECH Team</span>
                                                                                <br style="color: rgb(20, 28, 38); font-family: &quot;Open Sans&quot;, Helvetica;">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </center>



</body>

</html>';
                }

                $confirmSend = 'UPDATE intern SET `send` = 1';
                $sendConfirm = mysqli_query($conn, $confirmSend);

                if (!$mail->send()) {
                    $_SESSION['ErrorMessage'] = "Refuse to Sends";
                } else {
                    $_SESSION['SuccessMessage'] = "Successfully Send";
                }

            } 

        }

    }
}