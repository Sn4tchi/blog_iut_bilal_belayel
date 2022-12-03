<?php

class userManager{

    /**
     * 
     * @var PDO
     */
    private PDO $bdd;
    
    /**
     * 
     * @var bool|null
     */
    private ?bool $_result;
    /**
     * 
     * @var user
     */
    private user $_user;

    /**
     * 
     * @var int
     */
    private int $_getLastInsertId;

    /**
     * 
     * @return PDO
     */
    public function getBdd(): PDO {
        return $this->bdd;
    }

    /**
     * 
     * @return bool|null
     */
    public function get_result(): ?bool {
    return $this->_result;
    }

    /**
     * 
     * @return user
     */
    public function get_user(): user {
    return $this->_user;
    }

    /**
     * 
     * @return int
     */
    public function get_getLastInsertId(): int {
    return $this->_getLastInsertId;
    }

    /**
     * 
     * @param PDO $bdd
     * @return self
     */
    public function setBdd(PDO $bdd): self {
    $this->bdd = $bdd;
    return $this;
    }

    /**
     * 
     * @param bool|null $_result
     * @return self
     */
    public function set_result(?bool $_result): self {
    $this->_result = $_result;
    return $this;
    }

    /**
     * 
     * @param user $_user
     * @return self
     */
    public function set_user(user $_user): self {
    $this->_user = $_user;
    return $this;
    }

    /**
     * 
     * @param int $_getLastInsertId
     * @return self
     */
    public function set_getLastInsertId(int $_getLastInsertId): self {
    $this->_getLastInsertId = $_getLastInsertId;
    return $this;
    }
    /**
     * 
     * @param PDO $bdd
     */
    public function __construct(PDO $bdd) {
        $this->setBdd($bdd);
    }


    /**
     * 
     * @return array
     */
    public function getList(): array {
        $listUser = [];

        // Prépare une requête de type SELECT avec une clause WHERE selon l'id.
        $sql = 'SELECT id, '
                . 'nom,'
                . 'prenom, '
                . 'email, '
                . 'mdp, '
                . 'sid'
                . 'FROM user';

        $req = $this->bdd->prepare($sql);

        // Exécution de la requête avec attribution des valeurs aux marqueurs nominatifs.
        $req->execute();

        // On stocke les données obtenues dans un tableau.
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            //On créé des objets avec les données issues de la table
            $user = new user();
            $user->hydrate($donnees);
            $listUser[] = $user;
        }

        //print_r2($listUser);
        return $listUser;
    }

/**
     * 
     * @param user $user
     * @return self
     */
    public function updateByEmail(user $user): self {
        $sql = "UPDATE user SET sid = :sid WHERE email = :email";
        $req = $this->bdd->prepare($sql);
        //Sécurisation les variables
        $req->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
        $req->bindValue(':sid', $user->getSid(), PDO::PARAM_STR);
        //Exécuter la requête
        $req->execute();
        if ($req->errorCode() == 00000) {
            $this->_result = true;
        } else {
            $this->_result = false;
        }
        return $this;
    }


// public function getByEmail(int $email): user{
//     $sql='SELECT * FROM user WHERE email = :email';
//     $req= $this->bdd->prepare($sql);

//     $req->bindValue(':email',$email,PDO::PARAM_STR);
//     $req->execute();

//     $donnees=$req->fetch(PDO::FETCH_ASSOC);

//     $user=new user();
//     $user->hydrate($donnees);
//     return($user);
// }
/**
     * 
     * @param string $email
     * @return user
     */
    public function getByEmail(string $email): user {
        // Prépare une requête de type SELECT avec une clause WHERE selon l'id.
        $sql = 'SELECT * FROM user WHERE email = :email';
        $req = $this->bdd->prepare($sql);

        // Exécution de la requête avec attribution des valeurs aux marqueurs nominatifs.
        $req->bindValue(':email', $email, PDO::PARAM_STR);
        $req->execute();

        // On stocke les données obtenues dans un tableau.
        $donnees = $req->fetch(PDO::FETCH_ASSOC);
        
        $donnees = !$donnees ? [] : $donnees;
        
        $user = new user();
        $user->hydrate($donnees);
        //print_r2($user);
        return $user;
    }
    /**
     * @param string $sid
     * @return user 
     */ 
    public function getBySid(string $sid): user {
        // Prépare une requête de type SELECT avec une clause WHERE selon l'id.
        $sql = 'SELECT * FROM user WHERE sid = :sid';
        $req = $this->bdd->prepare($sql);

        // Exécution de la requête avec attribution des valeurs aux marqueurs nominatifs.
        $req->bindValue(':sid', $sid, PDO::PARAM_STR);
        $req->execute();

        // On stocke les données obtenues dans un tableau.
        $donnees = $req->fetch(PDO::FETCH_ASSOC);
        
        $donnees = !$donnees ? [] : $donnees;
        
        $user = new user();
        $user->hydrate($donnees);
        //print_r2($user);
        return $user;
    }

    /**
     * 
     * @param user $user
     * @return $this
     */


    public function add(user $user) {
        $sql = "INSERT INTO user "
                . "(nom, prenom, email, mdp, sid) "
                . "VALUES (:nom, :prenom, :email, :mdp, :sid)";
        $req = $this->bdd->prepare($sql);
        //Sécurisation les variables
        $req->bindValue(':nom', $user->getNom(), PDO::PARAM_STR);
        $req->bindValue(':prenom', $user->getPrenom(), PDO::PARAM_STR);
        $req->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
        $req->bindValue(':mdp', $user->getMdp(), PDO::PARAM_STR);
        $req->bindValue(':sid', $user->getSid(), PDO::PARAM_STR);
        //Exécuter la requête
        $req->execute();
        if ($req->errorCode() == 00000) {
            $this->_result = true;
            $this->_getLastInsertId = $this->bdd->lastInsertId();
        } else {
            $this->_result = false;
        }
        return $this;
    }
    // public function add(user $user) {
    //     $sql = "INSERT INTO user "
    //             . "(nom, prenom, email, mdp, sid) "
    //             . "VALUES (:nom, :prenom, :email, :mdp, :sid)";
    //     $req = $this->bdd->prepare($sql);
    //     //Sécurisation les variables
    //     $req->bindValue(':nom', $user->getNom(), PDO::PARAM_STR);
    //     $req->bindValue(':prenom', $user->getPrenom(), PDO::PARAM_STR);
    //     $req->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
    //     $req->bindValue(':mdp', $user->getMdp(), PDO::PARAM_STR);
    //     $req->bindValue(':sid', $user->getSid(), PDO::PARAM_STR);
    //     //Exécuter la requête
    //     $req->execute();
    //     if ($req->errorCode() == 00000) {
    //         $this->_result = true;
    //         $this->_getLastInsertId = $this->bdd->lastInsertId();
    //     } else {
    //         $this->_result = false;
    //     }
    //     return $this;
    // }
}