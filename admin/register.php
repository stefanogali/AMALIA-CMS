<?php
session_start();
include_once('../includes/connection.php');
include_once('../includes/pages_class.php');
include_once('../includes/functions.php');
//register page da aggiustare
$execute_username = false;
$execute_password = false;
$error = '';
$white_space = false;

if(isset($_SESSION['logged_in'])){ 
		header('Location: index.php');
}else{
	if(isset($_POST['submit'])){
		if (isset($_POST['username_register']) && strlen($_POST['username_register'])>1){
   			$username = strip_tags(trim($_POST['username_register']));
   			while ((strpos($username, ' ') !== false) ){
				$username = str_replace( ' ', '', $username );
				$white_space = true;
				$error .= 'Username must not contain white space. ';
			}
			//$password = $_POST['password_register'];
			if ($username!='' && strlen($username) < 15){
				$execute_username = true;
			}else{
				$error .= 'Username in an invalid format. ';
			}
		}else{
			$error .= 'Username can\'t be blank. ';
		}
		if (isset($_POST['password_register']) && strlen($_POST['password_register'])>8){
   			$password = strip_tags(trim($_POST['password_register']));
   			while ((strpos($password, ' ') !== false) ){
				$password = str_replace( ' ', '', $password );
				$white_space = true;
				$error .= 'Password must not contain white space. ';
			}
			//$password = $_POST['password_register'];
			if ($password!='' && strlen($password) < 15){
				$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
				$password = hash('sha256', $_POST['password_register'] . $salt);
				$execute_password = true;
			}else{
				$error .= 'Password in an invalid format';
			}
		}else{
			$error .= 'Password can\'t be blank and must be more than 8 characters';
		}
		
	}
	if($execute_username AND $execute_password AND ($white_space != true)){
		$query = $dbh->prepare("SELECT * FROM user_table");
		$query->execute();

		$num = $query->rowCount();
		if($num == 1){
			$error = "You are already registered. Please insert your username and password <a class = \"redirect-login\" href = 'index.php'>here</a>";
		}else{
			//create all the necessary tables
			$query = $dbh->prepare(" CREATE TABLE IF NOT EXISTS articles_cms (
									   articles_id int(11) NOT NULL AUTO_INCREMENT,
									    articles_title varchar(255) DEFAULT NULL,
									    articles_content longtext,
									    articles_timestamp int(11) DEFAULT NULL,
									    articles_image varchar(250) DEFAULT NULL,
									    articles_img_width int(4) DEFAULT NULL,
									    articles_img_height int(4) DEFAULT NULL,
									    articles_update tinyint(1) NOT NULL DEFAULT 0,
									    PRIMARY KEY (articles_id)
									    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

									INSERT INTO articles_cms VALUES (1,'This is the first Article','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n<table style=\"width: 100%; border-color: black;\" border=\"1px\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 346.55px;\">&nbsp;<strong>Row 1</strong></td>\r\n<td style=\"width: 306.45px;\">&nbsp;Col1</td>\r\n<td style=\"width: 218px;\">&nbsp;Col2</td>\r\n<td style=\"width: 209px;\">&nbsp;Col3</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 346.55px;\">&nbsp;<strong>Row 2</strong></td>\r\n<td style=\"width: 306.45px;\">&nbsp;Col1</td>\r\n<td style=\"width: 218px;\">&nbsp;Col2</td>\r\n<td style=\"width: 209px;\">&nbsp;Col3</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 346.55px;\">&nbsp;<strong>Row 3</strong></td>\r\n<td style=\"width: 306.45px;\">&nbsp;Col1</td>\r\n<td style=\"width: 218px;\">&nbsp;Col2</td>\r\n<td style=\"width: 209px;\">&nbsp;Col3</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>\r\n<h3>You can add also videos!</h3>\r\n<p><iframe src=\"//www.youtube.com/embed/8miotqEVeSo\" width=\"560\" height=\"314\" allowfullscreen=\"allowfullscreen\"></iframe></p>',1487959677,'images/img1.jpg',1170,500,0);
										
										CREATE TABLE IF NOT EXISTS footer_central (
										  footer_id int(11) NOT NULL AUTO_INCREMENT,
										  footer_title varchar(45) NOT NULL,
										  footer_links varchar(850) NOT NULL,
										  PRIMARY KEY (footer_id)
										) ENGINE=InnoDB DEFAULT CHARSET=latin1;

										INSERT INTO footer_central VALUES (1,'Usefull Links','<p><a href=\"https://moodle.bbk.ac.uk/\" target=\"_blank\" rel=\"noopener noreferrer\">Link number 1</a></p>\r\n<p><a href=\"https://moodle.bbk.ac.uk/\" target=\"_blank\" rel=\"noopener noreferrer\">Link 2</a></p>\r\n<p><a href=\"https://moodle.bbk.ac.uk/\" target=\"_blank\" rel=\"noopener noreferrer\">Links 3</a></p>\r\n<p><a href=\"https://moodle.bbk.ac.uk/\" target=\"_blank\" rel=\"noopener noreferrer\">Links here</a></p>');
											
										CREATE TABLE IF NOT EXISTS footer_right (
											  footer_id int(11) NOT NULL AUTO_INCREMENT,
											  footer_title varchar(45) NOT NULL,
											  footer_text varchar(800) DEFAULT NULL,
											  PRIMARY KEY (footer_id)
											) ENGINE=InnoDB DEFAULT CHARSET=latin1;

										INSERT INTO footer_right VALUES (1,'Contacts','<p><img src=\"../persistent-images/tel4black.png\" alt=\"image\" /> 0207 777 88 230</p>\r\n<p><img src=\"../persistent-images/emailblack.png\" alt=\"image\" /> email@example.com</p>\r\n<p><img src=\"../persistent-images/addressblack.png\" alt=\"image\" /> 55 King\'s road - London UK</p>');
										
										CREATE TABLE pages_cms (
										  pages_id int(11) NOT NULL AUTO_INCREMENT,
										  pages_title varchar(255) DEFAULT NULL,
										  pages_content longtext,
										  pages_timestamp int(11) DEFAULT NULL,
										  pages_update tinyint(1) NOT NULL DEFAULT 0,
										  PRIMARY KEY (pages_id)
										) ENGINE=InnoDB DEFAULT CHARSET=latin1;

										INSERT INTO pages_cms VALUES (1,'Home','<p><span style=\"font-size: 10pt;\">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem<a href=\"https://www.google.co.uk/?gws_rd=ssl\" target=\"_blank\" rel=\"noopener noreferrer\"> ipsum quia dolor sit amet</a>, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</span></p>\r\n<p><span style=\"font-family: \'Open Sans\',Arial,sans-serif; font-size: 10pt; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; display: inline ! important; float: none;\">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae.</span></p>\r\n<h1>Header 1</h1>\r\n<h2>Header 2</h2>\r\n<h3>Header 3</h3>\r\n<h4>Header 4</h4>\r\n<h5>Header 5</h5>\r\n<blockquote>\r\n<p><em>This is a blockquote example in italic</em></p>\r\n</blockquote>\r\n<p><span style=\"font-size: 10pt;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.<span style=\"background-color: #ffff99;\"><strong>Duis aute irure</strong> dolor in reprehenderit</span> in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia <span style=\"color: #808000;\">deserunt mollit</span> anim id est laborum.</span></p>\r\n<p><img class=\"size-max\" title=\"photographer-868106_640.jpg\" src=\"../images/img1488215088183.jpg\" alt=\"\" width=\"640\" height=\"425\" /></p>\r\n<p><span style=\"font-family: \'Open Sans\',Arial,sans-serif; font-size: 10pt; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; display: inline ! important; float: none;\">This is a numbered list:<br /></span></p>\r\n<ol>\r\n<li><span style=\"font-family: \'Open Sans\',Arial,sans-serif; font-size: 10pt; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; display: inline ! important; float: none;\">Number onew</span></li>\r\n<li><span style=\"font-family: \'Open Sans\',Arial,sans-serif; font-size: 10pt; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; display: inline ! important; float: none;\">Number two</span></li>\r\n<li><span style=\"font-family: \'Open Sans\',Arial,sans-serif; font-size: 10pt; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; display: inline ! important; float: none;\">Number 3</span></li>\r\n</ol>\r\n<p><span style=\"font-family: \'Open Sans\',Arial,sans-serif; font-size: 10pt; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; display: inline ! important; float: none;\">This is an unordered list:</span></p>\r\n<ul>\r\n<li><span style=\"font-family: \'Open Sans\',Arial,sans-serif; font-size: 10pt; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; display: inline ! important; float: none;\">List NUmber one</span></li>\r\n<li><span style=\"font-family: \'Open Sans\',Arial,sans-serif; font-size: 10pt; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; display: inline ! important; float: none;\">List Number two</span></li>\r\n<li><span style=\"font-family: \'Open Sans\',Arial,sans-serif; font-size: 10pt; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; display: inline ! important; float: none;\">List Number three</span></li>\r\n</ul>\r\n<p><span style=\"font-family: \'Open Sans\',Arial,sans-serif; font-size: 10pt; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; display: inline ! important; float: none;\">The following blocks are the articles that have been created with the CMS. <strong>The index file has preview containers.</strong></span></p>',1488216361,0);

											CREATE TABLE IF NOT EXISTS slider_images (
											  id_slider_img int(11) NOT NULL AUTO_INCREMENT,
											  url_slider_img varchar(45) NOT NULL,
											  PRIMARY KEY (id_slider_img)
											) ENGINE=InnoDB DEFAULT CHARSET=latin1;

											INSERT INTO slider_images VALUES (1,'slider-images/img1.jpg'),(2,'slider-images/img2.jpg'),(3,'slider-images/img3.jpg');

											CREATE TABLE IF NOT EXISTS social_icons (
											  icons_id int(11) NOT NULL AUTO_INCREMENT,
											  icons_tag varchar(250) DEFAULT NULL,
											  icon_selected tinyint(1) NOT NULL,
											  icon_url varchar(250) DEFAULT NULL,
											  PRIMARY KEY (icons_id)
											) ENGINE=InnoDB DEFAULT CHARSET=latin1;

											INSERT INTO social_icons VALUES (1,'<i class=\"fa fa-facebook fa-2x\" aria-hidden=\"true\"></i>',1,'https://www.facebook.com/'),(2,'<i class=\"fa fa-twitter fa-2x\" aria-hidden=\"true\"></i>',1,'https://twitter.com/'),(3,'<i class=\"fa fa-google-plus fa-2x\" aria-hidden=\"true\"></i>',1,'https://plus.google.com/collections/featured'),(4,'<i class=\"fa fa-youtube fa-2x\" aria-hidden=\"true\"></i>',1,'https://www.youtube.com/'),(5,'<i class=\"fa fa-pinterest fa-2x\" aria-hidden=\"true\"></i>',1,'https://uk.pinterest.com/'),(6,'<i class=\"fa fa-linkedin fa-2x\" aria-hidden=\"true\"></i>',1,'http://www.lipsum.com/'),(7,'<i class=\"fa fa-github fa-2x\" aria-hidden=\"true\"></i>',1,'https://github.com/');
											
											CREATE TABLE IF NOT EXISTS subscribers (
											  userId int(11) NOT NULL AUTO_INCREMENT,
											  fullName varchar(60) DEFAULT NULL,
											  userEmail varchar(60) NOT NULL,
											  subscriber_timestamp int(11) DEFAULT NULL,
											  PRIMARY KEY (userId),
											  UNIQUE KEY userEmail (userEmail)
											) ENGINE=InnoDB DEFAULT CHARSET=utf8;
											
											CREATE TABLE IF NOT EXISTS user_table (
											  user_id int(11) NOT NULL AUTO_INCREMENT,
											  user_name varchar(255) DEFAULT NULL,
											  user_password varchar(255) DEFAULT NULL,
											  user_salt varchar(16) DEFAULT NULL,
											  PRIMARY KEY (user_id)
											) ENGINE=InnoDB DEFAULT CHARSET=latin1;

											CREATE TABLE IF NOT EXISTS user_footer_logo (
											  logo_id int(11) NOT NULL AUTO_INCREMENT,
											  logo_address varchar(250) NOT NULL,
											  PRIMARY KEY (logo_id)
											) ENGINE=InnoDB DEFAULT CHARSET=latin1;

											INSERT INTO user_footer_logo VALUES (1,'footer-uploads/logo-footer.png');

											CREATE TABLE IF NOT EXISTS user_logo (
											  logo_id int(11) NOT NULL,
											  logo_address varchar(45) NOT NULL,
											  UNIQUE KEY logo_address (logo_address)
											) ENGINE=InnoDB DEFAULT CHARSET=latin1;

											INSERT INTO user_logo VALUES (1,'uploads/logo3.png');");

			if ($query->execute()) {
				$query->closeCursor();
				$register = new Pages;
				$register_user = $register->set_user($username, $password, $salt);
				$_SESSION['logged_in'] = true;
				header('Location: index.php');
				die();
			}else{
				echo "\nPDOStatement::errorInfo():\n";
				$arr = $query->errorInfo();
				print_r($arr);
				echo "Oops...something went wrong. Please check you have entered the correct details for the database credentials";

			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<?php
	$title = "Register page";
	get_head_admin($title)?>
	</head>
  	<body class = "admin">
    	<div class = "container">
    		<div class="row">
    			<div class="col-md-12 logo-container">
    				<div class = "logo-wrapper">
    					<img class = "logo-img" src="../persistent-images/logo3.png" width = "300" height = "88" />
    				</div><!--/.logo-wrapper-->
    			</div>
			</div>
            <div class = "row intro">
    			<div class="col-md-12 login-form">
	                <a href = "index.php" id = "logo">Login</a>
	                <form action = "register.php" method = "post" autocomplete = "off">
	                	<div class="form-group">
						    <label for="username">Set your Username</label>
						    <input type="text" class="form-control" id="username" name = "username_register" placeholder="Username" autocomplete="off">
					    </div>
					    <div class="form-group">
						  	<label for="password">Set your password</label>
						    <input type = "password" class="form-control" id="password" name ="password_register" placeholder = "Password" autocomplete="off">
					    </div>
					    <button name = "submit" type="submit" class="btn btn-default">Login</button>
	                </form>
	                <?php if(isset($error)){ ?>
	                	<small class = "error"><?php echo $error; ?></small>
	                <?php } ?>
	            </div><!--/.col-md-12 login-form -->
        	</div><!--/.row intro -->
        </div><!--/.container -->
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  	</body>
</html>
<?php
}
?>