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
class PetitionsViewExport extends JView
{
	/**
	 * Petitions view display method
	 * @return void
	 **/


	function display($tpl = null)
	{
		global $mainframe, $option;

		JToolBarHelper::title( JText::_( 'Export Petitions' ), 'petitions' );


		$db		=& JFactory::getDBO();
		$uri	=& JFactory::getURI();


		// Get data from the model
		$items		=& $this->get('data');
		$total		=& $this->get('total');
		$pagination = & $this->get( 'Pagination' );
		$state		=& $this->get('state');

		// build list of categories
		$javascript 	= 'onchange="document.adminForm.submit();"';
		$lists['catid'] = JHTML::_('list.category', 'filter_catid', $option, intval( $filter_catid ), $javascript );

		// state filter
		$lists['state']	= JHTML::_('grid.state', $filter_state );

		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;

		// search filter
		$lists['search']= $search;

		$this->assignRef('user',		JFactory::getUser());
		$this->assignRef('lists',		$lists);
		$this->assignRef('items',		$items);
		$this->assignRef('pagination',	$pagination);

		parent::display($tpl);
	}
}
