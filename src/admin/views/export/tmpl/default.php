<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	// Set toolbar items for the page
	JToolBarHelper::custom('exportXls', 'archive.png', 'archive.png', JText::_('Export XLS'), false);
	JToolBarHelper::custom('exportPdf', 'archive.png', 'archive.png', JText::_('Export PDF'), false);
	JToolBarHelper::help( 'screen.petition' );
?>

<form action="index.php" method="post" name="adminForm">
<table>
<tr>
	<td align="left" width="100%">
	</td>
	<td nowrap="nowrap">
		<?php
			//echo $this->lists['catid'];
			echo $this->lists['state'];
		?>
	</td>
</tr>
</table>
<div id="editcell">
	<table class="adminlist">
	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'NUM' ); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>
			<th class="title">
				<?php echo JText::_( 'Titre de la petition' );?>
			</th>
			<th width="15%"  class="title">
				<?php echo JText::_( 'Nombre de signataires' );?>
			</th>
			<th width="5%" nowrap="nowrap">
				<?php echo JText::_( 'Published' );?>
			</th>
			<th width="8%" nowrap="nowrap">
				<?php echo JText::_( 'Order' );?>
			</th>
			<th width="1%" nowrap="nowrap">
				<?php echo JText::_( 'Category ID' );?>
			</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="12">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
	<tbody>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];

		$link 	= JRoute::_( 'index.php?option=com_petitions&view=petition&task=edit&cid[]='. $row->catid );
		$checked 	= JHTML::_('grid.checkedout',   $row, $i );
		$published 	= JHTML::_('grid.published', $row, $i );
		//$approved 	= JHTML::_('grid.published', $row, $i );
		$ordering = ($this->lists['order'] == 'a.ordering');

		$row->cat_link 	= JRoute::_( 'index.php?option=com_categories&section=com_petitions&task=edit&type=other&cid[]='. $row->id );
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td>
				<?php echo $checked; ?>

			<td>
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'Modifier la Petition' );?>::<?php echo $row->title; ?>">
				<a href="<?php echo $row->cat_link; ?>" >
				<?php echo $row->title; ?></a><span>
			</td>
			<td align="center">
				<?php echo $row->numlinks;?>
			</td>
			<td align="center">
				<?php echo $published;?>
			</td>
			<td class="order">
				<span><?php echo $this->pagination->orderUpIcon( $i, ($row->catid == @$this->items[$i-1]->catid),'orderup', 'Move Up', $ordering ); ?></span>
				<span><?php echo $this->pagination->orderDownIcon( $i, $n, ($row->catid == @$this->items[$i+1]->catid), 'orderdown', 'Move Down', $ordering ); ?></span>
				<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
				<input type="text" name="order[]" size="5" value="<?php echo $row->ordering;?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />
			</td>
			<td align="center">
				<?php echo $row->id; ?>
			</td>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
	</tbody>
	</table>
</div>

	<input type="hidden" name="option" value="com_petitions" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	 <input type="hidden" name="controller" value="export" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>