<?php
	require_once(dirname(__FILE__).'/../../config/config.inc.php');
	require_once(dirname(__FILE__).'/../../config/settings.inc.php');
	require_once(dirname(__FILE__).'/../../classes/Cookie.php');

	$cookie = new Cookie('psAdmin');

	//on recupere l'id de l'employé ainsi que son profile
	if (isset($cookie->id_employee) && $cookie->id_employee > 0){
		if (isset($cookie->profile) && $cookie->profile > 0){
	        $employee = $cookie->id_employee;
	        $profile = $cookie->profile;
	    }
	}
	//on recupere tous les id_employe deja presents dans la table.
	$check_existance2 = Db::getInstance()->ExecuteS('SELECT `id_employe` FROM `'._DB_PREFIX_.'check_permission`');
	$taille2 = count($check_existance2);
	$b2 = 0;
	for ($i2 = 0; $i2 < $taille2; $i2++) {
     	$existance2[] = $check_existance2[$b2++]['id_employe'];
	}
	//nombre d'occurences de l'id catché dans la table.
	$occurences2 = count(array_keys($existance2, $employee));
	//si id de l'employe non present dans la table.
	if ($occurences2 == 0) {
		//on l'insert dans celle-ci
		DB::getInstance()->insert('check_permission', array('id_employe' => (int)$employee));
	}
	//on recupere la permission de l'employé vis-à-vis des notifications message 
	$permission = Db::getInstance()->getValue('SELECT `notif_message` FROM `'._DB_PREFIX_.'check_permission` WHERE `id_employe` = '.$employee.'');
	//si l'employé les a autorisées.
	if ($permission == 1) {
		$datas = array();
		$compteur = 0;
		//on catch tous les messages
		$messages = Db::getInstance()->ExecuteS('SELECT `id_customer_message` FROM `'._DB_PREFIX_.'customer_message`');
		//pour chaques messages
		foreach ($messages as $message){
			//on get son id
			$id_message = $message['id_customer_message'];
			//on get son contenu
			$message_content = DB::getInstance()->getValue('SELECT `message` FROM `'._DB_PREFIX_.'customer_message` WHERE `id_customer_message` = '.$id_message.'');
			$taille = strlen($message_content);
			//on épure la chaine si trop longue pour la notif
			if ($taille > 70){
				$cutstr = substr($message_content, 0, 70);
				$extension = '...';
				$epure_message = $cutstr . $extension;
			}
			else {
				$epure_message = $message_content; 
			}
			$final_message = str_replace("'", " ", $epure_message);
			//on get l'id du customer qui a envoyé le message
			$get_customer = DB::getInstance()->getValue('SELECT `id_customer_thread` FROM `'._DB_PREFIX_.'customer_message` WHERE `id_customer_message` = '.$id_message.'');
			//on recupere son adresse email
			$get_customer2 = DB::getInstance()->getValue('SELECT `email` FROM `'._DB_PREFIX_.'customer_thread` WHERE `id_customer_thread` = '.$get_customer.'');
			//on recupere son prenom
			$customer_firstname = DB::getInstance()->getValue("SELECT `firstname` FROM `"._DB_PREFIX_."customer` WHERE `email` = '$get_customer2'");
			//on recupere son nom
			$customer_lastname = DB::getInstance()->getValue("SELECT `lastname` FROM `"._DB_PREFIX_."customer` WHERE `email` = '$get_customer2'");
			//on concatene les deux variable pour obtenir une chaine NOM PRENOM
			$customer = $customer_lastname." ".$customer_firstname;
			//on get le statut du message
			$message_statut = DB::getInstance()->getValue('SELECT `read` FROM `'._DB_PREFIX_.'customer_message` WHERE `id_customer_message` = '.$id_message.'');
			//on check si la notif a deja ete envoyé à l'employé courant.
			$check_existance = Db::getInstance()->ExecuteS('SELECT `id_message` FROM `'._DB_PREFIX_.'check_messages` WHERE `id_employe` = '.$employee.'');
		    $taille = count($check_existance);
		   	$b = 0;
		    for ($i = 0; $i < $taille; $i++) {
	     		$existance[] = $check_existance[$b++]['id_message'];
		   	}
			//on check si le statut du message et non lu.
			if ($message_statut == 0) {
				//nombre de fois que la notif a ete envoyée à l'employe courant.
		      	$occurences = count(array_keys($existance, $id_message));
		      	//si notification pas encore envoyée à l'employé
		      	if ($occurences == 0) {
		      		$id_notif = 3;
		      		//on enregistre le message en base de données.
		      		DB::getInstance()->insert('check_messages', array('id_message' => (int)$id_message, 'customer' => (string)$customer, 'message' => (string)$final_message, 'id_employe' => (int)$employee, 'profile' => (int)$profile));
		      		//tableau contenant toutes les données utilisées pour l'affichage de la notification message.
		      		$datas[$compteur++] = array('customer' => $customer, 'message' => $final_message, 'id_customer_thread' => $get_customer, 'id_notif_mess' => $id_notif);
		      		$update_tab_message = DB::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'check_messages` SET `reception` = 1 WHERE `id_message` = '.$id_message.' AND `id_employe` = '.$employee.'');
		      	}
		    }
		}
	//on retourne ce tableau sous le format Json.
	echo json_encode($datas);
	}

?>