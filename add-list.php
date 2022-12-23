<?php
	include('config/constants.php');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
			Task Manager with PHP & MySQL		
	</title>
	<link rel="stylesheet" type="text/css" href="<?php echo SITEURL; ?>css/style.css">

</head>
<body>
	<div class="wrapper">
		<h1>Task Manager</h1>
		<a class="btn-secondary" href="<?php echo SITEURL; ?>index.php">home</a>
		<a class="btn-secondary" href="<?php echo SITEURL; ?>manage-list.php">Manage List</a>
		<h3>Add list page</h3>
		<p>
			<?php
				//check whether the session is created or not
				if(isset($_SESSION['add_fail']))
				{
					//display session message
					echo $_SESSION['add_fail'];
					//remove the message after displaying once
					unset($_SESSION['add_fail']);
				}
			?>
		</p>
		<!-- form to add list starts here -->
		<form method="POST" action="">
			<table class="tbl-half">
				<tr>
					<td>List Name : </td>
					<td><input type="text" name="list_name" placeholder="ENTER LIST NAME HERE" required="required"> </td>
				</tr>
				<tr>
					<td>List Description : </td>
					<td><textarea name="list_description" placeholder="ENTER LIST DESCRIPTION HERE"></textarea></td>
				</tr>
				<tr>
					<td><input class="btn-primary btn-lg" type="submit" name="submit" value="Submit">
					</td>
				</tr>
			</table>
		</form>
		<!-- form to add list ends here -->
	</div>
</body>
</html>

<?php
	 //check whether the form is submitted or not
	if(isset($_POST['submit']))            // isset() --> use to check it contains value or it is null.
	{
		//echo "Form Submitted";
		// get the values from & save it in variables
		$list_name = $_POST['list_name'];
		$list_description = $_POST['list_description'];

		// connect database
		$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

		// check whether the database is connected or not
		/*if($conn == true)
		{
			echo "Database connected";
		}*/

		//select Database
		$db_select = mysqli_select_db($conn, DB_NAME);

		//check whether database is connected or not
		/*if($db_select == true)
		{
			echo "database is connected";
		}*/
		
		//SQL Query to Insert data into database
		$sql = "INSERT INTO tbl_lists SET 
   		list_name = '$list_name',
   		list_description = '$list_description'
		";

		//Execute the Query and Insert into Database
		$res = mysqli_query($conn, $sql);

		//check whether the query executed successfully or not
		if($res == true)
		{
			//Data inserted successfully
			//echo "Data inserted";

			//create a SESSION variale to display message
			$_SESSION['add'] = "List Added Successfully";

			//Redirect to Manage List Page
			header('location:'.SITEURL.'manage-list.php');
		}
		else
		{
			//Failed to insert data
			//echo "Failed to Insert Data";

			//create a SESSION to save message
			$_SESSION['add_fail'] = "Failed to Add List";

			//Redirect to same page
			header('location:'.SITEURL.'add-list.php');
		}
	}
?>