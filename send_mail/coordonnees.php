<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8"/>
		<link rel="icon" type="image/png" href="resources/favicon.png" />
		<link rel = "stylesheet" href = "../css/coordonnees.css" />
		<title>ENT Pierre Andreacchio</title>
	</head>

	<body>
		<div id = "block_page">	

			<header>
				<div id = "titre_principal">

					<div id = "logo">
						<a href = "../logo_full_screen.html"><img src = "../resources/logo_andreacchio.png" /></a>
						<div class = "nom_entreprise">
							<a href = "../index.html"><h1>Pierre Andreacchio</h1></a>
						</div>
					</div>

					<h2>Entreprise</h2>
				</div>
				<nav>

					<ul>
						<li><a href = "../index.html">Accueil</a></li>
						<li><a href = "../photos/photos.html">Photos</a></li>
						<li><a href = "http://www.ent-andreacchio.890m.com/op_interface.php">Op-interface</a></li>							
					</ul>

				</nav>
			</header>

			<br></br>

			<center>
				<div class = "devis">
					<form method = "post">
						<div class = "coordonnees">
							<fieldset>
								<lengend>Vos coordonnées :</lengend><br /><br />

								<label for="nom">Nom :<br /></label>
								<input type="text" name="nom" id="nom" required /><br /><br />

								<label for="prenom">Prénom :<br /></label>
								<input type="text" name="prenom" id="prenom" required /><br /><br />

								<label for="email">Adresse email :<br /></label>
								<input type="email" name="email" id="email" required /><br /><br />

								<label for="numero">Numéro de téléphone :<br /></label>
								<input type="tel" name="numero" id="numero" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$" required /><br /><br />

								<label for="text">Travaux à faire :<br /><br /></label>
								<textarea name="text" id="text" rows="10" cols="45" required ></textarea>

								<input type="submit" name="post" value="Envoyer" />
							</fieldset>
						</div>
					</form>

					<?php
						if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['numero']) && isset($_POST['text'])) {
							$name = $_POST['nom'];
							$prename = $_POST['prenom'];
							$email = $_POST['email'];
							$tel = intval($_POST['numero']);
							$text = $_POST['text'];
							$id_inden = sha1($name) . sha1($prename) . rand(0, 999999999);

							try {
								$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u534058177_syxam;charset=utf8', 'u534058177_xam', 'syxam_hartania', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
							}
							catch(Exception $e) {
								die('Erreur : ' . $e->getMessage());
							}
							
							$inser = $bdd->prepare('INSERT INTO mails(date_post, nom, prenom, email, numero_tel, text, confirm, id_to_confirm) VALUES(NOW(), :nom, :prenom, :email, :numero_tel, :text, :confirm, :id_to_confirm)');
							$inser->execute(array('nom' => $name, 'prenom' => $prename, 'email' => $email, 'numero_tel' => $tel, 'text' => $text, 'confirm' => 0, 'id_to_confirm' => $id_inden));

							$to = $email;
							$subject = 'Confirmation de la demande de travaux sur http://www.ent-andreacchio.890m.com !';
							$message = '-- Confirmation de la demande de travaux depuis le site \'http://www.ent-andreacchio.890m.com\' --' . "\r\n"
								. '  Rappel du mail :' . "\r\n"
								. 'Description du mail : ' . "\r\n"
								. 'Nom de l\'envoyeur : ' . $name . "\r\n"
								. 'Prenom : ' . $prename . "\r\n"
								. 'E-mail : ' . $email . "\r\n"
								. 'Numero du telephone : 0' . $tel . "\r\n" 
								. 'Texte : ' . $text . "\r\n"
								. "\r\n"
								. '<a href="http://www.ent-andreacchio.890m.com/send_mail/envoye.php?id_confirm=' . $id_inden . '">Cliquez ici</a>' . "\r\n"
								. "\r\n"
								. "\r\n"
								. '                - Systeme de mails par xam4lor (xam4lor@gmail.com)'
							;
							$headers = 'From: mail@ent-andreacchio.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
							mail($to, $subject, $message, $headers);

							header('Location: msg_confirm_send.html');
						}
					?>
				</div>
			</center>
		</div>
	</body>
</html>
