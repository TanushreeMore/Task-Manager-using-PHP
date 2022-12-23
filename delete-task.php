<?php
	include('config/constants.php');

	//check task_id un URL
	if(isset($_GET['task_id']))
	{
		//delete the task from database
		//get the task_id
		$task_id = $_GET['task_id'];

		//connect database
        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

        //select database
        $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

        //create SQL query to delete data from database
        $sql = "DELETE FROM tbl_tasks WHERE task_id=$task_id";

        //execute query
        $res = mysqli_query($conn, $sql);

        //check whether query executed or not
        if($res==true)
        {
        	//query executed successfully and task delete
        	$_SESSION['delete'] = "Task deleted successfully";

        	//redirect to homepage
        	header('location:'.SITEURL);
        }
        else
        {
        	//fail task delete
        	$_SESSION['delete_fail'] = "Failed to delete Task";

        	//redirect to homepage
        	header('location:'.SITEURL);

        }
	}
	else
	{
		//redirect to home page
		header('location:'.SITEURL);
	}
?>
