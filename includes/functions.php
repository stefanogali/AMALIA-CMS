<?php
function get_head($page_title){ ?>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $page_title; ?></title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Lobster|Open+Sans" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="assets/slick.css">
        <link rel="stylesheet" type="text/css" href="assets/slick-theme.css">
        <link rel="stylesheet" type="text/css" href="assets/style.css">
    </head>
<?php 
} ?>

<?php
function get_head_admin($page_title){ ?>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $page_title; ?></title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="../assets/style.css">
<?php 
} ?>

<?php
function get_nav_bar($pages_fetched,$id){ ?>
    <hr class = "line-afternav">
    <div class="container">
	   <nav class="navbar navbar-default">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php foreach($pages_fetched as $page) { ?>
                        <li role="presentation" 
                            <?php if ($id == $page['pages_id']){
                                //add class active to li
                                echo 'class = "active-link"';
                            } ?> 
                        ><?php if ($page['pages_id'] == 1){?>
                                    <a href = "index.php">
                        <?php  }else{ ?>
                                    <a href = "pages.php?id=<?php echo $page['pages_id'] ?>">
                         <?php }?>
                        <?php echo $page['pages_title'] ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </div><!-- /.container-fluid -->
<?php
} ?>

<?php
function openFolder($dir_name){
    $files = array(); 
    if (is_dir($dir_name)) {
        $handle = opendir($dir_name);
        while(false !== ($file = readdir($handle))){
            if ($file != "." && $file != ".."){
                $files[] = $file;
            }
        }
        closedir($handle);
        return $files;
    }
}
//function to print the html for the thumbnails on Change_header.php
function containerThumbs($name, $width, $height,$file_name){
    $output = '<div class="col-md-3">
              <a href = "../index.php?logo_img='.$file_name.'"><img class="img-thumbnail" src="'.$name.'" width="'.$width.'" height="'.$height.'" /></a>'
              .'<p><a class ="confirm" href = "change_header.php?delete='.$file_name.'">Delete</a></p></div><div id="dialog1" title="Please confirm" hidden="hidden">Are you sure you want to delete this image?</div>'. PHP_EOL;
    return $output;
}

//function to print the html for the thumbnails on Change_footer.php
function containerThumbsFooter($name, $width, $height,$file_name){
    $output = '<div class="col-md-3">
              <a href = "../index.php?footer_img='.$file_name.'"><img class="img-thumbnail" src="'.$name.'" width="'.$width.'" height="'.$height.'" /></a>'
              .'<p><a class ="confirm" href = "change_footer.php?delete='.$file_name.'">Delete</a></p></div><div id="dialog1" title="Please confirm" hidden="hidden">Are you sure you want to delete this image?</div>'. PHP_EOL;
    return $output;
}

//function to print the html for the sliders
function containerImageSlider($name, $width, $height, $count){
    $output = '<div class="col-md-6">
              <img class="img-slider" src="'.$name.'" width="'.$width.'" height="'.$height.'" />'
              .'<p class = "delete-sliderimg-link">This is the image '.$count.' of your slider.</p>
              <p><a class ="confirm" href = "change_slider.php?delete='.$count.'">Delete</a></p></div><div id="dialog1" title="Please confirm" hidden="hidden">Are you sure you want to delete this image?</div>'. PHP_EOL;
    return $output;
}

//function to print the html for the images thumbnails
function containerImageThumbs($name, $width, $height, $file_name){
    $output = '<div class="col-md-3">
              <img class="img-thumbnail" src="'.$name.'" width="'.$width.'" height="'.$height.'" />'
              .'<figcaption><small><b>Url of the image: </b>'.'../'.$file_name.'</small></figcaption>'
              .'<p><a class ="confirm" href = "your_image.php?delete='.$file_name.'">Delete</a></p></div><div id="dialog1" title="Please confirm" hidden="hidden">Are you sure you want to delete this image?</div>'. PHP_EOL;
    return $output;
}
//function to resize image jpg (returns true or false)
function img_resize($in_img_file, $out_img_file, $req_width, $req_height) {
    // Get image file details
    $details = getimagesize($in_img_file);
    if ($details !== false) {
        $width = $details[0];
        $height = $details[1];
        //keep aspect ratio while resizing and set the new width and height in their respective variables
        $source_aspect_ratio = $width / $height;
        $thumbnail_aspect_ratio = $req_width / $req_height;
        if ($width <= $req_width && $height <= $req_height) {
            $new_width = $width;
            $new_height = $height;
        }elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
            $new_width = (int) ($req_height * $source_aspect_ratio);
            $new_height = $req_height;
        } else {
            $new_width = $req_width;
            $new_height = (int) ($req_width / $source_aspect_ratio);
        }
        //create a new canvas, resize image and save in the folder passed as an argument 
        $new = imagecreatetruecolor($new_width, $new_height);
        $src = imagecreatefromjpeg($in_img_file);
        imagecopyresampled($new, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        imagejpeg($new, $out_img_file, 90);
        imagedestroy($src);
        imagedestroy($new);
        return true;
    }else {
        return false;
    }
}

//function to resize image png (returns true or false)
function img_resize_png($in_img_file, $out_img_file, $req_width, $req_height) {
    // Get image file details
    $details = getimagesize($in_img_file);
    if ($details !== false) {
        $width = $details[0];
        $height = $details[1];
        //keep aspect ratio while resizing and set the new width and height in their respective variables
        $source_aspect_ratio = $width / $height;
        $thumbnail_aspect_ratio = $req_width / $req_height;
        if ($width <= $req_width && $height <= $req_height) {
            $new_width = $width;
            $new_height = $height;
        }elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
            $new_width = (int) ($req_height * $source_aspect_ratio);
            $new_height = $req_height;
        } else {
            $new_width = $req_width;
            $new_height = (int) ($req_width / $source_aspect_ratio);
        }
        //create a new canvas, resize image and save in the folder passed as an argument 
        $new = imagecreatetruecolor($new_width, $new_height);
        imagealphablending($new, false);
        imagesavealpha($new, true);
        $src = imagecreatefrompng($in_img_file);
        imagecopyresampled($new, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        imagepng($new, $out_img_file, 9);
        imagedestroy($src);
        imagedestroy($new);
        return true;
    }else {
        return false;
    }
}
//function to avoid file overwrite in case image already exists
function checkIfFileNotExists($dir,$file_in){
    //open directory, read through files and check if file already exists
    if (is_dir($dir)) {
        $handle = opendir($dir);
        while(false !== ($file = readdir($handle))){
                if(file_exists($file_in)){
                    return false;
                }else{
                    return true;
                }
        }
        closedir($handle);
    }
}

//function to avoid empty urls for icons
function check_url($array){
    foreach ($array as $value=>$key){
        if (!empty($key)){
            return true;
        }
    }
}
?>