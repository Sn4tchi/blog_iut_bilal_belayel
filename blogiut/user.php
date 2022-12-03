<!DOCTYPE html> 
<html lang="en">
<?php require './configue/init.conf.php' ?>
<?php ?>
<?php include 'includes/header.php'?>
    
    
    <?php 
        if(!empty($_POST['bouton'])){
            //print_r2($_POST);
            $user = new user();
            $user->hydrate($_POST);
            print_r2($user);
            //print_r2($_FILES);

            $userManager =  new userManager ($bdd); 
            
            $user->setMdp(password_hash($user->getMdp(), PASSWORD_DEFAULT));  

            $listeUtilisateurs = $userManager->add($user);
            //print_r2($listeUtilisateurs);

            $messageNotification = $userManager->get_result() == true ? "votre compte a été ajouté" : "votre compte n'a pas été ajouter";
            $resultNotification = $userManager->get_result() == true ? "success" : "danger";

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
                <h1>User</h1>
                <p class="lead">Créer un utilisateur</p>
                <p>Bootstrap v5.1.3</p>
            </div>
        </div>
        <div class="row">
            <div class="col-6 offset-3">
                <form method="POST" action="user.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nom" class="form-label" required>nom</label>
                        <input type="text" name="nom" class="form-control" id="nom">
                    </div>
                    <div class="mb-3">
                        <label for="prenom" class="form-label" required>prenom</label>
                        <input type="text" name="prenom" class="form-control" id="prenom">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse Email</label>
                        <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="mdp" class="form-label" required>mdp</label>
                        <input type="text" name="mdp" class="form-control" id="mdp">
                    </div>
                    <button type="submit"  class="btn btn-primary" name="bouton" value="envoyer">Submit</button>
                </form>
            </div>
        </div>
       

        <!-- footer -->
        <?php include 'includes/footer.php'?>

    </body>
</html>