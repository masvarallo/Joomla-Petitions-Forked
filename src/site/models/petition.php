<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');

/**
 * Petitions Component Petition Model
 *
 * @since 1.5
 */
class PetitionsModelPetition extends JModel
{
	/**
	 * Category id
	 *
	 * @var int
	 */
	var $_id = null;

	/**
	 * Category ata array
	 *
	 * @var array
	 */
	var $_data = null;

	/**
	 * Category total
	 *
	 * @var integer
	 */
	var $_total = null;

	/**
	 * Category data
	 *
	 * @var object
	 */
	var $_category = null;

	/**
	 * Pagination object
	 *
	 * @var object
	 */
	var $_pagination = null;

	/**
	 * Constructor
	 *
	 * @since 1.5
	 */
	function __construct()
	{
		parent::__construct();

		global $mainframe;

		$config = JFactory::getConfig();

		// Get the pagination request variables
		$this->setState('limit', $mainframe->getUserStateFromRequest('com_petitions.limit', 'limit', $config->getValue('config.list_limit'), 'int'));
		$this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));

		// In case limit has been changed, adjust limitstart accordingly
		$this->setState('limitstart', ($this->getState('limit') != 0 ? (floor($this->getState('limitstart') / $this->getState('limit')) * $this->getState('limit')) : 0));

		// Get the filter request variables
		$this->setState('filter_order', JRequest::getCmd('filter_order', 'ordering'));
		$this->setState('filter_order_dir', JRequest::getCmd('filter_order_Dir', 'ASC'));

		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
	}

	/**
	 * Method to set the category id
	 *
	 * @access	public
	 * @param	int	Category ID number
	 */
	function setId($id)
	{
		// Set category ID and wipe data
		$this->_id			= $id;
		$this->_category	= null;
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
		if (empty($this->_data)) {
			$query = $this->_buildQuery();
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));

			$total = count($this->_data);
			for ($i = 0; $i < $total; $i++) {
				$item =& $this->_data[$i];
				$item->slug = $item->id.':'.$item->alias;
			}
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
		if (empty($this->_total)) {
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
		}

		return $this->_total;
	}

	/**
	 * Method to get a pagination object of the petition items for the category
	 *
	 * @access public
	 * @return integer
	 */
	function getPagination()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_pagination)) {
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}

		return $this->_pagination;
	}

	/**
	 * Method to get category data for the current category
	 *
	 * @since 1.5
	 */
	function getCategory()
	{
		// Load the Category data
		if ($this->_loadCategory()) {
			// Initialize some variables
			$user = &JFactory::getUser();

			// Make sure the category is published
			if (!$this->_category->published) {
				JError::raiseError(404, JText::_("Resource Not Found"));
				return false;
			}
			// check whether category access level allows access
			if ($this->_category->access > $user->get('aid', 0)) {
				JError::raiseError(403, JText::_("ALERTNOTAUTH"));
				return false;
			}
		}
		return $this->_category;
	}

	/**
	 * Method to load category data if it doesn't exist.
	 *
	 * @access	private
	 * @return	boolean	True on success
	 */
	function _loadCategory()
	{
		if (empty($this->_category)) {
			// current category info
			$query = 'SELECT c.*, '.
				' CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(\':\', c.id, c.alias) ELSE c.id END as slug '.
				' FROM #__categories AS c'.
				' WHERE c.id = '. (int) $this->_id.
				' AND c.section = "com_petitions"';
			$this->_db->setQuery($query, 0, 1);
			$this->_category = $this->_db->loadObject();
		}
		return true;
	}

	function _buildQuery()
	{
		$filter_order		= $this->getState('filter_order');
		$filter_order_dir	= $this->getState('filter_order_dir');

		$filter_order		= JFilterInput::clean($filter_order, 'cmd');
		$filter_order_dir	= JFilterInput::clean($filter_order_dir, 'word');

		// We need to get a list of all petitions in the given category
		$query = 'SELECT *'.
			' FROM #__petitions' .
			' WHERE catid = '.(int) $this->_id.
			' AND published = 1'.
			' AND approved = 1'.
			' ORDER BY '. $filter_order .' '. $filter_order_dir .', ordering';

		return $query;
	}


	function store()
	{
		$table	= & $this->getTable();
		$data = JRequest::get( 'post' );

		// Bind form data to table fields
		if (!$table->bind( $data )) {
			$this->setError( $this->_db->getErrorMsg() );
			return false;
		}
		// Create the timestamp for the date
		$table->date = date('Y-m-d H:i:s');

		// Make sure the record is a valid one
		$error = $table->check();
		if ($error !== true) {
			$this->setError( $error );
			return false;
		}

		// Save
		if (!$table->store()) {
			$this->setError( $this->_db->getErrorMsg() );
			return false;
		}

		return true;
	}

	//version com_user
	function _sendMail(&$user, $password)
	{
		global $mainframe;

		$db			=& JFactory::getDBO();

		$name		= $user->get('name');
		$email		= $user->get('email');
		$username	= $user->get('username');

		$usersConfig	= &JComponentHelper::getParams( 'com_users' );
		$sitename		= $mainframe->getCfg( 'sitename' );
		$useractivation	= $usersConfig->get( 'useractivation' );
		$mailfrom		= $mainframe->getCfg( 'mailfrom' );
		$fromname		= $mainframe->getCfg( 'fromname' );
		$siteURL		= JURI::base();

		$subject	= sprintf ( JText::_( 'Account details for' ), $name, $sitename);
		$subject	= html_entity_decode($subject, ENT_QUOTES);

		if ($useractivation == 1) {
			$message = sprintf( JText::_( 'SEND_MSG_ACTIVATE' ), $name, $sitename, $siteURL."index.php?option=com_user&task=activate&activation=".$user->get('activation'), $siteURL, $username, $password);
		} else {
			$message = sprintf( JText::_( 'SEND_MSG' ), $name, $sitename, $siteURL);
		}

		$message = html_entity_decode($message, ENT_QUOTES);

		//get all super administrator
		$query = 'SELECT name, email, sendEmail'.
				' FROM #__users'.
				' WHERE LOWER( usertype ) = "super administrator"';
		$db->setQuery( $query );
		$rows = $db->loadObjectList();

		// Send email to user
		if (!$mailfrom || ! $fromname) {
			$fromname = $rows[0]->name;
			$mailfrom = $rows[0]->email;
		}

		//FIXME this will only send to 1 super admin
		JUtility::sendMail($mailfrom, $fromname, $email, $subject, $message);
		/*
		// Send notification to all administrators
		$subject2 = sprintf ( JText::_( 'Account details for' ), $name, $sitename);
		$subject2 = html_entity_decode($subject2, ENT_QUOTES);

		// get superadministrators id
		foreach ( $rows as $row )
		{
			if ($row->sendEmail)
			{
				$message2 = sprintf ( JText::_( 'SEND_MSG_ADMIN' ), $row->name, $sitename, $name, $email, $username);
				$message2 = html_entity_decode($message2, ENT_QUOTES);
				JUtility::sendMail($mailfrom, $fromname, $row->email, $subject2, $message2);
			}
		}
		*/
	}
	// end version com_user
}
