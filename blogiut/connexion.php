<!DOCTYPE html> 
<html lang="en">
<?php require './configue/init.conf.php' ?>
<?php ?>
<?php include 'includes/header.php'?>
    
    
    <?php 
        if(!empty($_POST['bouton'])){
            //echo 'le formulaire est posté';
            //print_r2($_POST);
            //print_r2($_FILES);
            //Création de l'utilisateur
            $userFormulaire = new utilisateurs();
            $userFormulaire->hydrate($_POST);
            // print_r2($userFormulaire);


            $userManager = new userManager($bdd);
            $userEnBdd = $userManager->getByEmail($userFormulaire->getEmail());

            //print_r2($userEnBdd);

            $isConnect = password_verify($userFormulaire->getMdp(), $userEnBdd->getMdp());
            //print_r2($isConnect);

            //dump($isConnect);

            if ($isConnect == true) {
                $sid = md5($userEnBdd->getEmail() . time());
                //echo $sid;
                //Création du cookie
                setcookie('sid', $sid, time() + 86400);
                //Mise en bdd du sid
                $userEnBdd->setSid($sid);
                //dump($userEnBdd);
                $userManager->updateByEmail($userEnBdd);
                //dump($utilisateurManager->get_result());
            }

            if ($isConnect == true) {
                $_SESSION['notification']['result'] = 'success';
                $_SESSION['notification']['message'] = 'Vous êtes connecté !';
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['notification']['result'] = 'danger';
                 $_SESSION['notification']['message'] = 'Vérifiez votre login / mot de passe !';
                 header("Location: connexion.php");
                 exit();
             }
        }
        ?>


    <body>
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
        <!-- Responsive navbar-->
        <?php include 'includes/menu.php'?>


        <!-- Page content-->
        <div class="container">
            <div class="text-center mt-5">
                <h1>connexion</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-6 offset-3">
                <form method="POST" action="connexion.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse Email</label>
                        <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                        <label for="mdp" class="form-label" required>Mot De Passe</label>
                        <input type="password" name="mdp" class="form-control" id="mdp">
                    </div>
                    <button type="submit"  class="btn btn-primary" name="bouton" value="envoyer">Submit</button>
                </form>
            </div>
        </div>
       

        <!-- footer -->
        <?php include 'includes/footer.php'?>

    </body>
</html>