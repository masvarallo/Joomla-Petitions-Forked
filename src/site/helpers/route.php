<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

// Component Helper
jimport('joomla.application.component.helper');


class PetitionsHelperRoute
{
	function getPetitionRoute($id, $catid) {
		$needles = array(
			'category' => (int) $catid,
			'categories' => null
		);

		//Create the link
		$link = 'index.php?option=com_petitions&view=petition&id='. $id . '&catid='.$catid;
		$link .= '&Itemid=' . PetitionsHelperRoute::_findItem($needles);

		return $link;
	}

	function _findItem($needles)
	{
		$component =& JComponentHelper::getComponent('com_petitions');

		$menus	= &JApplication::getMenu('site', array());
		$items	= $menus->getItems('componentid', $component->id);
		$match = null;
		foreach($needles as $needle => $id)
		{
			foreach($items as $item)
			{
				if ((@$item->query['view'] == $needle) && (@$item->query['id'] == $id)) {
					$match = $item->id;
					break;
				}
			}

			if(isset($match)) {
				break;
			}
		}

		return $match;
	}
}
