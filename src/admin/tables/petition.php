<?php
//Joomla Petitions v 1.5 //
/**
* @ Package Joomla Petitions
* @version $Id: petition.php 2008-08-14
* @ Copyright (C) 2007 - 2008 Milos Colic - All rights reserved
* @ Powered by Milos Colic - www.joomlapetitions.com
* @ All rights reserved
* @ Joomla Petitions Component is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

//Petition Table class

class TablePetition extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	/**
	 * @var int
	 */
	var $catid = null;

	/**
	 * @var int
	 */
	var $sid = null;

	/**
	 * @var string
	 */
	var $ip = null;

	/**
	 * @var string
	 */
	var $organisation = null;

	/**
	 * @var string
	 */
	var $title = null;

	/**
	 * @var string
	 */
	var $alias = null;

	/**
	 * @var string
	 */
	var $surname = null;

	/**
	 * @var string
	 */
	var $name = null;

	/**
	 * @var string
	 */
	var $age= null;

	/**
	 * @var string
	 */
	var $profession = null;

	/**
	 * @var string
	 */
	var $mail= null;

	/**
	 * @var string
	 */
	var $url = null;

	/**
	 * @var string
	 */
	var $localisation = null;

	/**
	 * @var string
	 */
	var $localisation2 = null;

	/**
	 * @var string
	 */
	var $localisation3 = null;

	/**
	 * @var string
	 */
	var $localisation4 = null;
	/**
	 * @var int
	 */
	var $vote = null;

	/**
	 * @var string
	 */
	var $comment = null;

	/**
	 * @var string
	 */
	var $edit = null;

	/**
	 * @var datetime
	 */
	var $date = null;


	/**
	 * @var int
	 */
	var $published = null;

	/**
	 * @var boolean
	 */
	var $checked_out = 0;

	/**
	 * @var time
	 */
	var $checked_out_time = 0;

	/**
	 * @var int
	 */
	var $ordering = null;

	/**
	 * @var int
	 */
	var $archived = null;

	/**
	 * @var int
	 */
	var $approved = null;

	/**
	 * @var string
	 */
	var $params = null;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct('#__petitions', 'id', $db);
	}

	/**
	* Overloaded bind function
	*
	* @acces public
	* @param array $hash named array
	* @return null|string	null is operation was satisfactory, otherwise returns an error
	* @see JTable:bind
	* @since 1.5
	*/
	function bind($array, $ignore = '')
	{
		if (key_exists( 'params', $array ) && is_array( $array['params'] ))
		{
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
			$array['params'] = $registry->toString();
		}

		return parent::bind($array, $ignore);
	}

	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 * @since 1.0
	 */
	function check()
	{
		if (JFilterInput::checkAttribute(array ('href', $this->url))) {
			$this->setError( JText::_('Please provide a valid URL'));
			return false;
		}

		/** check for valid name */
		if (trim($this->surname) == '') {
			$this->setError(JText::_('Your Petition must contain a surname.'));
			return false;
		}

		if (trim($this->name) == '') {
			$this->setError(JText::_('Your Petition must contain a name.'));
			return false;
		}

		if (!(eregi('http://', $this->url) || (eregi('https://', $this->url)) || (eregi('ftp://', $this->url)))) {
			$this->url = 'http://'.$this->url;
		}
		/*
		/** check for existing name */
		/*
		$query = 'SELECT id FROM #__petitions WHERE surname = '.$this->_db->Quote($this->surname).' AND catid = '.(int) $this->catid;
		$this->_db->setQuery($query);

		$xid = intval($this->_db->loadResult());
		if ($xid && $xid != intval($this->id)) {
			$this->setError(JText::sprintf('WARNNAMETRYAGAIN', JText::_('Web Petition')));
			return false;
		}
*/
		if(empty($this->alias)) {
			$this->alias = $this->surname;
		}
		$this->alias = JFilterOutput::stringURLSafe($this->alias);
		if(trim(str_replace('-','',$this->alias)) == '') {
			$datenow =& JFactory::getDate();
			$this->alias = $datenow->toFormat("%Y-%m-%d-%H-%M-%S");
		}

		return true;
	}
}
