<?php
	include('config/constants.php');
	//get the list_id from URL
	$list_id_url = $_GET['list_id'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Task Manager with PHP & MySQL</title>
	<link rel="stylesheet" type="text/css" href="<?php echo SITEURL; ?>css/style.css">
</head>
<body>
	<div class="wrapper">
		<h1>TASK MANAGER</h1>
		        <!-- Menu starts here -->
			<div class="menu">
			<a href="<?php echo SITEURL; ?>index.php">Home</a>
			<?php 
			    //displaying menu lists from database in our menu
			    $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

			    //select database
			    $db_select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_error());

			    //query to get the lists from database
			    $sql2 = "SELECT * FROM tbl_lists";

			    //execute database
			    $res2 = mysqli_query($conn2, $sql2);

			    //check query executed or not
			    if($res2==true)
			    {
			        //display the list in menu
			        while($row2=mysqli_fetch_assoc($res2))
			        {
			            $list_id = $row2['list_id'];
			            $list_name = $row2['list_name'];
			            ?>

			            <a href="<?php echo SITEURL; ?>list-task.php?list_id=<?php echo $list_id; ?>"><?php echo $list_name; ?></a>

			            <?php
			        }
			    }
			?>

			<a href="<?php echo SITEURL; ?>manage-list.php">Manage List</a>
			</div>

			<!-- Menu ends here -->
			<div class="all-task">
				<a class="btn-primary" href="<?php echo SITEURL; ?>add-task.php">Add Task</a>
				<table class="tbl-full">
					<tr>
						<td>S.N.</td>
						<td>Task Name</td>
						<td>Priority</td>
						<td>Deadline</td>
						<td>Action</td>
					</tr>
					<?php
						$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
						$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());
						$sql = "SELECT * FROM tbl_tasks WHERE list_id=$list_id_url";
						$res = mysqli_query($conn, $sql);
						$sn = 1;

						if($res==true)
						{
							$count_rows = mysqli_num_rows($res);

							if($count_rows>0)
							{
								while ($row=mysqli_fetch_assoc($res))
								{
									$task_id = $row['task_id'];
									$task_name = $row['task_name'];
									$priority = $row['priority'];
									$deadline = $row['deadline'];
									?>
									<tr>
										<td><?php echo $sn++; ?></td>
										<td><?php echo $task_name; ?></td>
										<td><?php echo $priority; ?></td>
										<td><?php echo $deadline; ?></td>
										<td>
							<a href="<?php echo SITEURL; ?>update-task.php?task_id=<?php echo $task_id; ?>">Update</a>
							<a href="<?php echo SITEURL; ?>delete-task.php?task_id=<?php echo $task_id; ?>">Delete</a>
										</td>
									</tr>
								<?php
								}
							}
							else
							{
								?>
								<tr>
									<td colspan="5">No task added on this list</td>
								</tr>
								<?php
							}
						}
					?>
					
				</table>
			</div>
	</div>
</body>
</html>