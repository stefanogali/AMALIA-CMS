<?php
session_start();
include_once('../includes/connection.php');
include_once('../includes/config.inc.php');
include_once('../includes/functions.php');

$clean = array();
$error = '';
$updir = $config['upload_dir'];
$html_output = '';
$confirm = '';
$is_jpg = false;
$is_png = false;
$logo_to_delete ='';

if (isset($_SESSION['logged_in'])){
	//delete logo from upload folder if it is seton the url
	if(isset($_GET['delete'])){
		$logo_to_delete = $_GET['delete'];
		$logo_to_delete = str_replace("uploads/","",$logo_to_delete);
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
		$out_img_file =  '../uploads/'.$file;
		//required width/height
		$req_width = 300;
		$req_height = 250;
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
				$html_output .= containerThumbs($out_img_file, $width, $height,str_replace("../","",$out_img_file));
				
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
				$html_output .= containerThumbs($out_img_file, $width, $height,str_replace("../","",$out_img_file));
				
			}
		}
	}
	//get value of selected checkbox and set 1(TRUE) on db
	if (isset($_POST['icons'])) {
		if(isset($_POST['icon_checked'])){
  			if (is_array($_POST['icon_checked'])) {
  				$icon = $_POST['icon_checked'];
  				if (check_url($icon['url'])){
  					$query = $dbh->prepare("UPDATE social_icons SET icon_selected = 0, icon_url = '' ");
					$query->execute();
				
    				foreach($icon['url'] as $value=>$url){
							$query = $dbh->prepare("UPDATE social_icons SET icon_selected = 1, icon_url = (?) WHERE icons_id = ?");
							$query->bindValue(1,$url);
							$query->bindValue(2,$value+1);
							$query->execute();
    				}
  				}
			}

		}
	}
	?>
<!DOCTYPE html>
<html lang="en">
	<?php
	$title = "Change Header Image";
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
                <div class="col-md-12 logo-upload-cont">
                	<h4>1. Change your logo on the header</h4>
                	<h5>Please upload the logo you wish to use on your header. It will apply once you click on it.</h5>
                	<?php echo "<p>".$confirm."</p>";
						if(isset($error)){ ?>
                			<small><?php echo '<p class = "error">'.$error.'</p>' ?></small>
                	<?php } ?>
	                <form enctype="multipart/form-data" action="change_header.php" method="post">
						<div class="form-group">
							<label>Upload your image:</label> 
							<input name="userfile" type="file" />
						</div>
						<p>
							<input type="submit" class="btn btn-default" name="fileupload" value="Upload!" />
						</p>
					</form>
            		<div class = "row logo-preview">
                	<?php 
                		if(!empty($html_output)){ ?>
                			<?php echo $html_output; ?>
                	<?php } ?>
                	</div><!--./row logo-preview-->
                </div><!--col-md-12 logo-upload-cont-->
                <div class="col-md-12">
                	<h4>2. Your Social Icons</h4>
                	<h5>Please tick the checkbox on the Social Icons you wish to use, then click the "Use Icons" button!</h5>
                	<form action="change_header.php" method="post">
						<div class="icons-group">
							<i class="fa fa-facebook fa-2x" aria-hidden="true"></i>
							<input type="checkbox" class = "checkbox_icons" name="icon_checked[]" value="1">
							<input type="text" class = "social-url" name="icon_checked[url][]" placeholder="Url">
						</div>
						<div class="icons-group">
							<i class="fa fa-twitter fa-2x" aria-hidden="true"></i>
							<input type="checkbox" class = "checkbox_icons" name="icon_checked[]" value="2">
							<input type="text" class = "social-url" name="icon_checked[url][]" placeholder="Url">
						</div>
						<div class="icons-group">
							<i class="fa fa-google-plus fa-2x" aria-hidden="true"></i>
							<input type="checkbox" class = "checkbox_icons" name="icon_checked[]" value="3">
							<input type="text" class = "social-url" name="icon_checked[url][]" placeholder="Url">
						</div>
						<div class="icons-group">
							<i class="fa fa-youtube fa-2x" aria-hidden="true"></i>
							<input type="checkbox" class = "checkbox_icons" name="icon_checked[]" value="4">
							<input type="text" class = "social-url" name="icon_checked[url][]" placeholder="Url">
						</div>
						<div class="icons-group">	
							<i class="fa fa-pinterest fa-2x" aria-hidden="true"></i>
							<input type="checkbox" class = "checkbox_icons" name="icon_checked[]" value="5">
							<input type="text" class = "social-url" name="icon_checked[url][]" placeholder="Url">
						</div>
						<div class="icons-group">
							<i class="fa fa-linkedin fa-2x" aria-hidden="true"></i>
							<input type="checkbox" class = "checkbox_icons" name="icon_checked[]" value="6">
							<input type="text" class = "social-url" name="icon_checked[url][]" placeholder="Url">
						</div>
						<div class="icons-group">	
							<i class="fa fa-github fa-2x" aria-hidden="true"></i>
							<input type="checkbox" class = "checkbox_icons" name="icon_checked[]" value="7">
							<input type="text" class = "social-url" name="icon_checked[url][]" placeholder="Url">
						</div>
						<div class = "icons-button">
							<input type="submit" class="btn btn-default" name="icons" value="Use Icons!" />
						</div>
					</form>
                </div><!--col-md-12-->
        	</div><!--/.row-->
        </div><!--container-->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	    <script src="https://use.fontawesome.com/c3d662bdd1.js"></script>
	    <script src="js/script_admin.js"></script>
  	</body>
</html>
<?php 
}else{
	header('Location: index.php');
}
?>