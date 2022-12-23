<?php 
	include('config/constants.php');
	
	//get the current values of selected list
	if(isset($_GET['list_id']))
	{
		//get the list ID value
		$list_id = $_GET['list_id'];

		//connect to database
		$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

		//select database
		$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

		//query to get the values from database
		$sql = "SELECT * FROM tbl_lists WHERE list_id=$list_id";

		//execute query
		$res = mysqli_query($conn, $sql);

		//check whether the query executed successfully or not
		if($res==true)
		{
			//get the value from database
			$row = mysqli_fetch_assoc($res); //value is in array format
			//print_r($row); //to print array

			//create individual variable to save the data
			$list_name = $row['list_name'];
			$list_description = $row['list_description'];
		}
		else
		{
			//go back to manage list page
			header('location:'.SITEURL.'manage-list.php');
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Task Manager with PHP and MySQL</title>
	<link rel="stylesheet" type="text/css" href="<?php echo SITEURL; ?>css/style.css">
</head>
<body>
	<div class="wrapper">	
		<h1>TASK MANAGER</h1>
			<a class="btn-secondary" href="<?php echo SITEURL; ?>index.php">HOME</a>
			<a class="btn-secondary" href="<?php echo SITEURL; ?>manage-list.php">MANAGE LIST</a>
		<h3>Update List Page</h3>
		<p>
			<?php
				//check whether the session set or not
			if(isset($_SESSION['update_fail']))
			{
				echo $_SESSION['update_fail'];
				unset($_SESSION['update_fail']);
			}
			?>
		</p>
		<form method="POST" action="">
			<table class="tbl-half">
				<tr>
					<td>List Name: </td>
					<td><input type="text"  name="list_name" value="<?php echo $list_name; ?>" required /></td>
				</tr>
				<tr>
					<td>List Description: </td>
					<td>
						<textarea name="list_description"><?php echo $list_description; ?></textarea>
					</td>
				</tr>
				<tr>
					<td><input class="btn-primary btn-lg" type="submit" name="submit" value="UPDATE" /></td>
				</tr>
			</table>
		</form>
	</div>
</body>
</html>

<?php
//check whether the update is clicked or not
	if(isset($_POST['submit']))
	{
		//echo "button clicked";

		//get the updated values from our form
		$list_name = $_POST['list_name'];
		$list_description = $_POST['list_description'];

		//connect database
		$conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

		//select the database 
		$db_select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_error());

		//query to update list
		$sql2 = "UPDATE tbl_lists SET 
		list_name = '$list_name',
		list_description = '$list_description'
		WHERE list_id = $list_id
		";

		//execute the query
		$res2 = mysqli_query($conn2, $sql2);

		//check whether the query executed successfully or not
		if($res2 == true)
		{
			//update successful
			$_SESSION['update'] = "List Updated successfully";

			//redirect to manage list page
			header('location:'.SITEURL.'manage-list.php');
		}
		else
		{
			//failed to update
			$_SESSION['update_fail'] = "Update failed";

			//redirect to the same page
			header('location:'.SITEURL.'update-list.php?list_id='.$list_id);
			
		}
 	}
?>