<?php 
	include('config/constants.php');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TASK MANAGER with PHP and MySQL</title>
	<link rel="stylesheet" type="text/css" href="<?php echo SITEURL; ?>css/style.css">
</head>
<body>
	<div class="wrapper">
		<h1>TASK MANAGER</h1>
		<a class="btn-secondary" href="<?php echo SITEURL?>">HOME</a>
		<h3>Add Task Page</h3>
		<p>
			<?php 
				if(isset($_SESSION['add_fail']))
				{
					echo $_SESSION['add_fail'];
					unset($_SESSION['add_fail']);
				}
			?>
		</p>

		<form method="POST" action="">
			<table class="tbl-half">
				<tr>
					<td>Task Name :</td>
					<td><input type="text" name="task_name" placeholder="ENTER YOUR TASK NAME" required></td>
				</tr>
				<tr>
					<td>Task Description :</td>
					<td><textarea name="task_description" placeholder="ENTER TASK DESCRIPTION HERE"></textarea></td>
				</tr>
				<tr>
					<td>Select List :</td>
					<td>
						<select name="list_id">

							<?php  
								//connect database
								$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
								//select database
								$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());
								//sql query to get the list from table
								$sql = "SELECT * FROM tbl_lists";
								//execute query
								$res = mysqli_query($conn, $sql);
								//check query executed or not
								if($res==true)
								{
									//create variable to count rows
									$count_rows = mysqli_num_rows($res);
									//if there is data is database then display all in dropdown else display None as option
									if($count_rows>0)
									{
										//display all list on dropdown from database
										while ($row=mysqli_fetch_assoc($res)) 
										{
											$list_id = $row['list_id'];
											$list_name = $row['list_name'];
											?>
											<option value="<?php echo $list_id; ?>"><?php echo $list_name; ?></option>
											<?php
										}
									}
									else
									{
										//display none as option
										?>
										<option value="0">None</option>
										<?php
									}
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Priority :</td>
					<td>
						<select name="priority">
							<option value="High">High</option>
							<option value="Medium">Medium</option>
							<option value="Low">Low</option>						
						</select>
					</td>
				</tr>
				<tr>
					<td>Deadline :</td>
					<td><input type="date" name="deadline" /></td>
				</tr>
				<tr>
					<td><input class="btn-primary btn-lg" name="submit" type="Submit" value="SAVE" /></td>
				</tr>
			</table>
		</form>
	</div>
</body>
</html>
<?php
	//whether the save button is clicked or not
	if(isset($_POST['submit']))
	{
		//echo "button clicked";
		//get all values from form
		$task_name = $_POST['task_name'];
		$task_description = $_POST['task_description'];
		$list_id = $_POST['list_id'];
		$priority = $_POST['priority'];
		$deadline = $_POST['deadline'];
		
		//connect database
		$conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

		//select database
		$db_select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_error());

		//create query to insert data into database
		$sql2 = "INSERT INTO tbl_tasks SET
				task_name = '$task_name',
				task_description = '$task_description',
				list_id = $list_id,
				priority = '$priority',
				deadline = '$deadline'
		";

		//execute the query
		$res2 = mysqli_query($conn2, $sql2);

		//check whether the query executed successfully or not
		if($res2=true)
		{
			//executed successfully
			$_SESSION['add'] = "Task added successfully" ;
			
			//redirect to homepage
			header('location:'.SITEURL);
		}
		else
		{
			//query failed
			$_SESSION['add_fail'] = "Failed to add Task" ;
			
			//redirect to task page
			header('location:'.SITEURL.'add-task.php');
		}

	}
?>