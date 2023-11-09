<?php
include "./dbconnection.php";
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
	$username = $_SESSION['username'];
	$password = $_SESSION['password'];
	$query = "SELECT admin_full_name, admin_pic FROM admins WHERE admin_username = :username AND admin_password = :password";
	$stmt = $conn->prepare($query);
	$stmt->bindParam(':username', $username, PDO::PARAM_STR);
	$stmt->bindParam(':password', $password, PDO::PARAM_STR);

	if ($stmt->execute()) {
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if ($data) {
			foreach ($data as $row) {
				$name = $row['admin_full_name'];
				$pic = $row['admin_pic'];
				$img = base64_encode($pic);
			}
		}
	}
}
//////////////////////////////////////////////////////////////////////////////////////
$categories = $conn->query("SELECT * from categories");
//////////////////////////////////////////////////////////////////////////////
$id = urldecode($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM drink_menu WHERE drink_name = :drink_name");
$stmt->bindParam(':drink_name', $id, PDO::PARAM_STR);
$stmt->execute();
$drink = $stmt->fetchAll();
foreach ($drink as $row) {
	$category_name = $row['category_name'];
	$drink_name = $row['drink_name'];
	$drink_img = $row['drink_img'];
	$drink_description = $row['drink_description'];
	$drink_price = $row['drink_price'];
}
//////////////////////////////////////////////////////////////////////////////
$msg = '';
if (isset($_POST['update'])) {
	if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
		$d_img = file_get_contents($_FILES['image']['tmp_name']);
	} else {
		$d_img = $row['drink_img'];
	}

	$c_name = $_POST['category'];
	$d_name = $_POST['title'];
	$d_description = $_POST['description'];
	$d_price = $_POST['price'];

	$sql = "UPDATE drink_menu
            SET category_name = :c_name, drink_name = :d_name, drink_img = :d_img, drink_description = :d_description, drink_price = :d_price
            WHERE drink_name = :id";
	$q = $conn->prepare($sql);

	// Bind parameters
	$q->bindParam(':c_name', $c_name);
	$q->bindParam(':d_name', $d_name);
	$q->bindParam(':d_img', $d_img, PDO::PARAM_LOB);
	$q->bindParam(':d_description', $d_description);
	$q->bindParam(':d_price', $d_price);
	$q->bindParam(':id', $id);

	// Execute the query
	$q->execute();

	$msg = "<h4>Drink Updated Successfully</h4>";
	header("Refresh:3;URL=beverages.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Wave Cafe Admin | Edit Beverage</title>

	<!-- Bootstrap -->
	<link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- NProgress -->
	<link href="vendors/nprogress/nprogress.css" rel="stylesheet">
	<!-- iCheck -->
	<link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	<!-- bootstrap-wysiwyg -->
	<link href="vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
	<!-- Select2 -->
	<link href="vendors/select2/dist/css/select2.min.css" rel="stylesheet">
	<!-- Switchery -->
	<link href="vendors/switchery/dist/switchery.min.css" rel="stylesheet">
	<!-- starrr -->
	<link href="vendors/starrr/dist/starrr.css" rel="stylesheet">
	<!-- bootstrap-daterangepicker -->
	<link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

	<!-- Custom Theme Style -->
	<link href="build/css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			<div class="col-md-3 left_col">
				<div class="left_col scroll-view">
					<div class="navbar nav_title" style="border: 0;">
						<a href="editBeverage.php" class="site_title"><i class="fa fa-user"></i> <span>Wave Cafe
								Admin</span></a>
					</div>

					<div class="clearfix"></div>

					<!-- menu profile quick info -->
					<div class="profile clearfix">
						<div class="profile_pic">
							<img src="data:image/png;charset=utf8;base64,<?php echo $img ?>" alt="..."
								class="img-circle profile_img">
						</div>
						<div class="profile_info">
							<span>Welcome,</span>
							<h2>
								<?php echo $name ?>
							</h2>
						</div>
					</div>
					<!-- /menu profile quick info -->

					<br />

					<!-- sidebar menu -->
					<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
						<div class="menu_section">
							<h3>General</h3>
							<ul class="nav side-menu">
								<li><a><i class="fa fa-users"></i> Users <span class="fa fa-chevron-down"></span></a>
									<ul class="nav child_menu">
										<li><a href="users.php">Users List</a></li>
										<li><a href="addUser.php">Add User</a></li>
									</ul>
								</li>
								<li><a><i class="fa fa-edit"></i> Categories <span
											class="fa fa-chevron-down"></span></a>
									<ul class="nav child_menu">
										<li><a href="categories.php">Categories List</a></li>
										<li><a href="addCategory.php">Add Category</a></li>
									</ul>
								</li>
								<li><a><i class="fa fa-desktop"></i> Beverages <span
											class="fa fa-chevron-down"></span></a>
									<ul class="nav child_menu">
										<li><a href="beverages.php">Beverages List</a></li>
										<li><a href="addBeverage.php">Add Beverage</a></li>
									</ul>
								</li>
							</ul>
						</div>

					</div>
					<!-- /sidebar menu -->

					<!-- /menu footer buttons -->
					<div class="sidebar-footer hidden-small">
						<a data-toggle="tooltip" data-placement="top" title="Settings">
							<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
						</a>
						<a data-toggle="tooltip" data-placement="top" title="FullScreen">
							<span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
						</a>
						<a data-toggle="tooltip" data-placement="top" title="Lock">
							<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
						</a>
						<a data-toggle="tooltip" data-placement="top" title="Logout" href="logout.php">
							<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
						</a>
					</div>
					<!-- /menu footer buttons -->
				</div>
			</div>

			<!-- top navigation -->
			<div class="top_nav">
				<div class="nav_menu">
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"></i></a>
					</div>
					<nav class="nav navbar-nav">
						<ul class=" navbar-right">
							<li class="nav-item dropdown open" style="padding-left: 15px;">
								<a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true"
									id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
									<img src="data:image/png;charset=utf8;base64,<?php echo $img ?>" alt="">
									<?php echo $name ?>
								</a>
								<div class="dropdown-menu dropdown-usermenu pull-right"
									aria-labelledby="navbarDropdown">
									<a class="dropdown-item" href="javascript:;"> Profile</a>
									<a class="dropdown-item" href="javascript:;">
										<span class="badge bg-red pull-right">50%</span>
										<span>Settings</span>
									</a>
									<a class="dropdown-item" href="javascript:;">Help</a>
									<a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out pull-right"></i>
										Log Out</a>
								</div>
							</li>

							<li role="presentation" class="nav-item dropdown open">
								<a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1"
									data-toggle="dropdown" aria-expanded="false">
									<i class="fa fa-envelope-o"></i>
									<span class="badge bg-green">6</span>
								</a>
								<ul class="dropdown-menu list-unstyled msg_list" role="menu"
									aria-labelledby="navbarDropdown1">
									<li class="nav-item">
										<a class="dropdown-item">
											<span class="image"><img
													src="data:image/png;charset=utf8;base64,<?php echo $img ?>"
													alt="Profile Image" /></span>
											<span>
												<span>
													<?php echo $name ?>
												</span>
												<span class="time">3 mins ago</span>
											</span>
											<span class="message">
												Film festivals used to be do-or-die moments for movie makers. They were
												where...
											</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="dropdown-item">
											<span class="image"><img
													src="data:image/png;charset=utf8;base64,<?php echo $img ?>"
													alt="Profile Image" /></span>
											<span>
												<span>
													<?php echo $name ?>
												</span>
												<span class="time">3 mins ago</span>
											</span>
											<span class="message">
												Film festivals used to be do-or-die moments for movie makers. They were
												where...
											</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="dropdown-item">
											<span class="image"><img
													src="data:image/png;charset=utf8;base64,<?php echo $img ?>"
													alt="Profile Image" /></span>
											<span>
												<span>
													<?php echo $name ?>
												</span>
												<span class="time">3 mins ago</span>
											</span>
											<span class="message">
												Film festivals used to be do-or-die moments for movie makers. They were
												where...
											</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="dropdown-item">
											<span class="image"><img
													src="data:image/png;charset=utf8;base64,<?php echo $img ?>"
													alt="Profile Image" /></span>
											<span>
												<span>
													<?php echo $name ?>
												</span>
												<span class="time">3 mins ago</span>
											</span>
											<span class="message">
												Film festivals used to be do-or-die moments for movie makers. They were
												where...
											</span>
										</a>
									</li>
									<li class="nav-item">
										<div class="text-center">
											<a class="dropdown-item">
												<strong>See All Alerts</strong>
												<i class="fa fa-angle-right"></i>
											</a>
										</div>
									</li>
								</ul>
							</li>
						</ul>
					</nav>
				</div>
			</div>
			<!-- /top navigation -->

			<!-- page content -->
			<div class="right_col" role="main">
				<div class="">
					<div class="page-title">
						<div class="title_left">
							<h3>Manage Beverages</h3>
						</div>

						<div class="title_right">
							<div class="col-md-5 col-sm-5  form-group pull-right top_search">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Search for...">
									<span class="input-group-btn">
										<button class="btn btn-default" type="button">Go!</button>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 ">
							<div class="x_panel">
								<div class="x_title">
									<h2>Edit Beverage</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
										</li>
										<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
												aria-haspopup="true" aria-expanded="false"><i
													class="fa fa-wrench"></i></a>
											<ul class="dropdown-menu" role="menu">
												<li><a class="dropdown-item" href="#">Settings 1</a>
												</li>
												<li><a class="dropdown-item" href="#">Settings 2</a>
												</li>
											</ul>
										</li>
										<li><a class="close-link"><i class="fa fa-close"></i></a>
										</li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<br />
									<div style='color:green'>
										<?php echo $msg; ?>
									</div>
									<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"
										action="<?php '_PHP_SELF'; ?>" method="post" enctype="multipart/form-data">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align"
												for="title">Title <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="title" required="required" class="form-control"
													value="<?php echo $drink_name; ?>" name="title">
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align"
												for="content">Description <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<textarea id="content" name="description" required="required"
													class="form-control"><?php echo $drink_description; ?></textarea>
											</div>
										</div>
										<div class="item form-group">
											<label for="price"
												class="col-form-label col-md-3 col-sm-3 label-align">Price <span
													class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<input id="price" class="form-control" type="number" name="price"
													required="required" value="<?php echo $drink_price; ?>">
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align"
												for="image">Image <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<!-- <input type="hidden" name="image" value="<?php echo $drink_img; ?>"> -->
												<input type="file" id="image" name="image" class="form-control"
													accept="image/*">
											</div>
										</div>

										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align"
												for="title">Category <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<select class="form-control" name="category" id="">
													<option value="" <?php echo ($category_name == '') ? 'selected' : ''; ?>>Select Category</option>
													<?php foreach ($categories as $category) {
														$selected = ($category['category_name'] == $category_name) ? 'selected' : '';
														echo " <option value='{$category['category_name']}' $selected>{$category['category_name']}</option>";
													}
													?>
												</select>

											</div>
										</div>
										<div class="ln_solid">
										</div>
										<div class="item form-group">
											<div class="col-md-6 col-sm-6 offset-md-3">
												<a href="beverages.php" class="btn btn-primary">Cancel</a>
												<button type="submit" class="btn btn-success"
													name="update">Update</button>
											</div>
										</div>

									</form>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
			<!-- /page content -->

			<!-- footer content -->
			<footer>
				<div class="pull-right">
					© Wave Cafe 2023
				</div>
				<div class="clearfix"></div>
			</footer>
			<!-- /footer content -->
		</div>
	</div>

	<!-- jQuery -->
	<script src="vendors/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<!-- FastClick -->
	<script src="vendors/fastclick/lib/fastclick.js"></script>
	<!-- NProgress -->
	<script src="vendors/nprogress/nprogress.js"></script>
	<!-- bootstrap-progressbar -->
	<script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
	<!-- iCheck -->
	<script src="vendors/iCheck/icheck.min.js"></script>
	<!-- bootstrap-daterangepicker -->
	<script src="vendors/moment/min/moment.min.js"></script>
	<script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
	<!-- bootstrap-wysiwyg -->
	<script src="vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
	<script src="vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
	<script src="vendors/google-code-prettify/src/prettify.js"></script>
	<!-- jQuery Tags Input -->
	<script src="vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
	<!-- Switchery -->
	<script src="vendors/switchery/dist/switchery.min.js"></script>
	<!-- Select2 -->
	<script src="vendors/select2/dist/js/select2.full.min.js"></script>
	<!-- Parsley -->
	<script src="vendors/parsleyjs/dist/parsley.min.js"></script>
	<!-- Autosize -->
	<script src="vendors/autosize/dist/autosize.min.js"></script>
	<!-- jQuery autocomplete -->
	<script src="vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
	<!-- starrr -->
	<script src="vendors/starrr/dist/starrr.js"></script>
	<!-- Custom Theme Scripts -->
	<script src="build/js/custom.min.js"></script>

</body>

</html>