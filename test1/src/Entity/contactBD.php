<?php
function readContact($idnom){
    require("../src/Entity/connectBD.php");
    $sql= "select nom, prenom, email, u.id_nom from contact c, utilisateur u where c.id_nom = :idu and c.id_contact = u.id_nom limit 0,30";
try {
    $commande = $pdo->prepare($sql);
    $commande->bindParam(':idu', $idnom);
    $bool = $commande->execute();
        if ($bool) {
            $resultat = $commande->fetchAll(PDO::FETCH_ASSOC); //tableau d'enregistrements
        }
    }
    catch (PDOException $e) {
        echo "erreur liste contact Echec de select";
        die(); // On arrête tout.
    }

    return $resultat;
}

?>