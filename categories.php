<?php
	ob_start();
	/*
	==========================================
	== Category Page
	==========================================
	*/
	session_start();

	$pageTitle = 'Categories';

	if (isset($_SESSION['Username'])) {

		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
/*♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡-Start-Manage-♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡*/
		if ($do == 'Manage') {

			$sort = 'ASC';
			$order = 'ID';
			$sort_array = array('ASC', 'DESC');
			$order_array = array('ID', 'Name', 'Description', 'Ordering', 'Visibility', 'Allow_Comment', 'Allow_Ads');

			if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {

				$sort = $_GET['sort'];
			}
			if (isset($_GET['order']) && in_array($_GET['order'], $order_array)) {

				$order = $_GET['order'];
			}

			$stmt2 = $con->prepare("SELECT * FROM categories ORDER BY $order $sort");
			$stmt2->execute();
			$cats = $stmt2->fetchAll();
?>
			<h1 class="text-center">Manage Categories</h1>
			<div class="container categories">
				<div class="panel panel-default">
					<div class="panel-heading">
						Manage Categories
						<div class="ordering pull-right">
							ID:
							<a class="<?php if ($sort == 'ASC' && $order == 'ID') echo "active"; ?>" href="?sort=ASC&order=ID">⇑</a>
							<a class="<?php if ($sort == 'DESC' && $order == 'ID') echo "active"; ?>" href="?sort=DESC&order=ID">⇓</a> |
							Name:
							<a class="<?php if ($sort == 'ASC' && $order == 'Name') echo "active"; ?>" href="?sort=ASC&order=Name">⇑</a>
							<a class="<?php if ($sort == 'DESC' && $order == 'Name') echo "active"; ?>" href="?sort=DESC&order=Name">⇓</a> |
							Description:
							<a class="<?php if ($sort == 'ASC' && $order == 'Description') echo "active"; ?>" href="?sort=ASC&order=Description">⇑</a>
							<a class="<?php if ($sort == 'DESC' && $order == 'Description') echo "active"; ?>" href="?sort=DESC&order=Description">⇓</a> |
							Ordering:
							<a class="<?php if ($sort == 'ASC' && $order == 'Ordering') echo "active"; ?>" href="?sort=ASC&order=Ordering">⇑</a>
							<a class="<?php if ($sort == 'DESC' && $order == 'Ordering') echo "active"; ?>" href="?sort=DESC&order=Ordering">⇓</a> |
							Visibility:
							<a class="<?php if ($sort == 'ASC' && $order == 'Visibility') echo "active"; ?>" href="?sort=ASC&order=Visibility">⇑</a>
							<a class="<?php if ($sort == 'DESC' && $order == 'Visibility') echo "active"; ?>" href="?sort=DESC&order=Visibility">⇓</a> |
							Comment:
							<a class="<?php if ($sort == 'ASC' && $order == 'Allow_Comment') echo "active"; ?>" href="?sort=ASC&order=Allow_Comment">⇑</a>
							<a class="<?php if ($sort == 'DESC' && $order == 'Allow_Comment') echo "active"; ?>" href="?sort=DESC&order=Allow_Comment">⇓</a> |
							Ads:
							<a class="<?php if ($sort == 'ASC' && $order == 'Allow_Ads') echo "active"; ?>" href="?sort=ASC&order=Allow_Ads">⇑</a>
							<a class="<?php if ($sort == 'DESC' && $order == 'Allow_Ads') echo "active"; ?>" href="?sort=DESC&order=Allow_Ads">⇓</a>
						</div>
					</div>
					<div class="panel-body">
<?php
						foreach ($cats as $cat) {
							echo "<div class='cat'>";
								echo "<div class='hidden-buttons'>";
									echo "<a href='#' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
									echo "<a href='#' class='btn btn-xs btn-danger'><i class='fa fa-close'></i> Delete</a>";
								echo "</div>";
								echo '<h3>' . $cat['Name'] . '</h3>';
								echo '<p>'; if ($cat['Description'] == '') { echo 'This Category Has No Description'; } else { echo $cat['Description']; } echo '</p>';
								if ($cat['Visibility'] == 1) 	{ echo '<span class="equalone visibility">Hidden</span>'; }
								if ($cat['Allow_Comment'] == 1) { echo '<span class="equalone commenting">Comment Disabled</span>'; }
								if ($cat['Allow_Ads'] == 1) 	{ echo '<span class="equalone advertises">Ads Disabled</span>'; }
							echo "</div>";
							echo "<hr>";
						}
?>
					</div>
				</div>
			</div>
<?php
/*♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡-End-Manage-♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡*/
/*♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡-Start-Add-♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡*/
		} elseif ($do == 'Add') {
?>
			<h1 class="text-center">Add New Category</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Insert" method="POST">
					<!-- Start Name Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Name Of The Category" />
						</div>
					</div>
					<!-- End Name Field -->
					<!-- Start Description Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="description" class="form-control" placeholder="Describe The Category"/>
						</div>
					</div>
					<!-- End Description Field -->
					<!-- Start Ordering Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Ordering</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="ordering" class="form-control" placeholder="Number To Arrange The Categories" />
						</div>
					</div>
					<!-- End Ordering Field -->
					<!-- Start Visibility Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Visible</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="vis-yes" type="radio" name="Visibility" value="0" checked />
								<label for="vis-yes">Yes</label>
							</div>
							<div>
								<input id="vis-no" type="radio" name="Visibility" value="1" />
								<label for="vis-no">No</label>
							</div>
						</div>
					</div>
					<!-- End Visibility Field -->
					<!-- Start Commenting Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Allow Commenting</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="com-yes" type="radio" name="commenting" value="0" checked />
								<label for="com-yes">Yes</label>
							</div>
							<div>
								<input id="com-no" type="radio" name="commenting" value="1" />
								<label for="com-no">No</label>
							</div>
						</div>
					</div>
					<!-- End Commenting Field -->
					<!-- Start Ads Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Allow Advertises</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="ads-yes" type="radio" name="ads" value="0" checked />
								<label for="ads-yes">Yes</label>
							</div>
							<div>
								<input id="ads-no" type="radio" name="ads" value="1" />
								<label for="ads-no">No</label>
							</div>
						</div>
					</div>
					<!-- End Ads Field -->
					<!-- Start Submit Field -->
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Add Category" class="btn btn-primary btn-lg" />
						</div>
					</div>
					<!-- End Submit Field -->
				</form>
			</div>
<?php
/*♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡-End-Add-♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡*/
/*♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡-Start-Insert-♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡*/
		} elseif ($do == 'Insert') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Check Request Method

				echo "<h1 class='text-center'>Insert Category</h1>";
				echo "<div class='container'>";

				// Get Variables From The Form
				$name 		= $_POST['name'];
				$desc 		= $_POST['description'];
				$order 		= $_POST['ordering'];
				$visible 	= $_POST['Visibility'];
				$comment 	= $_POST['commenting'];
				$ads 		= $_POST['ads'];

				// Check If Category Exist In Database
				$check = checkItem("Name", "categories", $name);
				if ($check == 1) {
					$theMsg = "<div class='alert alert-danger'>Sorry This Category Is Exist</div>";
					redirectHome($theMsg, 'back');
				} else {

					// Insert Category Info In Database
					$stmt = $con->prepare("INSERT INTO 
						categories(Name, Description, Ordering, Visibility, Allow_Comment, Allow_Ads) 
					VALUES(:zname, :zdesc, :zorder, :zvisible, :zcomment, :zads)");
					$stmt->execute(array(
						'zname'		=> $name, 
						'zdesc'		=> $desc, 
						'zorder'	=> $order, 
						'zvisible'	=> $visible, 
						'zcomment'	=> $comment, 
						'zads'		=> $ads
						));

					// Echo Success Message
					$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Inserted </div>';
					redirectHome($theMsg, 'back');
				}

			} else {
				echo "<div class = 'container'>";

					$theMsg = "<div class='alert alert-danger'>Sorry You Cant Browse This Bage Directly</div>";
					redirectHome($theMsg, 'back', 6);

				echo "</div>";
			}

			echo "</div>";
/*♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡-End-Insert-♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡*/
/*♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡-Start-Edit-♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡*/
		} elseif ($do == 'Edit') {


/*♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡-End-Edit-♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡*/
/*♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡-Start-Update-♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡*/
		} elseif ($do == 'Update') {


/*♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡-End-Update-♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡*/
/*♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡-Start-Delete-♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡*/
		} elseif ($do == 'Delete') {
			

/*♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡-End-Delete-♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡*/
		}

		include $tpl . 'footer.php';

	} else {

		header('Location: index.php');
		exit();
	}

	ob_end_flush();
?>
