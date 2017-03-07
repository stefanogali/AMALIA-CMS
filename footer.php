<?php
    $logo_footer = new LogoFooter;
    $logo_fetch_footer = $logo_footer->get_logo();

    $footer_central = new FooterContainer1;
    $footer_central_fetch = $footer_central->fetch_all();

    $footer_right = new FooterContainer2;
    $footer_right_fetch = $footer_right->fetch_all();

?>
<footer>
	<div class="row match-cols">
	  	<div class="col-md-4">
            <div class = "logo-footer-wrapper">
  			   <img class = "logo-footer-img" src="<?php  echo $logo_fetch_footer['logo_address'] ?>" />
      		</div><!--/.logo-wrapper-->
	    </div><!--/.col-md-4-->
  		<div class="col-md-4">
            <div class = "container-footer-central">
                <h3><?php  echo $footer_central_fetch['footer_title'] ?></h3>
                <?php  echo $footer_central_fetch['footer_links'] ?>
            </div><!--/.container-footer-central-->
        </div><!--/.col-md-4-->
  		<div class="col-md-4">
            <div class = "container-footer-right">
                <h3><?php  echo $footer_right_fetch['footer_title'] ?></h3>
                <?php  echo str_replace("black.png", ".png",str_replace("../", "", $footer_right_fetch['footer_text'])) ?>
            </div><!--/.container-footer-right-->
        </div><!--/.col-md-4-->
	</div>
    <div class = "row bottom-footer">
        <div class="col-md-12">
            <p>Amalia CMS - created by <a href = "http://paninopanini.co.uk/" target = "_blank">paninopanini :)</a></p>
        </div>
    </div>
</footer>