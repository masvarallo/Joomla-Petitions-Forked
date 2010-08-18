<?php
//Joomla Petitions v 1.5 //
/**
* @ Package Joomla Petitions
* @version $Id: petitions.php 2008-08-14
* @ Copyright (C) 2007 - 2008 Milos Colic - All rights reserved
* @ Powered by Milos Colic - www.joomlapetitions.com
* @ All rights reserved
* @ Joomla Petitions Component is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/*
 * Make sure the user is authorized to view this page
 */
$user = & JFactory::getUser();

if (!$user->authorize( 'com_petitions', 'manage' )) {
	//$mainframe->redirect( 'index.php', JText::_('ALERTNOTAUTH') );
}

// Require the base controller
require_once (JPATH_COMPONENT.DS.'controller.php');
// Require specific controller if requested
if($controller = JRequest::getWord('controller')) {
	$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
	if (file_exists($path)) {
		require_once $path;
	} else {
		$controller = '';
	}
}
$classname    = 'PetitionsController' . $controller;
$controller   = new $classname();
//$controller	= new PetitionsController( );

// Perform the Request task
$controller->execute(JRequest::getVar('task'));
$controller->redirect();


PetitionsController::PetitionsFooter($version);