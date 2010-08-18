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
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the Petitions component
 */
class PetitionsViewPetition extends JView
{
	function display($tpl = null)
	{
		global $mainframe;

		if($this->getLayout() == 'form') {
			$this->_displayForm($tpl);
			return;
		}

		//get the Petition
		$petition =& $this->get('data');

		if ($petition->url) {
			// redirects to url if matching id found
			$mainframe->redirect($petition->url);
		}

		parent::display($tpl);
	}

	function _displayForm($tpl)
	{
		global $mainframe, $option;

		$db		=& JFactory::getDBO();
		$uri 	=& JFactory::getURI();
		$user 	=& JFactory::getUser();
		$model	=& $this->getModel();


		$lists = array();

		//get the Petition
		$petition	=& $this->get('data');
		$isNew		= ($petition->id < 1);

		// fail if checked out not by 'me'
		if ($model->isCheckedOut( $user->get('id') )) {
			$msg = JText::sprintf( 'DESCBEINGEDITTED', JText::_( 'The petition' ), $petition->title );
			$mainframe->redirect( 'index.php?option='. $option, $msg );
		}

		// Edit or Create?
		if (!$isNew)
		{
			$model->checkout( $user->get('id') );
		}
		else
		{
			// initialise new record
			$petition->published = 1;
			$petition->approved 	= 1;
			$petition->order 	= 0;
			$petition->catid 	= JRequest::getVar( 'catid', 0, 'post', 'int' );
		}

		// build the html select list for ordering
		$query = 'SELECT ordering AS value, title AS text'
			. ' FROM #__petitions'
			. ' WHERE catid = ' . (int) $petition->catid
			. ' ORDER BY ordering';

		$lists['ordering'] 			= JHTML::_('list.specificordering', $petition, $petition->id, $query );

		// build list of categories
		$lists['catid'] 			= JHTML::_('list.category', 'catid', $option, intval( $petition->catid ) );
		// build the html select list
		$lists['published'] 		= JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $petition->published );
		$lists['approved'] 		= JHTML::_('select.booleanlist', 'approved', 'class="inputbox"', $petition->approved );
		//clean Petition data
		JFilterOutput::objectHTMLSafe( $petition, ENT_QUOTES, 'description' );

		$file 	= JPATH_COMPONENT.DS.'models'.DS.'petition.xml';
		$params = new JParameter( $petition->params, $file );

		$this->assignRef('lists',		$lists);
		$this->assignRef('petition',	$petition);
		$this->assignRef('params',		$params);

		//$date =& JFactory::getDate($petition->date);
		//$date->setOffset($offset);
		//$petition->date = $date->toFormat();

		parent::display($tpl);
	}
}
