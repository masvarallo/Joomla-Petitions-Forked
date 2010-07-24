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

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the Petitions component
 */
class PetitionsViewPetitions extends JView
{
	function display( $tpl = null)
	{
		global $mainframe;

		$document =& JFactory::getDocument();

		$categories	=& $this->get('data');
		$total		=& $this->get('total');
		$state		=& $this->get('state');

		// Get the page/component configuration
		$params = &$mainframe->getParams();

		// Set some defaults if not set for params
		$params->def('comp_description', JText::_('PETITIONS_DESC'));

		// Define image tag attributes
		if ($params->get('image') != -1)
		{
			if($params->get('image_align')!="")
				$attribs['align'] = $params->get('image_align');
			else
				$attribs['align'] = '';
			$attribs['hspace'] = 6;

			// Use the static HTML library to build the image tag
			$image = JHTML::_('image', 'images/stories/'.$params->get('image'), JText::_('Web Petitions'), $attribs);
		}

		for($i = 0; $i < count($categories); $i++)
		{
			$category =& $categories[$i];
			$category->link = JRoute::_('index.php?option=com_petitions&view=petition&id='. $category->slug);
		}

		$this->assignRef('image',		$image);
		$this->assignRef('params',		$params);
		$this->assignRef('categories',	$categories);

		parent::display($tpl);
	}
}
?>
