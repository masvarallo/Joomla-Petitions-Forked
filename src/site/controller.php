<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * Petitions Component Controller
 * @since 1.5
 */
class PetitionsController extends JController
{
	/**
	 * Method to show a petitions view
	 * @access public
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

	function captcha()
	{
		global $mainframe;
		$params =& $mainframe->getParams('com_petitions');

		require_once JPATH_COMPONENT . DS . 'captcha' . DS . 'securimage.php';

		//TODO are these $doc vars never used?
		$document = &JFactory::getDocument();
		$doc = &JDocument::getInstance('raw');
		$document = $doc;
		//TODO set mime-type
		$img = new Securimage();
		$img->ttf_file = JPATH_COMPONENT . DS . 'captcha' . DS . 'elephant.ttf';
		$img->show();
	}
}
