<?php

	//Include constants.php
	include('config/constants.php');

	//echo "Delete List Page";
	
	//check whether the list_id is assigned or not
	if(isset($_GET['list_id']))
	{
		//delete the list from database
		//get the list_id value from URL or get method
		$list_id = $_GET['list_id'];

		//connect the database
		$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

		//select database
		$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

		//write the query to delete list from database
		$sql = "DELETE FROM tbl_lists WHERE list_id= $list_id";

		//Execute the query
		$res = mysqli_query($conn, $sql);

		//check whether query executed or not successfully
		if($res==true)
		{
			//query executed successfully which means query deleted successfully 
			$_SESSION['delete'] = "List deleted successfully";

			//redirect to Manage-list page
			header('location:'.SITEURL.'manage-list.php');
		}
		else
		{
			//failed to delete query
			$_SESSION['delete_fail'] = "failed to delete list";

			//redirect to Manage-list page
			header('location:'.SITEURL.'manage-list.php');	
		}
		
	}
	else
	{
		//redirect to manage list page
		header('location:'.SITEURL.'manage-list.php');
	}

	




?>