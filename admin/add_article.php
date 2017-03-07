<?php
session_start();
include_once('../includes/config.inc.php');
include_once('../includes/connection.php');
include_once('../includes/functions.php');
include_once('../includes/htmLawed.php');

$clean = array();
$error = '';
$updir = $config['images_dir'];

if (isset($_SESSION['logged_in'])){
	if(isset($_POST['title'],$_POST['content'])){
		$title = htmLawed($_POST['title']);
		$user_file = $_FILES['userfile']['name'];
		$content = htmLawed($_POST['content']);
		if(empty($title) || empty($content) || empty($user_file)){
			$error = "All field are required!";
		}else{
			if ($_FILES['userfile']['error'] == UPLOAD_ERR_OK) {
				$tmpname = $_FILES['userfile']['tmp_name'];
				$target_file = $updir . basename($_FILES["userfile"]["name"]);
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
				//check if file has been uploaded and if image is a jpg
					if (is_uploaded_file($_FILES['userfile']['tmp_name'])){
						if ($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "JPG" || $imageFileType == "JPEG" && getimagesize($tmpname)){
							//check if file with same name already exists
							if(checkIfFileNotExists($updir,$target_file)){
								$clean['image'] = $_FILES['userfile']['tmp_name'];
								$newname = $updir . basename($_FILES["userfile"]["name"]);
								//this is the path to upload to database
								$url_to_db = 'images/'. basename($_FILES["userfile"]["name"]);
								$tmpname = $clean['image'];
								$req_width = 1170;
								$req_height = 500;
								if (move_uploaded_file($tmpname, $newname)){
									if (img_resize($newname, $newname, $req_width, $req_height) == true){
										$details = getimagesize($newname);
										$width = $details[0];
										$height = $details[1];
										$query = $dbh->prepare("INSERT INTO articles_cms (articles_title, articles_content,articles_timestamp, articles_image, articles_img_width, articles_img_height) VALUES (?,?,?,?,?,?)");
										$query->bindValue(1,$title);
										$query->bindValue(2,$content);
										$query->bindValue(3,time());
										$query->bindValue(4,$url_to_db);
										$query->bindValue(5,$width);
										$query->bindValue(6,$height);
										$query->execute();
										header('Location: ../index.php');
									}else{ 
										$error .= "Your file has not been uploaded, please try again.";
									}
								}else{
									$error .= "Your file has not been uploaded, please try again. ";
								}
								
							}else { 
								$error .= "You already uploaded an image with the same name, please change name of the file. ";
							}
						}else{
							$error .= "File is not a correct format. Please use JPG.";
						}
					}
			//image too heavy(more than 2MB)
			}else if ($_FILES['userfile']['error'] == UPLOAD_ERR_INI_SIZE){
				$error .= "File size is too heavy";
			//error during uploading image
			}else if ($_FILES['userfile']['error'] == UPLOAD_ERR_PARTIAL){
				$error .= "Partial error in uploading iamge";
			//no files uploaded
			}else{
				$error .= "No file was uploaded";
			}

		}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<?php
	$title = "Add an article";
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
        		</div><!--/.top-cms-->
        	</div><!--/.admin-bar-->
	        <div class = "container">
	            <div class="row">
	                <h4>Add Article</h4>
	                <?php if(isset($error)){ ?>
	                		<small class = "error"><?php echo $error; ?></small>
                	<?php } ?>
	                <form enctype="multipart/form-data" action = "add_article.php" method = "post" autocomplete ="off">
				    	<div class="form-group">
					    	<label for="title">Insert your title for the Article</label>
					    	<input type="text" class="form-control" id="title" name = "title" placeholder="Title">
					  	</div>
					  	<div class="form-group">
					    	<label for="title">Insert your main image for the Article. Suggested size 1170px X 500px.</label>
					    	<input name="userfile" type="file" />
					  	</div>
					  	<!--TINYMCE EDITOR-->
					  	<div class="form-group">
					  		<textarea id="mytextarea" name = "content"></textarea>
					  	</div>
					  	<button type="submit" name = "submit" class="btn btn-default">Add Article</button>
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