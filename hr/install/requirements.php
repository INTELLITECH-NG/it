<?php
$error = false;
if (phpversion() < "5.4") {
	$error = true;
	$requirement1 = "<span class='label label-warning'>Your PHP version is " . phpversion() . "</span>";
} else {
	$requirement1 = "<span class='label label-success'>v." . phpversion() . "</span>";
}

if (!extension_loaded('mysqli')) {
	$error = true;
	$requirement3 = "<span class='label label-danger'>Not enabled</span>";
} else {
	$requirement3 = "<span class='label label-success'>Enabled</span>";
}

if (!extension_loaded('mcrypt')) {
	$error = true;
	$requirement4 = "<span class='label label-danger'>Not enabled</span>";
} else {
	$requirement4 = "<span class='label label-success'>Enabled</span>";
}


if (!extension_loaded('mbstring')) {
	$error = true;
	$requirement5 = "<span class='label label-danger'>Not enabled</span>";
} else {
	$requirement5 = "<span class='label label-success'>Enabled</span>";
}

if (!extension_loaded('gd')) {
	$error = true;
	$requirement6 = "<span class='label label-danger'>Not enabled</span>";
} else {
	$requirement6 = "<span class='label label-success'>Enabled</span>";
}

if (!extension_loaded('pdo')) {
	$error = true;
	$requirement7 = "<span class='label label-danger'>Not enabled</span>";
} else {
	$requirement7 = "<span class='label label-success'>Enabled</span>";
}

if (!extension_loaded('curl')) {
	$error = true;
	$requirement8 = "<span class='label label-warning'>Not enabled</span>";
} else {
	$requirement8 = "<span class='label label-success'>Enabled</span>";
}

if (!extension_loaded('zip')) {
    $error = true;
    $requirement9 = "<span class='label label-warning'>Not enabled</span>";
} else {
    $requirement9 = "<span class='label label-success'>Enabled</span>";
}

if (ini_get('allow_url_fopen') != "1") {
	$error = true;
	$requirement10 = "<span class='label label-danger'>Allow_url_fopen is not enabled!</span>";
} else {
	$requirement10 = "<span class='label label-success'>Enabled</span>";
}



?>
<h3>Pre-Install Checklist</h3>
<table class="table table-hover">
	<thead>
		<tr>
			<th><b>Extensions</b></th>
			<th><b>Result</b></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>PHP 5.4+ </td>
			<td><?php echo $requirement1; ?></td>
		</tr>
		<tr>
			<td>MySQLi PHP Extension</td>
			<td><?php echo $requirement3; ?></td>
		</tr>
		<tr>
			<td>Mcrypt PHP Extension</td>
			<td><?php echo $requirement4; ?></td>
		</tr>
		<tr>
			<td>MBString PHP Extension</td>
			<td><?php echo $requirement5; ?></td>
		</tr>
		<tr>
			<td>GD PHP Extension</td>
			<td><?php echo $requirement6; ?></td>
		</tr>
		<tr>
			<td>PDO PHP Extension</td>
			<td><?php echo $requirement7; ?></td>
		</tr>
		<tr>
			<td>CURL PHP Extension</td>
			<td><?php echo $requirement8; ?></td>
		</tr>

        <tr>
            <td>ZIP File Enable</td>
            <td><?php echo $requirement9; ?></td>
        </tr>

		<tr>
			<td>Allow allow_url_fopen</td>
			<td><?php echo $requirement10; ?></td>
		</tr>
	</tbody>
</table>
<hr />
<?php if ($error == true){
	echo '<div class="text-center alert alert-danger">You need to fix the requirements in order to continue installing</div>';
} else {
	
	echo '<div class="text-center">';
	?>
	<form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
	<input type="hidden" name="requirements_success" value="true">
	<button type="submit" class="btn btn-primary btn-block btn-flat">Next Step</button>
	</form>

	</div>
	<?php 
}
?>
