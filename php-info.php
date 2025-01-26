<?php
require "core.php";
head();

session_name("WebsiteID");
?>
<div class="content-wrapper" style="background-color:rgb(0, 0, 0); color:rgb(0, 0, 0);">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div class="content-header">
				
				<div class="container-fluid">
				  <div class="row mb-2">
        		    <div class="col-sm-6">
        		      <h1 class="m-0 "><i class="fab fa-php"></i>Your Server PHP Information</h1>
        		    </div>
        		    <div class="col-sm-6">
        		      <ol class="breadcrumb float-sm-right">
        		        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
        		        <li class="breadcrumb-item active">PHP Information</li>
        		      </ol>
        		    </div>
        		  </div>
    			</div>
            </div>

				<!--Page content-->
				<!--===================================================-->
				<div class="content">
				<div class="container-fluid">

                <div class="row">
				<div class="col-md-12">
				
				<div class="card card-primary card-outline">
						<div class="card-header" data-card-widget="collapse">
							<h3 class="card-title">PHP Information</h3>
							<div class="card-tools">
                			 
                            </div>
						</div>
						<div class="card-body">
						    <div class="table table-bordered table-responsive table-hover">
<?php
ob_start();
phpinfo();
$pinfo = ob_get_contents();
ob_end_clean();

$pinfo = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $pinfo);
echo $pinfo;
?>
                            </div>
						</div>
			    </div>
<?php
footer();
?>