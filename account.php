<?php
require "core.php";
head();

$sec_username = $_SESSION['sec-username'];
?>
<div class="content-wrapper" style="background-color:rgb(0, 0, 0); color:rgb(0, 0, 0);">

    <!--CONTENT CONTAINER-->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-user"></i> Account</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
                        <li class="breadcrumb-item active">Account</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!--Page content-->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <form class="form-horizontal" action="" method="post">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Account</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="control-label"><i class="fas fa-user"></i> Username: </label>
                                    <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($sec_username); ?>" required>
                                </div>
                                <hr />
                                <div class="form-group">
                                    <label class="control-label"><i class="fas fa-key"></i> New Password: </label>
                                    <input type="text" name="password" class="form-control">
                                </div>
                                <i>Fill this field only if you want to change the password.</i>
                            </div>
                            <div class="card-footer row">
                                <div class="col-md-8">
                                    <button class="btn btn-block btn-flat btn-success" name="edit" type="submit"><i class="fas fa-save"></i> Save</button>
                                </div>
                                <div class="col-md-4">
                                    <button type="reset" class="btn btn-block btn-flat btn-default"><i class="fas fa-undo"></i> Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php
                    if (isset($_POST['edit'])) {
                        // Sanitize user input
                        $username = addslashes($_POST['username']);
                        $password = $_POST['password'];

                        // Update the database
                        require_once 'config.php'; // Ensure database connection is included
                        
                        if ($password != null) {
                            // Hash the password if it is provided
                            $hashed_password = hash('sha256', $password);

                            // Update both username and password
                            $stmt = $mysqli->prepare("UPDATE qurik_admin SET username = ?, password = ? WHERE username = ?");
                            $stmt->bind_param("sss", $username, $hashed_password, $sec_username);
                        } else {
                            // Update only the username
                            $stmt = $mysqli->prepare("UPDATE qurik_admin SET username = ? WHERE username = ?");
                            $stmt->bind_param("ss", $username, $sec_username);
                        }

						if ($stmt->execute()) {
							// Update the session variable
							$_SESSION['sec-username'] = $username;
							echo '<div class="alert alert-success" id="success-message">Updated successfully.</div>';
							echo '
								<script>
									// Wait for 2 seconds, then refresh the page
									setTimeout(function() {
										window.location.href = "account.php";
									}, 2000);
								</script>
							';
						} else {
							echo '<div class="alert alert-danger">Failed to update account. Please try again.</div>';
						}
						

                        $stmt->close();
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
    <!--END CONTENT CONTAINER-->
</div>
<?php
footer();
?>
