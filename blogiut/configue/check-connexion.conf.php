<?php 
    /**
     * 
     * @var bool
     */
$isConnectSid = false;

if(isset($_COOKIE['sid'])){

    $userFormulaire = new user();
    $userFormulaire->hydrate($_COOKIE);


    $userSid = new userManager($bdd);
    $userEnBdd = $userSid->getBySid($userFormulaire->getSid());


         if($userEnBdd->getSid() == $userFormulaire->getSid())
        {
            $isConnectSid = true;
        }

}
var_dump($isConnectSid); 

?>