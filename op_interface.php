<!DOCTYPE html>
<html>

	<head>
		<meta charset = "utf-8"/>
		<link rel = "stylesheet" href = "../css/op_interface.css" />
		<title>ENT Pierre Andreacchio</title>
	</head>

	<body>
		<div id = "block_page">	

			<header>
				<div id = "titre_principal">

					<div id = "logo">
						<img src = "../resources/logo_andreacchio.png" />
						<h1>Pierre Andreacchio</h1>
					</div>

					<h2>Entreprise</h2>
				</div>
				<nav>

					<ul>
						<li><a href = "../index.html">Accueil</a></li>
						<li><a href = "#">Maçonnerie</a></li>
						<li><a href = "#">Chape</a></li>
						<li><a href = "#">Carrelage</a></li>
						<li><a href = "#">Rénovation</a></li>
						<li><a href = "#">Dallage</a></li>						
					</ul>

				</nav>
			</header>

			<br></br>

			<center>
				<?php
					if(
						$_GET['suppr_id'] != null 
						&& $_GET['suppr_id'] != "" 
						&& $_GET['pseudo'] != null
						&& $_GET['pseudo'] != ""
						&& $_GET['psw'] != null
						&& $_GET['psw'] != ""
					) {
						$suppr_id = $_GET['suppr_id'];
						$pseudo = $_GET['pseudo'];
						$psw = $_GET['psw'];
						$accountExist = false;

						try {
							$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u534058177_syxam;charset=utf8', 'u534058177_xam', 'syxam_hartania', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
						}
						catch(Exception $e) {
							die('Erreur : ' . $e->getMessage());
						}

						$req = $bdd->query('SELECT pseudo, pass FROM membres');

						while($donnees = $req->fetch()) {
							if($pseudo == $donnees['pseudo'] && $psw == $donnees['pass']) {
								$accountExist = true;
							}
						}

						$req->closeCursor();

						if(!$accountExist) {
							?>

						<div class="error_message">
							<h3>Ce compte n'existe pas.</h3><br />
							<input type="submit" name="error_message" value=" Retour " onclick="document.location.href = 'op_interface.php'" />
						</div>

							<?php
						}
						else {
							$remove = $bdd->prepare('DELETE FROM mails WHERE id=:id');
							$remove->execute(array('id' => $suppr_id));
							?>
						<div class="succes_message">
							<h3>Le message a bien été supprimé.</h3><br />
							<input type="submit" name="succes_message" value=" Retour " onclick="document.location.href = 'op_interface.php'" />
						</div>
							<?php
						}
					}

					else if(null == $_POST['pseudo'] || null == $_POST['psw']) {
						?>

					<div class="connect">
						<form method="post" action = "op_interface.php">
							<fieldset>
								<lengend>Connexion à l'interface :</lengend><br /><br />

								<label for="pseudo">Identifiant :<br /></label>
								<input type="text" name="pseudo" id="pseudo" required /><br /><br />

								<label for="psw">Mot de passe :<br /></label>
								<input type="password" name="psw" id="psw" required /><br /><br />

								<input type="submit" name="post" value="Connexion" />
							</fieldset>
						</form>
					</div>

						<?php
					}

					else {
						$pseudo = $_POST['pseudo'];
						$psw = sha1($_POST['psw']);
						$accountExist = false;

						try {
							$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u534058177_syxam;charset=utf8', 'u534058177_xam', 'syxam_hartania', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
						}
						catch(Exception $e) {
							die('Erreur : ' . $e->getMessage());
						}

						$req = $bdd->query('SELECT pseudo, pass FROM membres');

						while($donnees = $req->fetch()) {
							if($pseudo == $donnees['pseudo'] && $psw == $donnees['pass']) {
								$accountExist = true;
							}
						}

						$req->closeCursor();

						if(!$accountExist) {
							?>

						<div class="error_message">
							<h3>Ce compte n'existe pas.</h3><br />
							<input type="submit" name="error_message" value=" Retour " onclick="document.location.href = 'op_interface.php'" />
						</div>

							<?php
						}
						else {
							$req = $bdd->query('SELECT id, date_post, nom, prenom, email, numero_tel, text FROM mails ORDER BY id');
							$nb = 0;
							?>
						<div class="mails">
							<h1>Liste des mails :</h1><br />
							<?php
							while($donnees = $req->fetch()) {
								$nb++;
								?>
							<h3>
								- <?php echo $donnees['prenom'] ?> 
								<?php echo strtoupper($donnees['nom']) ?>
								, le <i><?php echo $donnees['date_post'] ?></i> 
								(téléphone : <?php echo '0' . $donnees['numero_tel'] ?>
								, email : <i><?php echo $donnees['email'] ?></i>) 
								: <i><?php echo $donnees['text'] ?></i>
								<img src="../resources/delete.png" title="Supprimer" width="25" height="25" onclick="document.location.href=<?php echo '\'?suppr_id=' . $donnees['id'] . '&pseudo=' . $_POST['pseudo'] . '&psw=' . sha1($_POST['psw']) . '\'' ?>" />
							</h3>

								<?php
							}

							$req->closeCursor();
							
							if($nb <= 0) {
								?>
							<h3>
								- Vous n'avez pas de mails -
							</h3>
								<?php
							}
							?>
						</div>
							<?php
						}
					}
				?>
			</center>
		</div>
	</body>
</html>
