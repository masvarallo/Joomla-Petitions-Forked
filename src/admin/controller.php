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

jimport( 'joomla.application.component.controller' );
$version = '1.5';
/**
 * Petitions  Petition Controller
 */
class PetitionsController extends JController
{
	function __construct($config = array())
	{
		parent::__construct($config);

		// Register Extra tasks
		$this->registerTask( 'add',  'display' );
		$this->registerTask( 'edit', 'display' );
		
		
	}

	function display( )
	{
		switch($this->getTask())
		{
			case 'add'     :
			{
				JRequest::setVar( 'hidemainmenu', 1 );
				JRequest::setVar( 'layout', 'form'  );
				JRequest::setVar( 'view'  , 'petition');
				JRequest::setVar( 'edit', false );

				// Checkout the petition
				$model = $this->getModel('petition');
				$model->checkout();
			} break;
			case 'edit'    :
			{
				JRequest::setVar( 'hidemainmenu', 1 );
				JRequest::setVar( 'layout', 'form'  );
				JRequest::setVar( 'view'  , 'petition');
				JRequest::setVar( 'edit', true );

				// Checkout the petition
				$model = $this->getModel('petition');
				$model->checkout();
			} break;
			
			case 'edit2'    :
			{
				JRequest::setVar( 'hidemainmenu', 1 );
				JRequest::setVar( 'layout', 'form'  );
				JRequest::setVar( 'view'  , 'signataire');
				JRequest::setVar( 'edit', true );

				// Checkout the petition
				$model = $this->getModel('signataire');
				$model->checkout();
			} break;
		}

		parent::display();
	}
	

	function save()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$post	= JRequest::get('post');
		$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$post['id'] = (int) $cid[0];

		$model = $this->getModel('petition');

		if ($model->store($post)) {
			$msg = JText::_( 'Petition Saved' );
		} else {
			$msg = JText::_( 'Error Saving Petition' );
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$model->checkin();
		$link = 'index.php?option=com_petitions';
		$this->setRedirect($link, $msg);
	}

	function remove()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}

		$model = $this->getModel('petition');
		if(!$model->delete($cid)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_petitions' );
	}


	function publish()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to publish' ) );
		}

		$model = $this->getModel('petition');
		if(!$model->publish($cid, 1)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_petitions' );
	}


	function unpublish()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to unpublish' ) );
		}

		$model = $this->getModel('petition');
		if(!$model->publish($cid, 0)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_petitions' );
	}

	function cancel()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Checkin the petition
		$model = $this->getModel('petition');
		$model->checkin();

		$this->setRedirect( 'index.php?option=com_petitions' );
	}


	function orderup()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$model = $this->getModel('petition');
		$model->move(-1);

		$this->setRedirect( 'index.php?option=com_petitions');
	}

	function orderdown()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$model = $this->getModel('petition');
		$model->move(1);

		$this->setRedirect( 'index.php?option=com_petitions');
	}

	function saveorder()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid 	= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order 	= JRequest::getVar( 'order', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);

		$model = $this->getModel('petition');
		$model->saveorder($cid, $order);

		$msg = 'New ordering saved';
		$this->setRedirect( 'index.php?option=com_petitions', $msg );
	}
	
	//--------
	function about()
    {
    	JRequest::setVar( 'view', 'about' );
	    JRequest::setVar( 'layout', 'default'  );
	    
	    parent::display();
	}
	
	
	function PetitionsFooter($version) {

	?>
		<p  align="center">
			<span style="font-size:x-small;">
			JoomlaPetitions <?php echo $version; ?>. Copyright &copy; 2007-2008 <a href="http://www.joomlapetitions.com">JoomlaPetitions Developers</a>.<br/>
			<a href="http://www.joomlapetitions.com">JoomlaPetitions</a> is Free Software released under the GNU/GPL License.
			</span>
		</p>
	<?php
	}
}