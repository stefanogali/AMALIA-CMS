<?php
session_start();
include_once('../includes/connection.php');
include_once('../includes/pages_class.php');
include_once('../includes/functions.php');

if(isset($_SESSION['logged_in'])){ 
	$subscribers = new Subscribers;
	$subscribers_fetch = $subscribers->fetch_all();
?>
<!DOCTYPE html>
<html lang="en">
<?php
	$title = "Subscribers page";
	get_head_admin($title)?>
</head>
  <body class = "admin">
    <header>
    	<div class="top-cms">
            <p class = "dashboard"><a href = "index.php" id = "logo">AMALIA CMS</a></p>
    		<p class = "live"><a href = "../index.php">GO TO WEBSITE</a></p>
        </div>
    </header>
	<div class = "container">
		<div class="row">
			<div class="col-md-12">
				<h4>Your subscribers</h4>
				<table class="table table-striped">
				    <thead>
				        <tr>
				            <th>Full name</th>
				            <th>Email</th>
				            <th>Date of subscription</th>
				        </tr>
				    </thead>
				    <tbody>
				    <?php foreach ($subscribers_fetch as $subscriber) {?>
				        <tr>
				            <td><?php echo $subscriber['fullName']?></td>
				            <td><?php echo $subscriber['userEmail']?></td>
				            <td><?php echo date('l jS \of F Y',$subscriber['subscriber_timestamp']) ?></td>
				        </tr>
				    <?php } ?>    
				    </tbody>
				</table>
				<p>Download in PDF <a href = "subscribers_pdf.php">here</a></p>
			</div><!--/.col-md-12-->
		</div><!--/.row-->
	</div><!--/.container-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="js/script_admin.js"></script>
  	</body>
</html>
<?php }else{
	header('Location: index.php');
}
