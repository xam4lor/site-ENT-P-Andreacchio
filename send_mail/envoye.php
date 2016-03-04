<!DOCTYPE html>
<html>

	<head>
		<meta charset = "utf-8"/>
		<link rel="icon" type="image/png" href="resources/favicon.png" />
		<link rel = "stylesheet" href = "../css/envoye.css" />
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
						<li><a href = "http://www.ent-andreacchio.890m.com/op_interface.php">Op_Interface</a></li>							
					</ul>

				</nav>
			</header>

			<br></br>

			<div class = "message">
				<center>
					<?php
						if(isset($_GET['id_confirm'])) {
							$id_confirm = $_GET['id_confirm'];
							$succes = false;

							try {
								$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u534058177_syxam;charset=utf8', 'u534058177_xam', 'syxam_hartania', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
							}
							catch(Exception $e) {
								die('Erreur : ' . $e->getMessage());
							}

							$req = $bdd->query('SELECT * FROM mails');

							while($donnees = $req->fetch()) {
								if($id_confirm == $donnees['id_to_confirm'] && !$succes) {
									$to = 'xam4lor@gmail.com';
									$subject = 'Nouveau mail sur le site http://www.ent-andreacchio.890m.com !';
									$message = '-- Nouveau mail depuis le site \'http://www.ent-andreacchio.890m.com\' --' . "\r\n"
										. "\r\n"
										. 'Description du mail : ' . "\r\n"
										. 'Nom de l\'envoyeur : ' . $donnees['nom'] . "\r\n"
										. 'Prenom : ' . $donnees['prenom'] . "\r\n"
										. 'E-mail : ' . $donnees['email'] . "\r\n"
										. 'Numero du telephone : 0' . $donnees['numero_tel'] . "\r\n" 
										. 'Texte : ' . $donnees['text'] . "\r\n"
										. "\r\n"
										. "\r\n"
										. "\r\n"
										. '                - Systeme de mails par xam4lor (xam4lor@gmail.com)'
									;
									$headers = 'From: mail@ent-andreacchio.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
									mail($to, $subject, $message, $headers);

									$succes = true;
								}
							}

							if($succes) {
								$req->closeCursor();

								$inser = $bdd->prepare('UPDATE mails SET confirm = 1 WHERE id_to_confirm = :id_to_confirm');
								$inser->execute(array('id_to_confirm' => $id_confirm));

								?>
							<h2><br />Votre message a bien été envoyé à l'ENT Pierre Andreacchio !</h2>
								<?php
							}
							else {
								$req->closeCursor();
								?>
								<h2>
									<br />Erreur lors de l'envoi du message à l'ENT Pierre Andreacchio. Le numéro de votre message n'est pas valide.
									<br />Pour plus d'informations, envoyer un mail à 'xam4lor@gmail.com'.
								</h2>
								<?php
							}
						}
						else {
							?>
						<h2>
							<br />Erreur lors de l'envoi du message à l'ENT Pierre Andreacchio. Le numéro de votre message n'est pas valide.
							<br />Pour plus d'informations, envoyer un mail à 'xam4lor@gmail.com'.
						</h2>
							<?php
						}
					?>
				</center>
			</div>

		</div>
	</body>
</html>