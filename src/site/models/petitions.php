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

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

/**
 * Petitions Component Categories Model
 *
 * @since 1.5
 */
class PetitionsModelPetitions extends JModel
{
	/**
	 * Categories data array
	 *
	 * @var array
	 */
	var $_data = null;

	/**
	 * Categories total
	 *
	 * @var integer
	 */
	var $_total = null;

	/**
	 * Constructor
	 *
	 * @since 1.5
	 */

	function __construct()
	{
		parent::__construct();

	}

	/**
	 * Method to get petition item data for the category
	 *
	 * @access public
	 * @return array
	 */
	function getData()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$query = $this->_buildQuery();
			$this->_data = $this->_getList($query);
		}

		return $this->_data;
	}

	/**
	 * Method to get the total number of petition items for the category
	 *
	 * @access public
	 * @return integer
	 */
	function getTotal()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_total))
		{
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
		}

		return $this->_total;
	}

	function _buildQuery()
	{
		$user =& JFactory::getUser();
		$aid = $user->get('aid', 0);

		//Query to retrieve all categories that belong under the petitions section and that are published.
		$query = 'SELECT cc.*, COUNT(a.id) AS numlinks,'
			.' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(\':\', cc.id, cc.alias) ELSE cc.id END as slug'
			.' FROM #__categories AS cc'
			.' LEFT JOIN #__petitions AS a ON a.catid = cc.id'
			.' WHERE a.published = 1'
			.' AND section = \'com_petitions\''
			.' AND cc.published = 1'
			.' AND cc.access <= '.(int) $aid
			.' GROUP BY cc.id'
			.' ORDER BY cc.ordering';

		return $query;
	}
}
