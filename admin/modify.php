<?php
session_start();
include_once('../includes/connection.php');
include_once('../includes/pages_class.php');
include_once('../includes/functions.php');
include_once('../includes/htmLawed.php');
if (isset($_SESSION['logged_in'])){
	$page = new Pages;

	//get page id from query string
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$data = $page->fetch_data($id);
		$query = $dbh->prepare("UPDATE pages_cms SET pages_update = 0;
								UPDATE pages_cms SET pages_update = 1 WHERE pages_id = (?)");
		$query->bindValue(1,$id);
		$query->execute();
	}else{
		$data = $page->fetch_content_empty_id();
	}
	if(isset($_POST['submit'])){
		if(isset($_POST['title'],$_POST['content'])){
			$title = htmLawed($_POST['title']);
			$content = htmLawed($_POST['content']);
			if(empty($title) || empty($content)){
				$error = "All field are required!";
			}else{
				$query = $dbh->prepare("UPDATE pages_cms SET pages_title = (?), pages_content = (?),
										pages_timestamp =  (?) WHERE pages_update = TRUE");
				$query->bindValue(1,$title);
				$query->bindValue(2,$content);
				$query->bindValue(3,time());
				$query->execute();
				header('Location: ../index.php');
			}
		}	
	}
?>
<!DOCTYPE html>
<html lang="en">
	<?php
	$title = "Modify a page";
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
    		</div>
    	</header>
        <div class = "container">
            <div class="row">
                <h4>Change your page</h4>
                <?php if(isset($error)){ ?>
                		<small class = "error"><?php echo $error; ?></small>
                	<?php } ?>
                <form action = "modify.php" method = "post" autocomplete ="off">
				  <div class="form-group">
				    <label for="title">Change your title for the page</label>
				    <input type="text" class="form-control" id="title" name = "title" value="<?php echo $data['pages_title']?>">
				  </div>
				<!--TINYMCE EDITOR-->
				  <div class="form-group">
				  	<label for="mytextarea">Change your content</label>
				  	<textarea id="mytextarea" name = "content" > <?php echo $data['pages_content']?> </textarea>
				  </div>
				  <button type="submit" class="btn btn-default" name = "submit">Change page</button>
				</form>
        	</div><!--/.row-->
        </div><!--./container-->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	    <script src="js/script_admin.js"></script>
    </body>
</html>
<?php }else{
	header('Location: index.php');
}
?>