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
  $check_existance3 = Db::getInstance()->ExecuteS('SELECT `id_employe` FROM `'._DB_PREFIX_.'check_permission`');
  $taille3 = count($check_existance3);
  $b3 = 0;
  for ($i3 = 0; $i3 < $taille3; $i3++) {
      $existance3[] = $check_existance3[$b3++]['id_employe'];
  }
  $occurences3 = count(array_keys($existance3, $employee));
  if ($occurences3 == 0) {
    DB::getInstance()->insert('check_permission', array('id_employe' => (int)$employee));
  }
  //on check si c'est la premiere fois que l'id employe et enregistré en base (on recupere tout les id presents dans la table).
  $check_existance2 = Db::getInstance()->ExecuteS('SELECT `id_employe` FROM `'._DB_PREFIX_.'check_permission`');
  $taille2 = count($check_existance2);
  $b2 = 0;
  for ($i2 = 0; $i2 < $taille2; $i2++) {
      $existance2[] = $check_existance2[$b2++]['id_employe'];
  }
  // contient le nombre d'occurences de l'id employé catché dans la base
  $occurences2 = count(array_keys($existance2, $employee));
  //si nombre d'occurence = 0 on l'enregistre alors dans la table.
  if ($occurences2 == 0) {
    DB::getInstance()->insert('check_permission', array('id_employe' => (int)$employee));
  }
  //on catch la permission de l'employe pour les notifications commande
  $permission = Db::getInstance()->getValue('SELECT `notif_commande` FROM `'._DB_PREFIX_.'check_permission` WHERE `id_employe` = '.$employee.'');
  //si le statut de la permission est set a 1 c'est que l'employe autorise les notifications de commande.
  if ($permission == 1) {
    //creation du gros tableau qui contien les sous tableau des commandes
    $datas = array();
    $compteur = 0;
    //on check l'heure courante - 10 minutes
    $date_checker = date('Y-m-j H:i:s', strtotime("-10 minutes"));
    $clear_date = str_replace("-", "", $date_checker);
    $concat_date_hour = str_replace(" ", "", $clear_date);
    //heure courant comme on la desire
    $clear_hour = str_replace(":", "", $concat_date_hour);
    $today_date = date('Y-m-d');
    $epure_today_date = str_replace("-", "", $today_date);
    //on parcourt la table contenant les infos de la commande.
    $commandes = Db::getInstance()->ExecuteS('SELECT `id` FROM `'._DB_PREFIX_.'check_orders`');
    //pour chacune des commandes on récupere les infos dans des variables et on check son statut courrant
    foreach ($commandes as $commande) {
      //données relatives a la commande
      $id_commande = $commande['id'];
      //on catch la somme total des revenu du jour 
      $dayly_money = Db::getInstance()->getValue('SELECT SUM(`amount`)FROM `'._DB_PREFIX_.'check_orders` WHERE `date` = '.$epure_today_date.' AND `id` <= '.(int)$id_commande.'');
      $id_order = Db::getInstance()->getValue('SELECT `id_order` FROM `'._DB_PREFIX_.'orders` WHERE `id_cart` = '.$id_commande.'');
      $reference = Db::getInstance()->getValue('SELECT `reference` FROM `'._DB_PREFIX_.'check_orders` WHERE `id` = '.$id_commande.'');
      $amount = Db::getInstance()->getValue('SELECT `amount` FROM `'._DB_PREFIX_.'check_orders` WHERE `id` = '.$id_commande.'');
      //devise de la commande (EUR, USD .....).
      $iso = Db::getInstance()->getValue('SELECT `currency_sign` FROM `'._DB_PREFIX_.'check_orders` WHERE `id` = '.$id_commande.'');
      //contenu de commande
      $cart_content = Db::getInstance()->getValue('SELECT `cart_content` FROM `'._DB_PREFIX_.'check_orders` WHERE `id` = '.$id_commande.'');
      //on get le statut courrant de la commande pour determiner si elle est validée ou non.
      $statut_commande = Db::getInstance()->getValue('SELECT `current_state` FROM `'._DB_PREFIX_.'orders` WHERE `id_cart` = '.$id_commande.'');
      $order_date = Db::getInstance()->getValue('SELECT `date_add` FROM `'._DB_PREFIX_.'orders` WHERE `id_cart` = '.$id_commande.'');
      $clear_ordrer_date = str_replace("-", "", $order_date);
      $concat_order_date_hour = str_replace(" ", "", $clear_ordrer_date);
      //date de commande comme on la desire.
      $clear_ordrer_hour = str_replace(":", "", $concat_order_date_hour);     
      //on recupere toutes les commandes dont les notifications ont ete recu par l'employé.
      $check_existance = Db::getInstance()->ExecuteS('SELECT `id` FROM `'._DB_PREFIX_.'check_employe` WHERE `id_employe` = '.$employee.'');
      $taille = count($check_existance);
      $b = 0;
      for ($i = 0; $i < $taille; $i++) {
        $existance[] = $check_existance[$b++]['id'];
      }
      //si la commande a moins de 10 minutes
        if ($order_date > $date_checker){
          //si le statut de la commande est égale à 2 c'est que le payement de la commande a été accepté => commande validée.
          if ($statut_commande == 2) {
            //check le nb d'occurences de la commande pour l'employe courrant pour ne pas lui envoyer deux fois la meme notification.
            $occurences = count(array_keys($existance, $id_commande));
            //si l'employé n'a pas encore ete notifier pour la commande.
            if ($occurences == 0) {
              $id_notif = 1;
              //on enregistre celle-ci en base de données
              DB::getInstance()->insert('check_employe', array('id' => (int)$id_commande, 'id_employe' => (int)$employee, 'profile' => (int)$profile));
              //on creer un tableau contenant les données utilisées pour l'affichage de la notification commande.
              $datas[$compteur++] = array('commande' => $id_commande, 'reference' => $reference, 'price' => $amount, 'devise' => $iso, 'contenu' => $cart_content, 'sum' => $dayly_money, 'id_order' => $id_order, 'id_notif_comm' => $id_notif);
              $update_tab_employe = DB::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'check_employe` SET `reception` = 1 WHERE `id` = '.$id_commande.' AND `id_employe` = '.$employee.'');
            } 
          }   
        }
    }
    //on retourne le tableau sous le format Json.
    echo json_encode($datas);
  }

?>