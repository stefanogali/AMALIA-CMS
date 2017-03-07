<?php
	$logo = new Logo;
    $logo_fetch = $logo->get_logo();
    $icon = new Icons;
    $icon_fetch = $icon->get_icon_tag();
?>
<header>
    <div class = "container">
        <div class="row">
            <div class="col-md-12 logo-container">
                <hr>
            	<div class = "logo-wrapper">
            		<a href = "index.php"><img class = "logo-img" src="<?php  echo $logo_fetch['logo_address'] ?>" /></a>
            	</div><!--/.logo-wrapper-->
            </div>
        <div class = "social-icons">
        <?php foreach($icon_fetch as $icon_tag) {?>
                    <a href ="<?php echo $icon_tag['icon_url']; ?>" target = "_blank"><?php echo $icon_tag['icons_tag']; ?></a>
        <?php } ?>
        </div><!--/.social-icons-->