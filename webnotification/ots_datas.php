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
	//on recupere la permission de l'employé vis-à-vis des notifications de rupture de stock
	$permission = Db::getInstance()->getValue('SELECT `notif_ots` FROM `'._DB_PREFIX_.'check_permission` WHERE `id_employe` = '.$employee.'');
	//si l'employé les a autorisées.
	if ($permission == 1) {
		$datas = array();
		$compteur = 0;
		//ici je devrais checker la valeur en base pour laquelle l'user veut etre notifier (val >= 15)
		$seuil_rds = Db::getInstance()->getValue('SELECT `ots` FROM `'._DB_PREFIX_.'check_permission` WHERE `id_employe` = '.(int)$employee.'');
		//je recupere tous les articles avec leurs attributs
		$all_attributes = Db::getInstance()->ExecuteS('SELECT `id_product_attribute` FROM `'._DB_PREFIX_.'stock_available` WHERE `quantity` <= '.(int)$seuil_rds.'');
		foreach ($all_attributes as $attr) {
			$id_product_attr = $attr['id_product_attribute'];
			$quantity = Db::getInstance()->getValue('SELECT `quantity` FROM `'._DB_PREFIX_.'stock_available` WHERE `id_product_attribute` = '.(int)$id_product_attr.'');
			$id_attributes = Db::getInstance()->ExecuteS('SELECT `id_attribute` FROM `'._DB_PREFIX_.'product_attribute_combination` WHERE `id_product_attribute` = '.(int)$id_product_attr.'');
			$id_products = Db::getInstance()->ExecuteS('SELECT `id_product` FROM `'._DB_PREFIX_.'stock_available` WHERE `id_product_attribute` = '.(int)$id_product_attr.'');
			$taille = count($id_attributes);
			$taille2 = count($id_products);
			for ($i = 0; $i <= $taille - 1; $i++) {
				$id_attributes_tab[] = $id_attributes[$i]['id_attribute'];
			}
			foreach ($id_attributes_tab as $id_attribute) {
				$attributes_name[] = Db::getInstance()->getValue('SELECT `name` FROM `'._DB_PREFIX_.'attribute_lang` WHERE `id_attribute` = '.(int)$id_attribute.'');
			}
			for ($a = 0; $a <= $taille2 - 1; $a++) {
				$id_products_tab[] = $id_products[$a]['id_product'];
			}
			foreach ($id_products_tab as $id_product) {
				$products_name[] = Db::getInstance()->getValue('SELECT `name` FROM `'._DB_PREFIX_.'product_lang` WHERE `id_product` = '.(int)$id_product.'');
				$id = $id_product;
			}
			$attributes_str = implode(" ", $attributes_name);
			$products_str = implode(" ", $products_name);
			//str contenant le(s) produit(s) en rupture de stock.
			$final_str = $products_str ." ". $attributes_str;
			$epure_str = str_replace("'", " ", $final_str);
			$check_existance = Db::getInstance()->ExecuteS('SELECT `id_ots` FROM `'._DB_PREFIX_.'check_ots` WHERE `id_employe` = '.$employee.'');
		    $taille = count($check_existance);
		   	$b = 0;
		    for ($i = 0; $i < $taille; $i++) {
	     		$existance[] = $check_existance[$b++]['id_ots'];
		   	}
		   	//nombre de fois que la notif a ete envoyée à l'employe courant.
		    $occurences = count(array_keys($existance, $id));
		    //si notification pas encore envoyée à l'employé
		    if ($occurences == 0) {
		    	$id_notif = 4;
		      	//on enregistre le message en base de données.
		      	DB::getInstance()->insert('check_ots', array('id_ots' => (int)$id, 'product' => (string)$epure_str, 'id_employe' => (int)$employee, 'profile' => (int)$profile));
		      	//tableau contenant toutes les données utilisées pour l'affichage de la notification message.
		      	$datas[$compteur++] = array('produit' => $epure_str, 'quantity' => $quantity, 'id_notif_ots' => $id_notif);
		      	$update_tab_message = DB::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'check_ots` SET `reception` = 1 WHERE `id_ots` = '.$id_ots.' AND `id_employe` = '.$employee.'');
		    }
		}
	//on retourne ce tableau sous le format Json.
	echo json_encode($datas);
	}

?>