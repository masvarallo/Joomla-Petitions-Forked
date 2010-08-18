<?php
//Joomla Petitions v 1.5 //
/**
* @ Package Joomla Petitions
* @version $Id: export.php 2008-08-14
* @ Copyright (C) 2007 - 2008 Milos Colic - All rights reserved
* @ Powered by Milos Colic - www.joomlapetitions.com
* @ All rights reserved
* @ Joomla Petitions Component is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.controller' );

/**
 * ckdata Controller
 */
class PetitionsControllerExport extends JController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{

		parent::__construct();

	}


	/**
	 * Method to display the view
	 *
	 * @access	public
	 */
	function display()
	{
		JRequest::setVar( 'view', 'export' );

		parent::display();
	}

	/**
	 * Export data saved in database
	 * @return void
	 */
	function exportXls() {

		$model = $this->getModel('export');

		$items = $model->getData();
		$fields = $model->getDatafields();

		$document = &JFactory::getDocument();
		$doc = &JDocument::getInstance('text');
		$document = $doc;

		header("Expires: Sun, 1 Jan 2000 12:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		header( "Content-type: application/vnd.ms-excel; charset=UTF-16LE" );

		header('Content-disposition: attachment; filename='.JText::_('PETITIONS DOWNLOAD CSV FILENAME').'_' . date("Ymd").'.csv');


		for ($i=0, $n=count( $fields ); $i < $n; $i++)
		{
			$rowField = $fields[$i];
			if ($rowField->typefield != 'button')
			{
				$unicode_str_for_Excel = mb_convert_encoding( $rowField->name, 'UTF-16LE', 'UTF-8');

				$data .= "\"".$unicode_str_for_Excel."\"";
				if ($i < $n-1) $data .= ";";
			}
		}

		echo $data." \n";

		for ($i=0, $n=count( $items ); $i < $n; $i++)
		{
			$row = $items[$i];

			$data = '';
			for ($j=0, $z=count( $fields ); $j < $z; $j++)
			{
				$rowField = $fields[$j];
				if ($rowField->typefield != 'button')
				{
					$prop=$rowField->name;

					$unicode_str_for_Excel = mb_convert_encoding( $row->$prop, 'UTF-16LE', 'UTF-8');

					$data .= "\"".$unicode_str_for_Excel."\"";
					if ($j < $z-1) $data .= ";";
				}
			}

			echo $data." \n";
		}

	}
	/**
	 * Export data saved in database
	 * @return void
	 */
	function exportPdf() {

		$msg = JText::_( 'Fonction valide uniquement dans la version Pro' );
		$type = 'error';

		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_petitions&controller=export';
		$this->setRedirect($link, $msg, $type);

	}


}
?>
