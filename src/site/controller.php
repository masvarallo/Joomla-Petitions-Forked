<?php
//Joomla Petitions v 1.5 //
/**
* @ Package Joomla Petitions 
* @version $Id: controller.php 2008-08-14
* @ Copyright (C) 2007 - 2008 Milos Colic - All rights reserved
* @ Powered by Milos Colic - www.joomlapetitions.com
* @ All rights reserved
* @ Joomla Petitions Component is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');
$version = '1.5';
/**
 * Petitions Component Controller
 *
 * @since 1.5
 */
class PetitionsController extends JController
{
	/**
	 * Method to show a petitions view
	 * @acces public
	 * @since	1.5
	 */
	function display()
	{
		// Set a default view if none exists
		if ( ! JRequest::getCmd( 'view' ) ) {
			JRequest::setVar('view', 'petitions' );
		}
/*
		//Set view petition
		if(JRequest::getCmd('view') == 'petition')
		{
			JRequest::setVar('view', 'petition' );
			//$model =& $this->getModel('petition');
			//$model->hit();
		}*/

		parent::display();
	}
	//end display
	
	function captcha()
	{
		global $mainframe;
		$params =& $mainframe->getParams('com_petitions');
		
		require_once JPATH_COMPONENT . DS . 'captcha' . DS . 'securimage.php';
				
		$document = &JFactory::getDocument();
		$doc = &JDocument::getInstance('raw');
		$document = $doc;
		$img = new Securimage();
		$img->ttf_file = JPATH_COMPONENT . DS . 'captcha' . DS . 'elephant.ttf';
		$img->show();
	}
	
	function PetitionsFooter($version) {

	?>
		<p  align="center">
			<span style="font-size:x-small;">
			JoomlaPetitions 1.5 is Free Software released under the GNU/GPL License.<br/>
			Copyright &copy; 2007-2008 <a href="http://www.joomlapetitions.com">www.joomlapetitions.com</a>
			</span>
		</p>
	<?php
	}

}