<?php
session_start();
include_once('includes/connection.php');
include_once('includes/pages_class.php');
include_once('includes/functions.php');

$page = new Pages;
$pages_fetch = $page->fetch_all();

$article = new Articles;
$article_fetch = $article->fetch_all();
//get article id from query string
if(isset($_GET['id'])){
	$id = $_GET['id'];
	$data = $article->fetch_data($id);
?>
<!DOCTYPE html>
<html lang="en">
    <?php get_head($data['articles_title'])?>
    <body>
	  <?php
		if(isset($_SESSION['logged_in'])){ ?>
    <div class= "admin-bar">
    		<div class="top-cms admin-top">
            <p><a href = "admin">Admin</a></p>
        </div>
    </div>
	  <?php } ?>
	  <?php
		    include('header.php')
	   ?>
    <!--get navbar from functions.php-->
    	   <?php get_nav_bar($pages_fetch,0) ?>
    	     </div><!--/.row-->
        </div><!--/.container-->
    </header>
        <div class ="content">
            <div class = "container">
    	        <div class="main-content">
                    <div class = "row main-img-article">
                        <div class="col-md-12">
                            <div class = "entry-cover">
                                <div class="entry-cover-image" style="background-image: url('<?php echo $data['articles_image']; ?>');">
                                </div><!--/.entry-cover-image-->
                            </div><!--/.entry-cover-->
                        </div><!--/.col-md-12-->
                    </div><!--/.row-->
        	        <div class="row article-container">
	        	         <div class="col-md-8">
		                     <h1 class = "article-header"><?php echo $data['articles_title']; ?></h1><?php if (isset($_SESSION['logged_in'])){ ?><h4 class = "last-update"><small> Last Updated- <?php echo date('l jS', $data['articles_timestamp']) ?></small></h4><?php } ?>
		                     <p><?php /*replace url for the images to display*/ echo str_replace("../","",$data['articles_content']); ?></p>
		                     <a href = "index.php">&larr; Back</a>
		                  </div><!--/.col-md-8-->
		                  <div class="col-md-4 sidebar">
		                      <h2 class = "article-header-sidebar">All Your Articles</h2>
		                          <div class ="sidebar-container">
				                        <ul>
				            	              <?php foreach($article_fetch as $articles) { ?>
				            		            <li class = "article-list"><a href = "articles.php?id=<?php echo $articles['articles_id'] ?>"><?php echo $articles['articles_title']; ?> </a></li>
				            	              <?php } ?>
				                        </ul>
			                        </div><!--/.sidebar-container-->
			                        <h2 class = "article-header-sidebar">Subscribe to our newsletter</h2>
		                            <div class ="sidebar-container">
			                            <div class="form-container">
                                           <!-- form start -->
                                            <form method="post" role="form" id="register-form" autocomplete="off">
                                                <div class="form-header">
       	                                            <h3 class="form-title"></span> Sign Up</h3>
                                                </div><!--/.form-header-->
                                                <div class="form-body">
                                                    <div id="errorDiv"></div>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input name="name" type="text" id="name" class="form-control" placeholder="Name" maxlength="40">
                                                        </div>
                                                        <span class="help-block" id="error"></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input name="email" id="email" type="text" class="form-control" placeholder="Email" maxlength="50">
                                                        </div> 
                                                        <span class="help-block" id="error"></span>                     
                                                    </div>
                                                </div>
                                                <div class="form-footer">
                                                    <button type="submit" class="btn btn-info" id="btn-signup">
                                                        <span class="glyphicon glyphicon-log-in"></span> Sign Me Up
                                                    </button>
                                                </div>
                                            </form>
                                        </div><!--/.form-container-->
			                        </div><!--/.sidebar-container-->
		                        </div><!--/.col-md-4-->
		                    </div><!--/.row-->
                        <?php
                            include('footer.php')
                        ?>
                </div><!--/.row main-content-->
            </div><!--/.container-->
        </div><!--/.content -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/slick.min.js"></script>
        <script src="https://use.fontawesome.com/c3d662bdd1.js"></script>
        <script src="js/jquery.validate.min.js"></script>
        <script src="js/register.js"></script>
        <script src="js/script.js"></script>
    </body>
</html>
<?php }else{
	header('Location: index.php');
	exit();
}
?>