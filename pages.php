<?php
session_start();
include_once('includes/connection.php');
include_once('includes/pages_class.php');
include_once('includes/functions.php');

$page = new Pages;
$pages_fetch = $page->fetch_all();
//get page id from query string
if(isset($_GET['id'])){
	$id = $_GET['id'];
	$data = $page->fetch_data($id);
?>
<!DOCTYPE html>
<html lang="en">
<?php get_head($data['pages_title'])?>
  <body>
	<?php
	if(isset($_SESSION['logged_in'])){ ?>
		<div class= "admin-bar">
			<div class="top-cms admin-top">
        		<p><a href = "admin">Admin</a></p>
    		</div><!--/.top-cms admin-top-->
		</div><!--/.admin-bar-->
		<?php } ?>
				<?php
					include('header.php')
				?>
	    		<!--get navbar from functions.php-->
				<?php get_nav_bar($pages_fetch,$id) ?>
				</div>
			</div>
		</header>
		<div class ="content">
		    <div class = "container">
		        <div class="row main-content">
		            <h1 class = "page-title"><?php echo $data['pages_title']; ?></h1><?php if (isset($_SESSION['logged_in'])){ ?><h4 class = "last-update"><small> Last Modified- <?php echo date('l jS', $data['pages_timestamp']) ?></small></h4><?php } ?>
		            <p><?php /*replace url for the images to display*/ echo str_replace("../","",$data['pages_content']); ?></p>
		            <a href = "index.php">&larr; Back</a>
		            <?php
	                include('footer.php')
	            	?>
		        </div><!--/. row main-content-->
		    </div><!--/. container-->
		</div><!--/. content-->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	    <!-- Latest compiled and minified JavaScript -->
	    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	    <script type="text/javascript" src="js/slick.min.js"></script>
	    <script src="https://use.fontawesome.com/c3d662bdd1.js"></script>
	    <script src="js/script.js"></script>
	</body>
</html>
<?php
}else{
	header('Location: index.php');
	exit();
}
?>