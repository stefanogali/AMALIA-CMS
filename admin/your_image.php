<?php
session_start();
include_once('../includes/connection.php');
include_once('../includes/config.inc.php');
include_once('../includes/functions.php');

$clean = array();
$error = '';
$updir = $config['images_dir'];
$html_output = '';
$confirm = '';
$is_jpg = false;
$is_png = false;
$image_to_delete ='';

if (isset($_SESSION['logged_in'])){
	//delete logo from upload folder if it is seton the url
	if(isset($_GET['delete'])){
		$image_to_delete = $_GET['delete'];
		$image_to_delete = str_replace("images/","",$image_to_delete);
		unlink($updir.$image_to_delete);
	}
	$files = openFolder($updir);
	$count = 0;
	foreach($files as $file){
		//set name of file
		$filename = $updir.$file;
		$out_img_file =  '../images/'.$file;
		//required width/height
		$req_width = 500;
		$req_height = 500;
		$imageFileType = pathinfo($filename,PATHINFO_EXTENSION);
		if ($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "JPG" || $imageFileType == "JPEG"){
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
				$html_output .= containerImageThumbs($out_img_file, $width, $height, str_replace("../","",$out_img_file));
				
			}
		}
		if ($imageFileType == "png" || $imageFileType == "PNG"){
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
				$html_output .= containerImageThumbs($out_img_file, $width, $height,str_replace("../","",$out_img_file));
				
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<?php
	$title = "Your Images";
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
	            <div class="col-md-12 img-upload-cont">
	            	<h4>Your images</h4>
	            	<h5>These are the images you currently uploaded in your folder. You can delete them or use the url below each image if needed.</h5>
					<div class = "row images-preview">
	            		<?php 
	            			if(!empty($html_output)){ ?>
	            				<?php echo $html_output; ?>
	            		<?php } ?>
	            	</div>
	            </div>
	    	</div>
	    </div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	    <script src="js/script_admin.js"></script>
	</body>
</html>
<?php }else{
	header('Location: index.php');
}
?>