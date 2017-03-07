<?php
session_start();
include_once('../includes/connection.php');
include_once('../includes/pages_class.php');
include_once('../includes/functions.php');

if(isset($_SESSION['logged_in'])){ ?>
	<?php
		$pages = new Pages;
    	$pages_fetch = $pages->fetch_all();

    	$article = new Articles;
    	$article_fetch = $article->fetch_all();
?>
<!DOCTYPE html>
<html lang="en">
<?php
$title = "Index page";
get_head_admin($title)?>
</head>
  	<body class = "admin">
    	<header>
    		<div class="top-cms">
            	<p class = "dashboard"><a href = "index.php" id = "logo">AMALIA CMS</a></p>
    			<p class = "live"><a href = "../index.php">GO TO WEBSITE</a></p>
        	</div>
    	</header>
			<div class = "container">
				<div class="row">
        		<div class="col-md-12 logo-container">
        			<div class = "logo-wrapper">
        				<img class = "logo-img" src="../persistent-images/logo3.png" width = "300" height = "88" />
        			</div><!--/.logo-wrapper-->
        		</div><!--col-md-12 logo-container-->
    		</div><!--.row-->
            <div class="row form-container-admin table-row">
            	<div class="col-md-6">
          			<p><a href = "change_header.php">1. Change header</a></p>
                	<p><a href = "change_slider.php">2. Change slider image</a></p>
                	<p class = "modify">3. Modify your pages
                		<span class="glyphicon glyphicon-chevron-up rotate" aria-hidden="true"></span>
                	</p>
        			<?php foreach($pages_fetch as $page) { ?>
						<p class = "reveal-modify"><a href ="modify.php?id= <?php echo $page['pages_id'] ?>"><?php echo $page['pages_title'] ?></a></p>
        			<?php } ?>
                	<p><a href = "add.php">4. Add page</a></p>
                	<p><a href = "delete.php">5. Delete page or article</a></p>
                </div><!--/.col-md-6-->
                <div class="col-md-6">
                	<p><a href = "add_article.php">6. Add Article</a></p>
                	<p class = "modify">7. Modify your Articles<span class="glyphicon glyphicon-chevron-up rotate" aria-hidden="true"></span></p>
        			<?php foreach($article_fetch as $article) { ?>
						<p class = "reveal-modify"><a href ="modify_article.php?id= <?php echo $article['articles_id'] ?>"><?php echo $article['articles_title'] ?></a></p>
        			<?php } ?>
                	<p><a href = "your_image.php">8. Your images</a></p>
                	<p><a href = "change_footer.php">9. Change footer</a></p>
                	<p><a href = "subscribers.php">10. Your Subscribers</a></p>
                	<p><a href = "logout.php">11. Logout</a></p>
                </div><!--/.col-md-6-->
            </div><!--/.row form-container-admin table-row-->
        </div><!--/.container-->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	    <!-- Latest compiled and minified JavaScript -->
	    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	    <script src="js/script_admin.js"></script>
  	</body>
</html>
<?php }else{
	if(isset($_POST['username'],$_POST['password'])){
		$username = $_POST['username'];
		$query = $dbh->prepare("SELECT user_salt FROM user_table");
		$query->execute();
		$salt = $query->fetch();
		//add salt to password. the salt was stored when the user first registered
		$password = hash('sha256', $_POST['password'] . $salt['user_salt']);
		if(empty($username) and empty($password)){
			$error = "All fields are required!";
		}else{
			$query = $dbh->prepare("SELECT * FROM user_table WHERE user_name = ? AND user_password = ?");
			$query->bindValue(1,$username);
			$query->bindValue(2,$password);
			$query->execute();

			$num = $query->rowCount();
			if($num == 1){
				$_SESSION['logged_in'] = true;
				header('Location: ../index.php');
				die();
			}else{
				$error = "Incorrect Details";
			}
		}
}
?>
<!DOCTYPE html>
<html lang="en">
	<?php
	$title = "Index page";
	get_head_admin($title)?>
	</head>
  	<body>
        <div class = "container">
            <div class="row">
        		<div class="col-md-12 logo-container">
        			<div class = "logo-wrapper">
        				<img class = "logo-img" src="../persistent-images/logo3.png" width = "300" height = "88" />
        			</div><!--/.logo-wrapper-->
        		</div><!--/.col-md-12 logo-container-->
    		</div><!--/.row-->
    		<div class = "row intro">
    			<div class="col-md-12 login-form">
                	<form action = "index.php" method = "post" autocomplete = "off">
                		<div class="form-group">
					    	<label for="username">Insert your Username</label>
					    	<input type="text" class="form-control" id="username" name = "username" placeholder="Username">
					  	</div>
					  	<div class="form-group">
					  		<label for="password">Insert your password</label>
					    	<input type = "password" class="form-control" id="password" name ="password" placeholder = "Password">
					  	</div>
					  	<button type="submit" class="btn btn-default">Login</button>
                	</form>
                	<?php if(isset($error)){ ?>
                	<small class = "error"><?php echo $error; ?></small>
                	<?php } ?> 
                	<p>First time user? Please register <a href = "register.php">here</a> and start using Amalia CMS</p>
        		</div><!-- /.col-md-12 login-form -->
        	</div><!-- /.row intro -->
    	</div><!-- /.container -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  	</body>
</html>
<?php
} ?>