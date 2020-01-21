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
                                                                                    <th style="color: #949698; font-weight: normal; font-weight: 400; padding-bottom: 12px;">Track</th>
                                                                                    <td style="padding-bottom: 12px;">' . $track . '</td>
                                                                                </tr>
                                                                                <tr style="text-align: left;">
                                                                                    <th style="color: #949698;  font-weight: normal; font-weight: 400; padding-bottom: 12px;">Level</th>
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
            echo "<script>alert('Your First Name cannot be less than {$min} words')</script>";
        } else {
            
            if (strlen($firstname) > $max) {
                echo "<script>alert('Your First Name cannot be more than {$max} word')</script>";
            } else {
                
                if (strlen($lastname) < $min) {
                    echo "<script>alert('Your Last Name cannot be less than {$min} words')</script>";
                } else {
                    
                    if (strlen($lastname) > $max) {
                        echo "<script>alert('Your Last Name cannot be more than {$max} words')</script>";
                    } else {
                        
                        if (Email_exist_intern($email_intern)) {
                            echo "<script>alert('This Email Address has already been Registered')</script>";
                        } else {
                            
                            if ($firstname == "" || empty($firstname) && $lastname == "" || empty($lastname) && $track == "" || empty($track) && $level == "" || empty($level) && $email_intern == "" || empty($email_intern)) {
                                echo "<script>alert('All Fields Must be Filled')</script>";
                            } else {

                                $Query = "INSERT INTO intern(firstname, lastname, track, level, date, email)
                                VALUE('$firstname', '$lastname', '$track', '$level', '$date', '$email_intern')";
            
                                $intern_reg = mysqli_query($conn, $Query);

                                require 'PHPMailerAutoload.php';

                                $mail = new PHPMailer;

                                $mail->SMTPDebug = 1;                               // Enable verbose debug output

                                $mail->isSMTP();                                      // Set mailer to use SMTP
                                $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                                $mail->Username = 'configureall@gmail.com';                 // SMTP username
                                $mail->Password = 'Kingofpop@50';                           // SMTP password
                                $mail->SMTPSecure = 'tls';
                                $mail->Mailer = "smtp";                            // Enable TLS encryption, `ssl` also accepted
                                $mail->Port = 587;                                    // TCP port to connect to

                                $mail->setFrom('no-reply@intellitech.ng', 'INTELLITECH');
                                $mail->addAddress($email_intern, $firstname . '' . $lastname);     // Add a recipient
                                //$mail->addAddress('ellen@example.com');               // Name is optional
                                //$mail->addReplyTo('info@example.com', 'Information');
                                //$mail->addCC('cc@example.com');
                                //$mail->addBCC('bcc@example.com');

                                //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
                                $mail->isHTML(true);                                  // Set email format to HTML

                                $mail->Subject = 'INTERNSHIP';
                                $mail->Body    = $forward;
                                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                                if (!$mail->send()) {
                                    echo "<script>alert('Registration Declined')</script>";
                                } else {
                                    echo "<script>alert('Registration Successfully')</script>";
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
    $query = "SELECT * FROM intern ORDER BY date";
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
        require('MailUtility.php');
        $mail = new MailUtility();
        $to = explode(',', $_POST['recipients']);
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $result = $mail->sendMail($to, $subject, $message);
        if ($result) {
            $_SESSION['SuccessMessage'] = "Mail Sent";
            redirect("email");
        } else {
            $_SESSION['ErrorMessage'] = "Failed to send mail";
            redirect("email");
        }
    }
}