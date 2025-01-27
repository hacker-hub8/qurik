<?php
include "core.php";
head();
?>
            <center><h6>Please provide the following information. Don’t worry, you can modify & change these settings later.</h6></center><hr />
			<?php
			echo '<div class="alert alert-danger">update <b>Username & Password</b> After Installation.</div>';
			?>
			<form method="post" action="" class="form-horizontal row-border">

<div class="form-group row">
	<p class="col-sm-3">Username: </p>
	<div class="col-sm-8">
		<div class="input-group">
			<div class="input-group-text">
				<i class="fas fa-user"></i>
			</div>
			<!-- Static text instead of editable input -->
			<input type="text" name="username" class="form-control" value="admin" readonly>
		</div>
	</div>
</div>

<div class="form-group row">
	<p class="col-sm-3">Password: </p>
	<div class="col-sm-8">
		<div class="input-group">
			<div class="input-group-text">
				<i class="fas fa-key"></i>
			</div>
			<!-- Static text instead of editable input -->
			<input type="text" name="password" class="form-control" value="admin" readonly>
		</div>
	</div>
</div>

<?php
if (isset($_POST['submit'])) {
	$username = "admin"; // Static username
	$password = "admin"; // Static password
	
	echo '<meta http-equiv="refresh" content="0; url=done.php" />';
}
?>

<br />
<div class="row">
	<div class="col-md-6">
		<a href="index.php" class="btn-secondary btn col-12"><i class="fas fa-arrow-left"></i> Back</a>
	</div>
	<div class="col-md-6">
		<input class="btn-primary btn col-12" type="submit" name="submit" value="Next" />
	</div>
</div>
<br />
</form>

				</div>
<?php
footer();
?>