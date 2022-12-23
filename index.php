<!-- 07-12-2022 -->
<?php
    include('config/constants.php');
?>

<!DOCTYPE html>
<html>
    <head>
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

            <!-- Task starts here -->
            <p>
                <?php
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add'];
                        unset($_SESSION['add']);
                    }

                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }

                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }

                    if(isset($_SESSION['delete_fail']))
                    {
                        echo $_SESSION['delete_fail'];
                        unset($_SESSION['delete_fail']);
                    }
                ?>
            </p>
            <div class="all-tasks">
                <a class="btn-primary" href="<?php SITEURL; ?>add-task.php">Add Task</a>
                <table class="tbl-full">
                    <tr>
                        <th>S.N</th>
                        <th>Task Name</th>
                        <th>Priority</th>
                        <th>Deadline</th>
                        <th>Action</th>
                    </tr>
                    <?php
                        //connect database
                        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

                        //select database
                        $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

                        //create SQL query to get data from database
                        $sql = "SELECT * FROM tbl_tasks";

                        //execute query
                        $res = mysqli_query($conn, $sql);

                        //check whether query executed or not
                        if($res==true)
                        {
                            //display the task from database
                            //count the task on database first
                            $count_rows = mysqli_num_rows($res);

                            //create a serial number variable
                            $sn = 1;

                            //check whether there is task on database or not
                            if($count_rows>0)
                            {
                                //data is in database
                                while($row = mysqli_fetch_assoc($res))
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
                                //no data in database
                                <tr>
                                    <td colspan="5">No task added yet...</td>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                </table>
            </div>
            <!-- Task ends here -->
        </div>
    </body>
</html>