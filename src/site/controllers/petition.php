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

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * Petitions Petition Controller
 */
class PetitionsControllerPetition extends PetitionsController
{

	/**
	* Saves the record  form submit
	*
	* @acces public
	* @since 1.5
	*/
	function save()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		//$post	= JRequest::get('post');
		//$cid	= JRequest::getVar( 'catid', array(0), 'post', 'array' );
		//$post['id'] = (int) $cid[0];

		//get data from the request

		$params =& $mainframe->getParams('com_petitions');
	
		$model = $this->getModel('petition');
					
		if ($params->get( 'use_captcha', 0 ))
		{
			include JPATH_COMPONENT . DS . 'captcha' . DS . 'securimage.php';
			$img = new Securimage();
			$valid = $img->check($_POST['ck_captcha_code']);
			
			if($valid == false) {
				//JError::raiseWarning( 0, JText::_( "Sorry_code_invalid" ).". <a href=\"javascript:history.go(-1)\">".JText::_( "Go back" )."</a>".JText::_( "to try again" ).".");
			
				$msg = JText::_( 'Sorry_code_invalid' );
				$type = 'error';

				// Check the table in so it can be edited.... we are done with it anyway
				$link = 'index.php?option=com_petitions&view=petition&id='.$_POST['catid'];
				$this->setRedirect($link, $msg, $type);
				return false;
			}
		}
		
		//$model = $this->getModel('petition');
		$post	= JRequest::get('post');
		$catid = $post['catid'];
		$surname = $post['surname'];
		$name = $post['name'];
				
		if ($model->store()) {

				//avertir l'administrateur d'une nouvelle nouvelle signature
				$uri  =  JFactory::getURI();
				$mail =& JFactory::getMailer();
				/*
				$db   =& JFactory::getDBO();
				$params =& $mainframe->getParams();			
					
				//get mail addresses of all super administrators
				$query = 'SELECT email' .
						' FROM #__users' .
						' WHERE LOWER( usertype ) = "super administrator" AND sendEmail = 1';
				$db->setQuery( $query );
				$admins = $db->loadResultArray();
				*/
				
				//get entry id from request
				$mailadmin = $params->get( 'mail_webmaster' );
				
				if ($params->get( 'copie_webmaster', 1 )){
				
						$mail->setSubject( JTEXT::_( 'New Signatary' ) );
						$mail->setBody( JTEXT::sprintf( 'A new signature has been written', $uri->base(), $surname, $name) );
						$mail->addBCC($mailadmin);
						if($mail->Send()){
						$msg = JText::_( 'petition saved' );
						//$msg = $uri->base().$name.$surname.$params->get( 'mail_webmaster' );
						$type = 'message';
						}
				}else{
						$msg = JText::_( 'petition saved' );
						$type = 'message';
				}
				
			//send mail to validate new signatary by signataire
			//PetitionsModelPetition::_sendMail();			
			//$msg = JText::_( 'petition saved' );
			
		} else {
			$msg = JText::_( 'Error Saving Petition' );
			$type = 'error';
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_petitions&view=petition&id='.$_POST['catid'];
		$this->setRedirect($link, $msg, $type);
	}


}

?>
