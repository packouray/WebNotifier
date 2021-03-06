<?php

	$sql = array();

	$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'check_orders` (`id` int(10) UNSIGNED NOT NULL PRIMARY KEY , `reference` VARCHAR(9) NULL DEFAULT NULL , `amount` FLOAT(10,2) NOT NULL , `currency_sign` VARCHAR(4) NULL DEFAULT NULL , `cart_content` VARCHAR(255) NOT NULL , `date` int(10) UNSIGNED NOT NULL) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

	$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'check_employe` (`id` int(10) UNSIGNED NOT NULL , `id_employe` int(10) UNSIGNED NOT NULL , `profile` int(10) UNSIGNED NOT NULL, `reception` TINYINT(1) UNSIGNED NOT NULL DEFAULT \'0\') ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

	$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'check_messages` (`id_message` int(10) UNSIGNED NOT NULL , `customer` VARCHAR(255) NOT NULL , `message` VARCHAR(255) NOT NULL , `id_employe` int(10) UNSIGNED NOT NULL , `profile` int(10) UNSIGNED NOT NULL , `reception` TINYINT(1) UNSIGNED NOT NULL DEFAULT \'0\') ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

	$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'check_returns` (`id_return` int(10) UNSIGNED NOT NULL , `id_cart` int(10) UNSIGNED NOT NULL , `cause` VARCHAR(255) NOT NULL , `content` VARCHAR(255) NOT NULL , `id_employe` int(10) UNSIGNED NOT NULL , `profile` int(10) UNSIGNED NOT NULL , `reception` TINYINT(1) UNSIGNED NOT NULL DEFAULT \'0\') ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

	$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'check_permission` (`id_employe` int(10) UNSIGNED NOT NULL PRIMARY KEY , `notif_message` TINYINT(1) UNSIGNED NOT NULL DEFAULT \'1\' , `notif_commande` TINYINT(1) UNSIGNED NOT NULL DEFAULT \'1\' , `notif_retour` TINYINT(1) UNSIGNED NOT NULL DEFAULT \'1\' , `notif_ots` TINYINT(1) UNSIGNED NOT NULL DEFAULT \'1\' , `notif_customer` TINYINT(1) UNSIGNED NOT NULL DEFAULT \'1\' , `time` int(10) UNSIGNED NOT NULL DEFAULT \'10\' , `ots` int(10) UNSIGNED NOT NULL DEFAULT \'1\') ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

	$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'check_profile` (`profile` VARCHAR(255) NOT NULL DEFAULT \'1\') ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

	$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'check_ots` (`id_ots` int(10) UNSIGNED NOT NULL , `product` VARCHAR(255) NOT NULL , `id_employe` int(10) UNSIGNED NOT NULL , `profile` int(10) UNSIGNED NOT NULL , `reception` TINYINT(1) UNSIGNED NOT NULL DEFAULT \'0\') ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

	$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'check_customers` (`id_customer` int(10) UNSIGNED NOT NULL , `id_employe` int(10) UNSIGNED NOT NULL , `profile` int(10) UNSIGNED NOT NULL , `reception` TINYINT(1) UNSIGNED NOT NULL DEFAULT \'0\') ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';
?>