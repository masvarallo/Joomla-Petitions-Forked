<?php
//Joomla Petitions v 1.5 //
/**
* @ Package Joomla Petitions
* @version $Id: view.html.php 2008-08-14
* @ Copyright (C) 2007 - 2008 Milos Colic - All rights reserved
* @ Powered by Milos Colic - www.joomlapetitions.com
* @ All rights reserved
* @ Joomla Petitions Component is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
*/

// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

/**
 * Petitions View
 *
 * @package Petitions
 */
class PetitionsViewAbout extends JView
{
	/**
	 * Petitions view display method
	 * @return void
	 **/
	function display($tpl = null)
	{
		JToolBarHelper::title( JText::_( 'About Petitions' ), 'petitions' );
		parent::display($tpl);
	}
}
