<!DOCTYPE html> 
<html lang="en">
<?php require './configue/init.conf.php' ?>
    <?php include 'includes/header.php'?>
    
    
    <?php 
        if(!empty($_POST['bouton'])){
            //print_r2($_POST);
            $articles = new articles();
            $articles->hydrate($_POST);
            $articles->setDate(date('Y-m-d'));
            //print_r2($articles);
            //print_r2($_FILES);

            $articlesManager =  new articlesManager ($bdd);     
            $listeArticles = $articlesManager->add($articles);
            //print_r2($listeArticles);

            if($articlesManager->get_result()==true){
                if($_FILES['image']['error'] == 0){
                    $nomImage = $articlesManager->get_getLastInsertId();
                    move_uploaded_file($_FILES['image']['tmp_name'],__DIR__."/img/".$nomImage.".jpg");
                }
            }



            $messageNotification = $articlesManager->get_result() == true ? "votre article a été ajouté" : "votre article n'a pas été ajouter";
            $resultNotification = $articlesManager->get_result() == true ? "success" : "danger";

            $_SESSION['notification']['result'] = $resultNotification;
            $_SESSION['notification']['message'] = $messageNotification ;



            header("location: index.php");
            exit();
        }
        ?>


    <body>
        <!-- Responsive navbar-->
        <?php include 'includes/menu.php'?>


        <!-- Page content-->
        <div class="container">
            <div class="text-center mt-5">
                <h1>Articles</h1>
                <p class="lead">Ajouter un articles</p>
                <p>Bootstrap v5.1.3</p>
            </div>
        </div>
        <div class="row">
            <div class="col-6 offset-3">
                <form method="POST" action="articles.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="titre" class="form-label" required>Titre</label>
                        <input type="text" name="titre" class="form-control" id="titre">
                    </div>
                    <div class="form-group">
                        <label for="textarea" class="form-label">le text de mon article</label>
                        <textarea class="form-control" name="texte" placeholder="Leave a comment here" id="textarea" style="height: 100px" require></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="imageFile" class="form-label">inserer votre image</label>
                        <input class="form-control" name="image" type="file" id="imageFile" name="fichier">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="publie" type="checkbox" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Article a publier ?
                        </label>
                    </div>
                    <button type="submit"  class="btn btn-primary" name="bouton" value="envoyer">Submit</button>
                </form>
            </div>
        </div>
       

        <!-- footer -->
        <?php include 'includes/footer.php'?>

    </body>
</html>