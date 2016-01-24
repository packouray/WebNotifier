<?php
	
	$sql = array();

	$sql[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'check_orders`;';

	$sql[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'check_employe`;';

	$sql[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'check_messages`;';

	$sql[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'check_returns`;';

	$sql[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'check_permission`;';

	$sql[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'check_profile`;';

	$sql[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'check_customers`;';

	$sql[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'check_ots`;';

?>