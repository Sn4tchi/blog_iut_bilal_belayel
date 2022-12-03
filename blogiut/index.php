<!DOCTYPE html>
<html lang="en">
<?php require './configue/init.conf.php' ?>
    <?php include 'includes/header.php'?>
    <body>
        <!-- Responsive navbar-->
        <?php include 'includes/menu.php'?>
        <!-- Page content-->
        <div class="container">
            <div class="text-center mt-5">
                <h1>A Bootstrap 5 Starter Template</h1>
                <p class="lead">A complete project boilerplate built with Bootstrap</p>
                <p>Bootstrap v5.1.3</p>
            </div>
           
            <nav aria-label="...">
                
                <ul class="pagination pagination-sm">
                
                    <li class="page-item active" aria-current="page"> <span class="page-link">1</span> </li>

                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                
                </ul>
                
            </nav>
           
           <?php
        
        
                $page = !empty($_GET['page']) ? $_GET['page'] : 1;

                $articlesManager = new articlesManager($bdd);
                $nbArticlesTotalAPublie = $articlesManager->countArticles();

                $nbPages = ceil($nbArticlesTotalAPublie / nb_articles_par_page);

                $indexDepart = ($page - 1) * nb_articles_par_page;

                $listeArticles = $articlesManager->getListArticlesAAfficher($indexDepart, nb_articles_par_page);

//print_r2($listeArticles);
//var_dump($bdd);
        
        ?>
            <?php
                if(isset($_SESSION['notification'])){
                    ?>
               
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-<?=$_SESSION["notification"]["result"]?>" role="alert">
                        <?= $_SESSION['notification']['message']?>
                        <?php unset($_SESSION['notification']) ?>
                    </div>
                </div>
            </div>
            <?php 
        } ?>
            <div class="row">
                <?php 
                    $articlesManager = new articlesManager($bdd);
                    $listeArticles=$articlesManager->getList();
                    foreach($listeArticles as $articles){
                    /*@var $articles articles */
                    $articles->getTitre(). '<br/>';
                ?>   
                <div class="col-6 mb-5">
                    <div class="card">
                        <img src="img/<?= $articles->getId()?>.jpg" style="max-width: 200px;" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?= $articles->getTitre() ?></h5>
                            <p class="card-text"><?= $articles->getTexte() ?></p>
                            <a href="#" class="btn btn-primary"><?= $articles->getDate() ?></a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
         </div>


       

        <!-- footer -->
        <?php include 'includes/footer.php'?>


    </body>
</html>
