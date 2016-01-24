<?php

class Modelwebnotification extends ObjectModel
{
	public $id_employe;
	public $notif_message;
	public $notif_commande;
	public $notif_retour;

	public static $definition = array(
		'table' => 'check_permission',
		'primary' => 'id_employe',
		'fields' => array(
			'notif_message'	=> array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'notif_commande'	=> array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'notif_customer'	=> array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'notif_retour'	=> array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'time' => array('type' => self::TYPE_INT, 'validate' => 'unsigned'),
			'ots' => array('type' => self::TYPE_INT, 'validate' => 'unsigned'),
		),
		'table' => 'check_profile',
		'primary' => 'profile',
	);
}