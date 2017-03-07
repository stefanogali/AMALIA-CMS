<?php
session_start();
include_once('../includes/connection.php');
include_once('../includes/config.inc.php');
include_once('../includes/functions.php');

$clean = array();
$error = '';
$updir = $config['slider_images_dir'];
$html_output = '';
$confirm = '';
$slider_to_delete = -1;
$stop = true;

if(isset($_GET['delete'])){
	$slider_to_delete = $_GET['delete'];
}
if (isset($_SESSION['logged_in'])){
	if (isset($_POST['fileupload'])) {
		$form_is_submitted = true;

		//check the various extensions for the file.
		if ($_FILES['userfile']['error'] == UPLOAD_ERR_OK) {
			$tmpname = $_FILES['userfile']['tmp_name'];
			$target_file = $updir . basename($_FILES["userfile"]["name"]);
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			//check if file has been uploaded and if image is a jpg
			if (is_uploaded_file($_FILES['userfile']['tmp_name'])){
				if ($imageFileType == "jpg" || $imageFileType == "jpeg"  || $imageFileType == "JPG" || $imageFileType == "JPEG" && getimagesize($tmpname)){
					//check if file with same name already exists
					if(checkIfFileNotExists($updir,$target_file)){
						$clean['image'] = $_FILES['userfile']['tmp_name'];
						$newname = $updir . basename($_FILES["userfile"]["name"]);
						//this is the path to upload to database
						$url_to_db = 'slider-images/'. basename($_FILES["userfile"]["name"]);
						$tmpname = $clean['image'];
						if (move_uploaded_file($tmpname, $newname)){
							$confirm = "File uploaded!";
						}else{
							$confirm = "Your file has not been uploaded, please try again!";
						}
					}else { 
						$error = "You already uploaded an image with the same name, please change name of the file!";
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
	$files = openFolder($updir);
	$counter_to_delete = 0;
	foreach($files as $file){
		$counter_to_delete++;

		if($counter_to_delete == $slider_to_delete){
			unlink($updir.$file);
		}
	}
	$files = openFolder($updir);
	//clear database table for the images, it will be populates inside foreach loop if any image is inside folder
	$query = $dbh->prepare("TRUNCATE TABLE slider_images");
	$query->execute();
	$count = 0;
	foreach($files as $file){
		$count++;
		if($count >= 5){
			$stop = false;
		}
		//set name of file
		$filename = $updir.$file;
		$out_img_file =  '../slider-images/'.$file;
		//this is the path to upload to database
		$url_to_db = str_replace("../","",$out_img_file);
		//mysqli_query($dbh,"TRUNCATE TABLE slider_images");

		$query = $dbh->prepare("INSERT INTO slider_images(url_slider_img) VALUES (?)");
	        					$query->bindValue(1,$url_to_db);
	        					$query->execute();
		//required width/height
		$req_width = 1170;
		$req_height = 400;
		//the output is generated here if JPG
		if (img_resize($filename, $filename, $req_width, $req_height) == true){
			//get details of image
			$details = getimagesize($filename);
			$width = $details[0];
			$height = $details[1];
			//the html output
			if (($count % 3) == 0){
				$html_output .= '</div><div class = "row">';
			}
			$html_output .= containerImageSlider($out_img_file, $width, $height, $count);
			
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
	<?php
	$title = "Change Slider Image";
	get_head_admin($title)?>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
	</head>
  	<body class = "admin">
  		<div class= "admin-bar">
	  		<div class="top-cms">
	            <p class = "dashboard"><a href = "index.php" id = "logo">AMALIA CMS</a></p>
				<p class = "live"><a href = "../index.php">GO TO WEBSITE</a></p>
	        </div>
	    </div>
        <div class = "container">
            <div class = "row">
                <div class="col-md-12">
	                <h4>Use your images on the slider</h4>
	                <h5>Please upload the image you wish to use on your Slider, 5 images max! Recommended size for your images is 1170px x 400px.</h5>
	                <?php echo "<p>".$confirm."</p>";
							if(isset($error)){ ?>
	                			<small><?php echo "<p class = \"error\">".$error."</p>" ?></small>
                	<?php } ?>
            		<?php } ?>
	                <?php if($stop){ ?>
	                <form enctype="multipart/form-data" action="change_slider.php" method="post">
						<div class="form-group">
							<label>Upload your image:</label> 
							<input name="userfile" type="file" />
						</div>
						<p>
							<input type="submit" class="btn btn-default" name="fileupload" value="Upload!" />
						</p>
					</form>
                	<div class = "row">
                	<?php 
                		if(!empty($html_output)){ ?>
                			<?php echo $html_output; ?>
                	<?php } ?>
                	</div><!--/.row-->
                </div><!--/.col-md-12-->
        	</div> <!--/.row-->
        </div><!--/.container-->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	    <script src="js/script_admin.js"></script>
  	</body>
</html>
<?php
}else{
	header('Location: index.php');
}
?>