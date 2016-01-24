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
  //on get tous les employés deja enregistrés en base de données.
  $check_existance2 = Db::getInstance()->ExecuteS('SELECT `id_employe` FROM `'._DB_PREFIX_.'check_permission`');
  $taille2 = count($check_existance2);
  $b2 = 0;
  for ($i2 = 0; $i2 < $taille2; $i2++) {
      $existance2[] = $check_existance2[$b2++]['id_employe'];
  }
  //nombre de fois que l'employé a ete enregistre en base.
  $occurences2 = count(array_keys($existance2, $employee));
  //si l'employé n'est pas encore enregistrer.
  if ($occurences2 == 0) {
    //on enregistre son id dans la table.
    DB::getInstance()->insert('check_permission', array('id_employe' => (int)$employee));
  }
  //on catch la permission de celui-ci vis-à-vis des notifications de retour de commande.
  $permission = Db::getInstance()->getValue('SELECT `notif_retour` FROM `'._DB_PREFIX_.'check_permission` WHERE `id_employe` = '.$employee.'');
  //si l'employé a accordé sa permission.
  if ($permission == 1) {
    $datas = array();
    $compteur = 0;
    //on catch tous les retours de commande ayant été effectués.
    $returns = Db::getInstance()->ExecuteS('SELECT `id_order_return` FROM `'._DB_PREFIX_.'order_return`');
    //pour chacun d'entre eux on recupere :
    foreach ($returns as $return) {
      //son id
      $id_return = $return['id_order_return'];
      //l'id de la commande concernée.
      $id_order = Db::getInstance()->getValue('SELECT `id_order` FROM `'._DB_PREFIX_.'order_return` WHERE `id_order_return` = '.$id_return.'');
      //le motif du retour.
      $question = Db::getInstance()->getValue('SELECT `question` FROM `'._DB_PREFIX_.'order_return` WHERE `id_order_return` = '.$id_return.'');
      $taille = strlen($question);
      if ($taille > 25) {
        $cutstr = substr($question, 0, 25);
        $extension = '...';
        $cause = $cutstr . $extension;
      }
      else {
        $cause = $question;
      }
      $epure_cause = str_replace("'", " ", $cause);
      //l'id du panier.
      $id_cart = Db::getInstance()->getValue('SELECT `id_cart` FROM `'._DB_PREFIX_.'orders` WHERE `id_order` = '.$id_order.'');
      //son contenu.
      $content = Db::getInstance()->getValue('SELECT `cart_content` FROM `'._DB_PREFIX_.'check_orders` WHERE `id` = '.$id_cart.'');
      //le statut du retour.
      $return_state = Db::getInstance()->getValue('SELECT `state` FROM `'._DB_PREFIX_.'order_return` WHERE `id_order_return` = '.$id_return.'');
      //on recupere toutes les notifications retour recues par l'employé
      $check_existance = Db::getInstance()->ExecuteS('SELECT `id_return` FROM `'._DB_PREFIX_.'check_returns` WHERE `id_employe` = '.$employee.'');
      $taille = count($check_existance);
      $b = 0;
      for ($i = 0; $i < $taille; $i++) {
        $existance[] = $check_existance[$b++]['id_return'];
      }
      //si le retoour de commande est encore en attente de validation
      if ($return_state == 1) {
        //nombre de fois que l'employé a recu la notif
        $occurences = count(array_keys($existance, $id_return));
        //si pas encore recue
        if ($occurences == 0) {
              $id_notif = 2;
              //on enregistre les données recuperees en base de données.
              DB::getInstance()->insert('check_returns', array('id_return' => (int)$id_return, 'id_cart' => (int)$id_cart, 'cause' => (string)$epure_cause, 'content' => (string)$content, 'id_employe' => (int)$employee, 'profile' => (int)$profile));
              //on creer un tableau contenant les données utilisées pour l'affichage de la notification retour de commande.
              $datas[$compteur++] = array('id_return' => $id_return, 'contenu' => $content, 'cause' => $epure_cause, 'id_notif_reto' => $id_notif);
              $update_tab_return = DB::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'check_returns` SET `reception` = 1 WHERE `id_return` = '.$id_return.' AND `id_employe` = '.$employee.'');
        }
      }
    }
  //on retourne ce tableau sous le format JSON.
  echo json_encode($datas);
  }
  
?>