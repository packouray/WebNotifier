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
	$permission = Db::getInstance()->getValue('SELECT `notif_customer` FROM `'._DB_PREFIX_.'check_permission` WHERE `id_employe` = '.$employee.'');
	if ($permission == 1) {
		$datas = array();
		$compteur = 0;
		$customers = Db::getInstance()->ExecuteS('SELECT `id_customer` FROM `'._DB_PREFIX_.'customer` WHERE `active` = 1');
		$nb_customers = Db::getInstance()->getValue('SELECT COUNT(*) FROM `'._DB_PREFIX_.'customer`');
		foreach ($customers as $customer) {
			$id_customer = $customer['id_customer'];
			$id_gender = Db::getInstance()->getValue('SELECT `id_gender` FROM `'._DB_PREFIX_.'customer` WHERE `id_customer` = '.(int)$id_customer.'');
			if ($id_gender == 0) {
				$gender = '';
			}
			else {
				$gender = Db::getInstance()->getValue('SELECT `name` FROM `'._DB_PREFIX_.'gender_lang` WHERE `id_gender` = '.(int)$id_gender.'');
			}
			$customer_lastname = Db::getInstance()->getValue('SELECT `lastname` FROM `'._DB_PREFIX_.'customer` WHERE `id_customer` = '.(int)$id_customer.'');
			$customer_firstname = Db::getInstance()->getValue('SELECT `firstname` FROM `'._DB_PREFIX_.'customer` WHERE `id_customer` = '.(int)$id_customer.'');
			$customer_email = Db::getInstance()->getValue('SELECT `email` FROM `'._DB_PREFIX_.'customer` WHERE `id_customer` = '.(int)$id_customer.'');
			$finale_str = $gender ." ". $customer_lastname ." ". $customer_firstname;
			//on check si la notif a deja ete envoyé à l'employé courant.
			$check_existance = Db::getInstance()->ExecuteS('SELECT `id_customer` FROM `'._DB_PREFIX_.'check_customers` WHERE `id_employe` = '.$employee.'');
		    $taille = count($check_existance);
		   	$b = 0;
		    for ($i = 0; $i < $taille; $i++) {
	     		$existance[] = $check_existance[$b++]['id_customer'];
		   	}
		   	$occurences = count(array_keys($existance, $id_customer));
		   	if ($occurences == 0) {
		   		$id_notif = 5;
		   		//on enregistre le message en base de données.
		      	DB::getInstance()->insert('check_customers', array('id_customer' => (int)$id_customer, 'id_employe' => (int)$employee, 'profile' => (int)$profile));
		      	//tableau contenant toutes les données utilisées pour l'affichage de la notification message.
		      	$datas[$compteur++] = array('id_customer' => $id_customer, 'info_customer' => $finale_str, 'email' => $customer_email, 'nb_customers' => $nb_customers, 'id_notif_cus' => $id_notif);
		   		$update_tab_message = DB::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'check_customers` SET `reception` = 1 WHERE `id_customer` = '.$id_customer.' AND `id_employe` = '.$employee.'');
		   	}
		}
	//on retourne ce tableau sous le format Json.
    echo json_encode($datas);
	}

?>