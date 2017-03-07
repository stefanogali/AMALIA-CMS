<?php
class Pages{
	public function fetch_all(){
		global $dbh;
		$query = $dbh->prepare("SELECT * FROM pages_cms");
		$query->execute();
		return $query->fetchAll();
	}

	public function fetch_data($page_id){
		global $dbh;
		$query = $dbh->prepare("SELECT * FROM pages_cms WHERE pages_id = ?");
		$query->bindValue(1, $page_id);
		$query->execute();
		return $query->fetch();
	}

	public function fetch_content_empty_id(){
		global $dbh;
		$query = $dbh->prepare("SELECT * FROM pages_cms WHERE pages_update = TRUE");
		$query->execute();
		return $query->fetch();
	}

	public function fetch_index_page(){
		global $dbh;
		$query = $dbh->prepare("SELECT * FROM pages_cms LIMIT 1");
		$query->execute();
		return $query->fetch();
	}

	public function set_user($user, $password, $salt){
		global $dbh;
		$query = $dbh->prepare("INSERT INTO user_table (user_name, user_password, user_salt) VALUES (?,?,?)");
		$query->bindValue(1,$user);
		$query->bindValue(2,$password);
		$query->bindValue(3,$salt);
		if($query->execute()){
			return true;
		}else{
			echo "\nPDOStatement::errorInfo():\n";
				$arr = $query->errorInfo();
				print_r($arr);
		}
	}
}
class Articles{
	public function fetch_all(){
		global $dbh;
		$query = $dbh->prepare("SELECT * FROM articles_cms");
		$query->execute();
		return $query->fetchAll();
	}
	public function fetch_data($article_id){
		global $dbh;
		$query = $dbh->prepare("SELECT * FROM articles_cms WHERE articles_id = ?");
		$query->bindValue(1, $article_id);
		$query->execute();
		return $query->fetch();
	}
	public function fetch_content_empty_id(){
		global $dbh;
		$query = $dbh->prepare("SELECT * FROM articles_cms WHERE articles_update = TRUE");
		$query->execute();
		return $query->fetch();
	}
}

class Logo{
	public function get_logo(){
		global $dbh;
		$query = $dbh->prepare("SELECT logo_address FROM user_logo WHERE logo_id = 1 LIMIT 1");
		$query->execute();
		return $query->fetch();
	}
}
class LogoFooter{
	public function get_logo(){
		global $dbh;
		$query = $dbh->prepare("SELECT logo_address FROM user_footer_logo WHERE logo_id = 1 LIMIT 1");
		$query->execute();
		return $query->fetch();
	}
}

class FooterContainer1{
	public function fetch_all(){
		global $dbh;
		$query = $dbh->prepare("SELECT * FROM footer_central LIMIT 1");
		$query->execute();
		return $query->fetch();
	}
}

class FooterContainer2{
	public function fetch_all(){
		global $dbh;
		$query = $dbh->prepare("SELECT * FROM footer_right LIMIT 1");
		$query->execute();
		return $query->fetch();
	}
}

class Slider{
	public function get_slider_img(){
		global $dbh;
		$query = $dbh->prepare("SELECT * FROM slider_images");
		$query->execute();
		return $query->fetchAll();
	}
}
class Icons{
	public function get_icon_tag(){
		global $dbh;
		$query = $dbh->prepare("SELECT * FROM social_icons WHERE icon_selected = 1");
		$query->execute();
		return $query->fetchAll();
	}
}
class Subscribers{
	public function fetch_all(){
		global $dbh;
		$query = $dbh->prepare("SELECT * FROM subscribers");
		$query->execute();
		return $query->fetchAll();
	}
}
?>