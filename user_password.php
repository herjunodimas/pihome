<?php require_once("st_inc/session.php"); ?>
<?php confirm_logged_in(); ?>
<?php require_once("st_inc/connection.php"); ?>
<?php require_once("st_inc/functions.php"); ?>
<?php 
	if(isset($_GET['uid'])) {
		$id = $_GET['uid'];
	} else {
		redirect_to("settings.php");
	}

	if (isset($_POST['submit'])) { // Form has been submitted.
		// perform validations on the form data
		if ((!isset($_POST['new_pass'])) || (empty($_POST['new_pass']))) {
			$error_message = "New Password is empty.";
		} elseif((!isset($_POST['con_pass'])) || (empty($_POST['con_pass']))) {
			$error_message = "Confirm password is empty.";
		} elseif($_POST['new_pass'] != $_POST['con_pass']) {
			$error_message = "Password Confirmation failed. New Password and Confirm Password must be same.";
		}
		
		$new_pass = mysql_real_escape_string(md5($_POST['new_pass']));
		$con_pass = mysql_real_escape_string(md5($_POST['con_pass']));

		if (!isset($error_message) && ($new_pass == $con_pass)) {
					$cpdate= date("Y-m-d H:i:s");
					$query = "UPDATE user SET password = '{$new_pass}', cpdate = '{$cpdate}' WHERE id = '{$id}' LIMIT 1";
					$result = mysql_query($query, $connection);
					if ($result) {
						// Success!
						$message_success = "Password is successfully changed.";
						header("Refresh: 3; url=settings.php");
					} else {$error = "<p>Password chaneg failed.</p> <p>" . mysql_error() . "</p>";}
		} 

		}
$query = "SELECT * FROM user WHERE id = {$id}";
$results = mysql_query($query, $connection);	
$row = mysql_fetch_assoc($results);

?>
<?php include("header.php");  ?>
<?php include_once("notice.php"); ?>
        <div id="page-wrapper">
<br>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-cog fa-fw"></i> Settings    
						<div class="pull-right"> <div class="btn-group"><?php echo date("H:i"); ?></div> </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						
						<p > Please enter your password details below. Fields with * are required. </p> 
                <form class="international" method="post" action="<?php $PHP_SELF ?>" id="form-join" name="addproduct">
				<div class="form-group"><label>Full Name</label>
                <input type="text" class="form-control" placeholder="Full Name" value="<?php echo $row['fullname'] ;?>" disabled> 
                </div>
                <div class="form-group"><label>Username</label>
                <input type="text" class="form-control" placeholder="User Name" value="<?php echo $row['username'] ;?>" disabled> 
                </div>
				
                <div class="form-group"><label>New Password</label>
                <input type="password" class="form-control" placeholder="Enter New Password" value="" id="new_pass" name="new_pass" > 
                </div>
                <div class="form-group"><label>Confirm Password</label>
                <input type="password" class="form-control" placeholder="Enter Confirm New Password" value="" id="con_pass" name="con_pass" > 
                </div>				
				<INPUT type="button" VALUE="Cancel" onClick="history.go(-1)" class="btn btn-primary btn-sm">
                <input type="submit" name="submit" value="submit" class="btn btn-default btn-sm">

                </form>
					
                        </div>
                        <!-- /.panel-body -->
						<div class="panel-footer">

<?php 
$query="select * from weather";
$result = mysql_query($query, $connection);
confirm_query($result);
$weather = mysql_fetch_array($result);
?>

Outside: <?php //$weather = getWeather(); ?><?php echo $weather['c'] ;?>&deg;C
<span><img border="0" width="24" src="images/<?php echo $weather['img'];?>.png" title="<?php echo $weather['title'];?> - 
<?php echo $weather['description'];?>"></span> <span><?php echo $weather['title'];?> - 
<?php echo $weather['description'];?></span>
                        </div>
                    </div>
                </div>

                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
		
<?php include("footer.php");  ?>
