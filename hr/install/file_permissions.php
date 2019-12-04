<?php
$error = false;
if (!is_writable('../application/config/config.php')){
    $error = true;
    $requirement14 = "<span class='label label-danger'>No (Make application/config.php writable) - Permissions 755 or 777</span>";
} else {
    $requirement14 = "<span class='label label-success'>Ok</span>";
}
if (!is_writable('../application/config/database.php')){
    $error = true;
    $requirement15 = "<span class='label label-danger'>No (Make application/database.php writable) - Permissions - 755 or 777</span>";
} else {
    $requirement15 = "<span class='label label-success'>Ok</span>";
}


?>
<h3>Files/Folders Permissiions</h3>
<table class="table table-hover">
    <thead>
        <tr>
            <th><b>File/Folder</b></th>
            <th><b>Result</b></th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>config.php Writable</td>
            <td><?php echo $requirement14; ?></td>
        </tr>
        <tr>
            <td>database.php Writable</td>
            <td><?php echo $requirement15; ?></td>
        </tr>

    </tbody>
</table>
<hr />
<?php if ($error == true){
    echo '<div class="text-center alert alert-danger">You need to fix the requirements in order to install</div>';
} else {
    echo '<div class="text-center">';
	?>
	<form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
	<input type="hidden" name="permissions_success" value="true">
	<button type="submit" class="btn btn-primary btn-block btn-flat">Next Step</button>
	</form>
	</div>
	<?php
}
?>