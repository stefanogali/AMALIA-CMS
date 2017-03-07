<?php
    session_start();
    include_once('includes/connection.php');
    include_once('includes/pages_class.php');
    include_once('includes/functions.php');
    $id = 1;
    $pages = new Pages;
    $pages_fetch = $pages->fetch_all();

    $index_content = $pages->fetch_index_page();

    //get url for images for slider in database
    $slider = new Slider;
    $img_fetch = $slider->get_slider_img();

    //get Articles content fromm DB
    $article = new Articles;
    $article_fetch = $article->fetch_all();
    
    if(isset($_GET['logo_img'])){
        $logo = $_GET['logo_img'];
        //set url for logo in database
        $query = $dbh->prepare("UPDATE user_logo SET logo_address = (?)");
        $query->bindValue(1,$logo);
        $query->execute();
    }
    if(isset($_GET['footer_img'])){
        $logo_footer = $_GET['footer_img'];
        //set url for logo footer in database
        $query = $dbh->prepare("UPDATE user_footer_logo SET logo_address = (?)");
        $query->bindValue(1,$logo_footer);
        $query->execute();
    }
?>
<!DOCTYPE html>
<html lang="en">
<?php get_head($index_content['pages_title'])?>
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
                <?php get_nav_bar($pages_fetch,$id) ?>
                </div><!--/.row-->
            </div><!--/.container-->
        </header>
        <div class ="content">
            <div class = "container">
                <div class="main-content">
                    <div class="row slider-content">
                        <div class="single-item">
                            <?php 
                                $count = 0;
                                foreach($img_fetch as $slider_img) { $count++;?>
                            <div>
                                <img src = "<?php echo $slider_img['url_slider_img'] ?>" alt = "slider image <?php echo $count ?>"/>
                            </div>
                            <?php } ?>
                        </div><!--/single-item-->
                    </div><!--/row slider content-->
                    <div class = "row">
                        <h1 class = "page-title"><?php echo $index_content['pages_title']; ?></h1><?php if (isset($_SESSION['logged_in'])){ ?><h4 class = "last-update"><small> Last Modified- <?php echo date('l jS', $index_content['pages_timestamp']) ?></small></h4><?php } ?>
                        <p><?php echo str_replace("../","",$index_content['pages_content']); ?></p>
                        <h2 class = "article-header">Your Articles</h2>
                    </div><!--/.row-->
                    <div class = "row article-container">
                        <?php 
                            $count_articles = 0;
                            foreach($article_fetch as $articles) {
                            if (($count_articles != 0) AND (($count_articles % 3) == 0)){ ?>
                    </div><!--/.row article-container-->
                    <div class="row article-container">
                        <?php }
                        $count_articles++; ?>
                        <div class="col-md-4">
                            <div class="thumbnail">
                                <img src="<?php echo $articles['articles_image']; ?>" alt="" width="<?php echo $articles['articles_img_width']; ?>" height="<?php echo $articles['articles_img_height']; ?>"/>
                                <div class="caption">
                                    <h3 class = "article-header-thumbnail"><?php echo $articles['articles_title']; ?></h3>
                                    <p><?php $content = strip_tags($articles['articles_content']);
                                        echo substr($content, 0, 200) . "..."; ?></p>
                                    <p><a class="btn btn-info" href="articles.php?id=<?php echo $count_articles; ?>">Visit Article</a></p>
                                </div><!--/.caption-->
                            </div><!--/.thumbnanail-->
                        </div><!--/.col-md-4-->
                        <?php } ?>
                    </div><!--/.row article-main-content-->
                <?php
                    include('footer.php')
                ?>
                </div><!--/.main-content-->
            </div><!--/.container-->
        </div><!--/.content-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/slick.min.js"></script>
        <script src="https://use.fontawesome.com/c3d662bdd1.js"></script>
        <script src="js/script.js"></script>
    </body>
</html>