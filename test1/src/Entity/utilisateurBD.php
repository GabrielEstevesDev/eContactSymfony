<?php
function verif_ident() {
	$nom=  isset($_POST['nom'])?($_POST['nom']):'';
	$num=  isset($_POST['num'])?($_POST['num']):'';
	//connexion au serveur de BD -> voir fichier connect.php
	//requete select en BD
	require("../src/Entity/connectBD.php");
	$sql="SELECT * FROM `utilisateur`  where nom=:nom and num=:num"; 
	
	try {
		$commande = $pdo->prepare($sql);
		$commande->bindParam(':nom', $nom);
		$commande->bindParam(':num', $num);
		$bool = $commande->execute();	
	}
	
	catch (PDOException $e) {
		echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
		die("STOP Catch Verif"); // On arrête tout.
	}
	

	if ($bool) 
		$resultat = $commande->fetchAll(PDO::FETCH_ASSOC); //tableau d'enregistrements
	
	//affichage pour le developpement. A enlever.
	/*var_dump ($resultat);
	die('dans verif ....');*/
	
	if (count($resultat)== 0) return false; 
		else {
			$profil= $resultat[0];
			$_SESSION['profil']=$profil;
			return true;
		}
}
?>