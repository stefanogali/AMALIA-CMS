<?php
session_start();
include_once('../includes/connection.php');
include_once('../includes/functions.php');
include_once('../includes/htmLawed.php');

if (isset($_SESSION['logged_in'])){
	if(isset($_POST['title'],$_POST['content'])){
		$title = htmLawed($_POST['title']);
		$content = htmLawed($_POST['content']);
		if(empty($title) || empty($content)){
			$error = "All field are required!";
		}else{
			$query = $dbh->prepare("INSERT INTO pages_cms (pages_title, pages_content,pages_timestamp) VALUES (?,?,?)");
			$query->bindValue(1,$title);
			$query->bindValue(2,$content);
			$query->bindValue(3,time());
			$query->execute();
			header('Location: ../index.php');
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<?php
		$title = "Add a page";
		get_head_admin($title)?>
	<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
	<script src="../js/editor.js"></script>
	</head>
	  	<body class = "admin">
	    	<header>
	    		<div class= "admin-bar">
		    		<div class="top-cms">
            			<p class = "dashboard"><a href = "index.php" id = "logo">AMALIA CMS</a></p>
            			<p class = "live"><a href = "../index.php">GO TO WEBSITE</a></p>
        			</div>
        		</div><!--/.admin-bar-->
	        	<div class = "container">
	            	<div class="row">
	                	<h4>Add page</h4>
	                		<?php if(isset($error)){ ?>
	                		<small class = "error"><?php echo $error; ?></small>
	                		<?php } ?>
		                <form action = "add.php" method = "post" autocomplete ="off">
						  	<div class="form-group">
						    	<label for="title">Insert your title for the page</label>
						    	<input type="text" class="form-control" id="title" name = "title" placeholder="Title">
						  	</div><!--/.form-group-->
						  	<!--TINYMCE EDITOR-->
						  	<div class="form-group">
						  		<textarea id="mytextarea" name = "content"></textarea>
						  	</div><!--/.form-group-->
						  	<button type="submit" class="btn btn-default">Add page</button>
						</form>
            		</div><!--/.row-->
	        	</div><!--/.container-->
	    		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	    		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		</body>
</html>
<?php }else{
	header('Location: index.php');
}
?>