<?php
session_start();
include_once('../includes/connection.php');
include_once('../includes/pages_class.php');
include_once('../includes/functions.php');
$page = new Pages;
$article = new Articles;

if (isset($_SESSION['logged_in'])){
	if(isset($_GET['page_id'])){
		if($_GET['page_id'] != 1){
			$id = $_GET['page_id'];
		}
		$query = $dbh->prepare("DELETE FROM pages_cms WHERE pages_id = ?;
			                    ALTER TABLE pages_cms AUTO_INCREMENT=1");
		$query->bindValue(1,$id);
		$query->execute();
		header('Location: delete.php');
			
	}
	if(isset($_GET['article_id'])){
		if($_GET['article_id'] != 1){
			$id = $_GET['article_id'];
		}
		$query = $dbh->prepare("DELETE FROM articles_cms WHERE articles_id = ?;
			                    ALTER TABLE articles_cms AUTO_INCREMENT=1");
		$query->bindValue(1,$id);
		$query->execute();
		header('Location: delete.php');
			
	}
	$pages = $page->fetch_All();
	$articles = $article->fetch_All();
?>
<!DOCTYPE html>
<html lang="en">
	<?php
	$title = "Delete a page";
	get_head_admin($title)?>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
	</head>
  	<body class = "admin">
    	<header>
    		<div class="top-cms">
    			<p class = "dashboard"><a href = "index.php" id = "logo">AMALIA CMS</a></p>
    			<p class = "live"><a href = "../index.php">GO TO WEBSITE</a></p>
			</div><!--/.top-cms-->
		</header>
        <div class = "container">
            <div class="row">
            	<div class="col-md-6">
                	<h4>Please select a page to delete</h4>
            		<form action = "delete.php" method = "get">
				 		<div class="form-group">
				 			<div id="dialog2" title="Please confirm" hidden="hidden">Are you sure you want to delete this page?
				 			</div>
				    			<select class="form-control delete-page" onchange = "confirmPageDelete(this)" name = "page_id">
				    			<?php
				    				foreach($pages as $page){ ?>
									<option value = "<?php echo $page['pages_id'];?>">
									<?php echo $page['pages_title'];?>
									</option>
				    			<?php } ?>
								</select>
						</div><!--/.form-group-->
					</form>
				</div><!--/.col-md-6-->
				<div class="col-md-6">
                	<h4>Please select an article to delete</h4>
            		<form action = "delete.php" method = "get">
				 		<div class="form-group">
				 			<div id="dialog3" title="Please confirm" hidden="hidden">Are you sure you want to delete this article?
				 			</div>
				    			<select class="form-control delete-article" onchange = "confirmArticleDelete(this)" name = "article_id">
				    			<?php
				    				foreach($articles as $article){ ?>
									<option value = "<?php echo $article['articles_id'];?>">
									<?php echo $article['articles_title'];?>
									</option>
				    			<?php } ?>
								</select>
						</div><!--/.form-group-->
					</form>
				</div><!--/.col-md-6-->
        	</div><!--/.row-->
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