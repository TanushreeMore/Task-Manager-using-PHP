<?php
	include('config/constants.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<title>
			Task Manager with PHP & MySQL
		</title>
		<link rel="stylesheet" type="text/css" href="<?php echo SITEURL; ?>css/style.css">
	</head>
	<body>
		<div class="wrapper">
			<h1>Task Manager</h1>
			<a class="btn-secondary" href="<?php echo SITEURL; ?>index.php">Home</a>
			<h3>Manage Lists Page</h3>

			<p>
				<?php
					//check if the session is set
					if (isset($_SESSION['add']))
					{
						//display message
						echo $_SESSION['add'];
						//remove the message after displaying one time
						unset($_SESSION['add']);
					}

					//check the session for Delete
					if(isset($_SESSION['delete']))
					{
						echo $_SESSION['delete'];
						unset($_SESSION['delete']);
					}

					//check the session for Update
					if(isset($_SESSION['update']))
					{
						echo $_SESSION['update'];
						unset($_SESSION['update']);
					}

					//check for Delete fail
					if(isset($_SESSION['delete_fail']))
					{
						echo $_SESSION['delete_fail'];
						unset($_SESSION['delete_fail']);
					}

					//check for update fail
					if(isset($_SESSION['update_fail']))
					{
						echo $_SESSION['update_fail'];
						unset($_SESSION['update_fail']);
					}

				?>
			</p>

			<!-- Table to display list starts here -->
			<div class="all-lists">
				<a class="btn-primary" href="<?php echo SITEURL; ?>add-list.php">Add List</a>
				<table class="tbl-half">
					<tr>
						<th>S.N.</th>
						<th>List Name</th>
						<th>Actions</th>
					</tr>


					<?php
						//connect the database
						$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

						//select database
						$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

						//SQL query to display all data from database
						$sql = "SELECT * FROM tbl_lists";

						//execute the Query
						$res = mysqli_query($conn, $sql);

						//check whether the query executed or not successfully
						if($res == true)
						{
							//work on displaying data
							//echo "Executed";

							//count the rows of data in database
							$count_rows = mysqli_num_rows($res);

							//create a serial number variable
							$sn = 1;


							//check whether there is data in the database or not
							if($count_rows > 0)
							{
								//there's data into the database, display in table
								while ($row = mysqli_fetch_assoc($res)) 
								{
									//getting the data from database
									$list_id = $row['list_id'];
									$list_name = $row['list_name'];
					?>
		
					<tr>
						<td><?php echo $sn++; ?></td>
						<td><?php echo $list_name; ?></td>
						<td>
							<a href="<?php echo SITEURL; ?>update-list.php?list_id=<?php echo $list_id; ?>">Update</a>
							<a href="<?php echo SITEURL; ?>delete-list.php?list_id=<?php echo $list_id; ?>">Delete</a>

						</td>
					</tr>
		
					<?php

								}
							}
							else
							{
								//no data into database
					?>

					<tr>
						<td colspan="3">No list added yet..</td>
					</tr>
					
					<?php
							}
						}
					?>

				</table>
			</div>
			<!-- Table to display list starts here -->
		</div>
	</body>
</html>