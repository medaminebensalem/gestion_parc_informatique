<?php
include 'connexion.php';


// functions.php

/*function getArticle() {
    $pdo = new PDO('mysql:host=localhost;dbname=gestion_stock_dcli', 'root', '');
    $stmt = $pdo->query("SELECT id, nom_article,  quantite FROM article");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}*/

// Ajouter d'autres fonctions ici




function getArticle($id = null, $searchDATA = array(), $limit = null, $offset = null)
{
    $pagination = "";
    if (!empty($limit) && (!empty($offset) || $offset == 0)) {
        $pagination = " LIMIT $limit OFFSET $offset";
    }
    if (!empty($id)) {
        $sql = "SELECT a.id AS id, a.id_categorie, a.nom_article, c.libelle_categorie, a.quantite, a.date_fabrication, a.date_expiration
        FROM article AS a
        JOIN categorie_article AS c ON c.id = a.id_categorie
        WHERE a.id = ?";
    
        $req = $GLOBALS['connexion']->prepare($sql);
    
        $req->execute(array($id));
    
        return $req->fetch();
    }
    
    
    
    
    
   elseif (!empty($searchDATA)) {
        $search = "";
        extract($searchDATA);
        if (!empty($nom_article)) $search .= " AND a.nom_article LIKE '%$nom_article%' ";
        if (!empty($id_categorie)) $search .= " AND a.id_categorie = $id_categorie ";
        if (!empty($quantite)) $search .= " AND a.quantite = $quantite ";
       /* if (!empty($prix_unitaire)) $search .= " AND a.prix_unitaire = $prix_unitaire ";*/
        if (!empty($date_fabrication)) $search .= " AND DATE(a.date_fabrication) = '$date_fabrication' ";
        if (!empty($date_expiration)) $search .= " AND DATE(a.date_expiration) = '$date_expiration' ";

        $sql = "SELECT a.id AS id, id_categorie, nom_article, libelle_categorie, quantite,  date_fabrication, 
        date_expiration, 
        FROM article AS a, categorie_article AS c WHERE c.id=a.id_categorie $search $pagination";

        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute();

        return $req->fetchAll();
    } 

    else {
        // Prepare the SQL query
        $sql = "SELECT a.id AS id, id_categorie, nom_article, libelle_categorie, quantite, date_fabrication, date_expiration
                FROM article AS a
                JOIN categorie_article AS c ON c.id = a.id_categorie
                $pagination";
    
        // Prepare and execute the query
        $req = $GLOBALS['connexion']->prepare($sql);
        $req->execute();
        
        // Fetch and return all results
        return $req->fetchAll();
    }
    
}
    
    
    
    //else {
        //$sql = "SELECT a.id AS id, id_categorie, nom_article, libelle_categorie, quantite,  date_fabrication, 
        //date_expiration, 
        //FROM article AS a, categorie_article AS c WHERE c.id=a.id_categorie $pagination";

        //$req = $GLOBALS['connexion']->prepare($sql);

       // $req->execute();
        //return $req->fetchAll();
    //}
    //


function countArticle($searchDATA = array())
{

   if (!empty($searchDATA)) {
        $search = "";
        extract($searchDATA);
        if (!empty($nom_article)) $search .= " AND a.nom_article LIKE '%$nom_article%' ";
        if (!empty($id_categorie)) $search .= " AND a.id_categorie = $id_categorie ";
        if (!empty($quantite)) $search .= " AND a.quantite = $quantite ";
        /*if (!empty($prix_unitaire)) $search .= " AND a.prix_unitaire = $prix_unitaire ";*/
        if (!empty($date_fabrication)) $search .= " AND DATE(a.date_fabrication) = '$date_fabrication' ";
        if (!empty($date_expiration)) $search .= " AND DATE(a.date_expiration) = '$date_expiration' ";

        $sql = "SELECT COUNT(*) AS total FROM article AS a, categorie_article AS c WHERE c.id=a.id_categorie $search";

        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute();

        return $req->fetch();
    } else {
        $sql = "SELECT COUNT(*) AS total 
        FROM article AS a, categorie_article AS c WHERE c.id=a.id_categorie";
        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute();
        return $req->fetch();
    }
}

function getEmployer($id = null)
{
    if (!empty($id)) {
        $sql = "SELECT * FROM employer WHERE id=?";

        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute(array($id));

        return $req->fetch();
    } else {
        $sql = "SELECT * FROM employer";

        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute();

        return $req->fetchAll();
    }
}

/*function getAffictation($id = null) {
    $pdo = new PDO('mysql:host=localhost;dbname=gestion_stock_dcli', 'root', '');
    $sql = "SELECT * FROM affictation";
    if ($id) {
        $sql .= " WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}*/

function getAffictation($id = null)
{
    if (!empty($id)) {
        $sql = "SELECT nom_article, nom, prenom, v.quantite,  date_affictation, v.id,  adresse, telephone
        FROM employer AS c, affictation AS v, article AS a WHERE v.id_article=a.id AND v.id_employer=c.id AND v.id=? AND etat=?";

      $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute(array($id, 1));

       return $req->fetch();


    } 


   /*function getAffictations($etat) {
    global $connexion; // Use the global connection object
    
    $sql = "SELECT a.nom_article, e.nom, e.prenom, v.quantite, v.date_affictation, v.id AS idAffictation, a.id AS idArticle
            FROM affictation v
            JOIN article a ON v.id_article = a.id
            JOIN employer e ON v.id_employer = e.id
            WHERE v.etat = :etat"; // Use a parameterized query for security
    
    $req = $connexion->prepare($sql);
    $req->execute([':etat' => $etat]);

    return $req->fetchAll(PDO::FETCH_ASSOC); // Fetch as an associative array
}*/

else {
      $sql = "SELECT nom_article, nom, prenom, v.quantite,  date_affictation, v.id, a.id AS idArticle
        FROM employer AS c, affictation AS v, article AS a WHERE v.id_article=a.id AND v.id_employer=c.id AND etat=?";

        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute(array(1));

        return $req->fetchAll();
    }   

}  


    function getCommande($id = null) {
        $pdo = new PDO('mysql:host=localhost;dbname=gestion_stock_dcli', 'root', '');
        $sql = "SELECT c.id, a.nom_article, e.nom, e.prenom, c.quantite, c.date_commande, a.prix
                FROM commandes c
                JOIN articles a ON c.id_article = a.id
                JOIN employes e ON c.id_employer = e.id";
        if ($id) {
            $sql .= " WHERE c.id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    


/*function getCommande($id = null)
{
    if (!empty($id)) {
        $sql = "SELECT nom_article, nom, prenom, co.quantite,  date_commande, co.id,  adresse, telephone
        FROM employer AS f, commande AS co, article AS a WHERE co.id_article=a.id AND co.id_employer=f.id AND co.id=?";

        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute(array($id));

        return $req->fetch();
    } else {
        $sql = "SELECT nom_article, nom, prenom, co.quantite,  date_commande, co.id, a.id AS idArticle
        FROM employer AS f, commande AS co, article AS a WHERE co.id_article=a.id AND co.id_employer=f.id";

        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute();

        return $req->fetchAll();
    }
}
    */

function getAllCommande()
{
    $sql = "SELECT COUNT(*) AS nbre FROM commande";

    $req = $GLOBALS['connexion']->prepare($sql);

    $req->execute();

    return $req->fetch();
}

function getAllAffictation()
{
    $sql = "SELECT COUNT(*) AS nbre FROM affictation WHERE etat=?";

    $req = $GLOBALS['connexion']->prepare($sql);

    $req->execute(array(1));

    return $req->fetch();
}

function getAllArticle()
{
    $sql = "SELECT COUNT(*) AS nbre FROM article";

    $req = $GLOBALS['connexion']->prepare($sql);

    $req->execute();

    return $req->fetch();
}



function getLastAffictation()
{

    $sql = "SELECT nom_article, nom, prenom, v.quantite,  date_affictation, v.id, a.id AS idArticle
        FROM employer AS c, affictation AS v, article AS a WHERE v.id_article=a.id AND v.id_employer=c.id AND etat=? 
        ORDER BY date_affictation DESC LIMIT 10";

    $req = $GLOBALS['connexion']->prepare($sql);

    $req->execute(array(1));

    return $req->fetchAll();
}


function getMostAffictation()
{

    $sql = "SELECT nom_article, SUM(prix) AS prix
        FROM employer AS c, affictation AS v, article AS a WHERE v.id_article=a.id AND v.id_employer=c.id AND etat=? 
        GROUP BY a.id
        ORDER BY SUM(prix) DESC LIMIT 10";

    $req = $GLOBALS['connexion']->prepare($sql);

    $req->execute(array(1));

    return $req->fetchAll();
}

//function getMostAffictation()
//{

   // $sql = "SELECT *
//FROM employer AS c
//JOIN affictation AS v ON c.id = v.employer_id
//JOIN article AS a ON v.id_article = a.id
//";
        
        

  //  $req = $GLOBALS['connexion']->prepare($sql);

    //$req->execute(array(1));

    //return $req->fetchAll();
//}
//function getMostAffictation()
//{
    // Assuming $GLOBALS['connexion'] is your PDO connection object
   // $sql = "SELECT *
            //FROM employer AS c
            //JOIN affictation AS v ON c.id = v.employer_id
            //JOIN article AS a ON v.id_article = a.id";
    
    //$req = $GLOBALS['connexion']->prepare($sql);
    //$req->execute();

    // Fetch all rows as associative array
   // return $req->fetchAll(PDO::FETCH_ASSOC);
//}




function getCategorie($id = null)
{
    if (!empty($id)) {
        $sql = "SELECT * FROM categorie_article WHERE id=?";

        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute(array($id));

        return $req->fetch();
    } else {
        $sql = "SELECT * FROM categorie_article";

        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute();

        return $req->fetchAll();
    }
}
