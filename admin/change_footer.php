<?php
session_start();
include_once('../includes/connection.php');
include_once('../includes/config.inc.php');
include_once('../includes/functions.php');
include_once('../includes/htmLawed.php');
include_once('../includes/pages_class.php');

$clean = array();
$error = '';
$updir = $config['upload_footer_dir'];
$html_output = '';
$confirm = '';
$is_jpg = false;
$is_png = false;
$logo_to_delete ='';

if (isset($_SESSION['logged_in'])){

	$data_central = new FooterContainer1;
	$footer_central_fetch = $data_central->fetch_all();

	$footer_right = new FooterContainer2;
	$footer_right_fetch = $footer_right->fetch_all();

	//delete logo from upload folder if it is seton the url
	if(isset($_GET['delete'])){
		$logo_to_delete = $_GET['delete'];
		$logo_to_delete = str_replace("footer-uploads/","",$logo_to_delete);
		unlink($updir.$logo_to_delete);
	}
	if (isset($_POST['fileupload'])) {
		$form_is_submitted = true;

		//check the various extensions for the file.
		if ($_FILES['userfile']['error'] == UPLOAD_ERR_OK) {
			$tmpname = $_FILES['userfile']['tmp_name'];
			$target_file = $updir . basename($_FILES["userfile"]["name"]);
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			//check if file has been uploaded and if image is a jpg
			if (is_uploaded_file($_FILES['userfile']['tmp_name'])){
				if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg"  && getimagesize($tmpname)){
					//check if file with same name already exists
					if(checkIfFileNotExists($updir,$target_file)){

						$clean['image'] = $_FILES['userfile']['tmp_name'];
						$newname = $updir . basename($_FILES["userfile"]["name"]);
						$tmpname = $clean['image'];
						if (move_uploaded_file($tmpname, $newname)){
							$confirm = "File uploaded!";
						}else{
							$confirm = "Your file has not been uploaded, please try again!";
						}
					}else { 
						$error = "You already uploaded a logo with the same name, please change name of the file!";
					}
				}else{
					$error .= "File is not a correct format. Please use JPG, png or gif.";
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
	$count = 0;
	foreach($files as $file){
		//set name of file
		$filename = $updir.$file;
		$out_img_file =  '../footer-uploads/'.$file;
		//required width/height
		$req_width = 200;
		$req_height = 200;
		$imageFileType = pathinfo($filename,PATHINFO_EXTENSION);
		if ($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "JPEG" || $imageFileType == "JPG"){
		//the output is generated here if JPG
			if (img_resize($filename, $filename, $req_width, $req_height) == true){
				//get details of image
				$details = getimagesize($filename);
				$width = $details[0];
				$height = $details[1];
				//the html output
				if (($count != 0) AND (($count % 4) == 0)){
					$html_output .= '</div><div class = "row images-preview">';
				}
				$count++;
				$html_output .= containerThumbsFooter($out_img_file, $width, $height,str_replace("../","",$out_img_file));
				
			}
		}

		if ($imageFileType == "png"){
		//the output is generated here if PNG
			if (img_resize_png($filename, $filename, $req_width, $req_height) == true){
				//get details of image
				$details = getimagesize($filename);
				$width = $details[0];
				$height = $details[1];
				//the html output
				if (($count != 0) AND (($count % 4) == 0)){
					$html_output .= '</div><div class = "row images-preview">';
				}
				$count++;
				$html_output .= containerThumbsFooter($out_img_file, $width, $height,str_replace("../","",$out_img_file));
				
			}
		}
	}
	if(isset($_POST['submit_central'])){
		if(isset($_POST['title_footer_central'],$_POST['text-footer-central'])){
			$title1 = htmLawed($_POST['title_footer_central']);
			$content1 = htmLawed($_POST['text-footer-central']);
			if(empty($title1) || empty($content1)){
				$error_footer_central = "All field are required!";
			}else{
				$query = $dbh->prepare("UPDATE footer_central SET footer_title = (?), footer_links = (?) WHERE footer_id = 1;");
				$query->bindValue(1,$title1);
				$query->bindValue(2,$content1);
				$query->execute();
				header('Location: ../index.php');
			}
		}
	}
	if(isset($_POST['submit_right'])){
		if(isset($_POST['title_footer_right'],$_POST['text-footer-right'])){
			$title2 = htmLawed($_POST['title_footer_right']);
			$content2 = htmLawed($_POST['text-footer-right']);
			if(empty($title2) || empty($content2)){
				$error_footer_right = "All field are required!";
			}else{
				$query = $dbh->prepare("UPDATE footer_right SET footer_title = (?), footer_text = (?) WHERE footer_id = 1;");
				$query->bindValue(1,$title2);
				$query->bindValue(2,$content2);
				$query->execute();
				header('Location: ../index.php');
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<?php
	$title = "Change Footer Image";
	get_head_admin($title)?>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
	<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
    <script src="../js/editor.js"></script>
	</head>
  	<body class = "admin">
  		<div class= "admin-bar">
	  		<div class="top-cms">
	            <p class = "dashboard"><a href = "index.php" id = "logo">AMALIA CMS</a></p>
    			<p class = "live"><a href = "../index.php">GO TO WEBSITE</a></p>
	        </div><!--/.top-cms-->
	    </div><!--/.admin-bar-->
        <div class = "container">
            <div class = "row">
                <div class="col-md-12 footer-upload-cont">
                	<h4>1. Change your logo on the footer</h4>
                	<h5>Please upload the logo you wish to use on your footer. It will apply once you click on it.</h5>
                	<?php echo "<p>".$confirm."</p>";
						if(isset($error)){ ?>
                			<small><?php echo '<p class = "error">'.$error.'</p>' ?></small>
                	<?php } ?>
	                <form enctype="multipart/form-data" action="change_footer.php" method="post">
						<div class="form-group">
							<label>Upload your image:</label> 
							<input name="userfile" type="file" />
						</div><!--/.form-group-->
						<p>
							<input type="submit" class="btn btn-default" name="fileupload" value="Upload!" />
						</p>
					</form>
            		<div class = "row logo-preview">
                	<?php 
                		if(!empty($html_output)){ ?>
                			<?php echo $html_output; ?>
                	<?php } ?>
                	</div><!--/.row logo-preview-->
                </div><!--/.col-md-12 footer-upload-cont-->
        	</div><!--/.row-->
        	<div class = "row">
                <div class="col-md-6 footer-upload-cont">
                	<h4>2. This is the central section of your footer</h4>
		                <?php if(isset($error_footer_central)){ ?>
		                		<small class = "error"><?php echo $error_footer_central; ?></small>
		                <?php } ?>
	                <form action = "change_footer.php" method = "post" autocomplete ="off">
					  	<div class="form-group">
					    	<label for="title">Insert your title for the central part of the footer</label>
					    <input type="text" class="form-control" id="title" name = "title_footer_central" placeholder="Title" value="<?php echo $footer_central_fetch['footer_title']?>">
					  	</div>
					  	<!--TINYMCE EDITOR-->
					  	<div class="form-group">
					  		<label for="text-footer-central">Please insert the text with links in this area</label>
					  		<textarea id="text-footer-central" name = "text-footer-central"><?php echo $footer_central_fetch['footer_links']?></textarea>
					  	</div>
					  	<button type="submit" class="btn btn-default" name = "submit_central" >Submit</button>
					</form>
                </div><!--/.col-md-12 footer-upload-cont-->
				<!--RIGHT CONTAINER OF THE FOOTER-->
                <div class="col-md-6 footer-upload-cont">
                	<h4>3. This is the right section of your footer</h4>
		                <?php if(isset($error_footer_right)){ ?>
		                		<small class = "error"><?php echo $error_footer_right; ?></small>
		                <?php } ?>
	                <form action = "change_footer.php" method = "post" autocomplete ="off">
					  	<div class="form-group">
					    	<label for="title">Insert your title for the right part of the footer</label>
					    <input type="text" class="form-control" id="title" name = "title_footer_right" placeholder="Title" value="<?php echo $footer_right_fetch['footer_title']?>">
					  	</div>
					  	<!--TINYMCE EDITOR-->
					  	<div class="form-group">
					  		<label for="text-footer-right">Please insert the text for the right part of the footer</label>
					  		<textarea id="text-footer-right" name = "text-footer-right"><?php echo $footer_right_fetch['footer_text']?></textarea>
					  	</div>
					  	<button type="submit" class="btn btn-default" name = "submit_right" >Submit</button>
					</form>
                </div><!--/.col-md-12 footer-upload-cont-->
        	</div><!--/.row-->
        </div><!--/.container-->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	    <script src="https://use.fontawesome.com/c3d662bdd1.js"></script>
	    <script src="js/script_admin.js"></script>
	</body>
</html>
<?php }else{
	header('Location: index.php');
}
?>