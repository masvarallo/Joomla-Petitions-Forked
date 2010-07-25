<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	// Set toolbar items for the page
	JToolBarHelper::title(   JText::_( 'Petition Manager' ), 'generic.png' );
	JToolBarHelper::publishList();
	JToolBarHelper::unpublishList();
	JToolBarHelper::deleteList();
	JToolBarHelper::editListX();
	JToolBarHelper::addNewX();
	JToolBarHelper::preferences('com_petitions', '360');
	JToolBarHelper::help( 'screen.petition' );
?>
<script type="text/javascript" src="../includes/js/overlib_mini.js"></script>
<form action="index.php" method="post" name="adminForm">
	<table>
		<tr>
			<td align="left" width="100%">
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_catid').value='0';this.form.getElementById('filter_state').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			<td nowrap="nowrap">
				<?php
					echo $this->lists['catid'];
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
						<?php echo JHTML::_('grid.sort',  'Date', 'a.date', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					<th class="title">
						<?php echo JHTML::_('grid.sort',  'Surame', 'a.surname', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					<th class="title">
						<?php echo JHTML::_('grid.sort',  'Name', 'a.name', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					<th class="title">
						<?php echo JHTML::_('grid.sort',  'Email', 'a.mail', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					<th class="title">
						<?php echo JHTML::_('grid.sort',  'Comentaire', 'a.comment', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					<th width="5%" nowrap="nowrap">
						<?php echo JHTML::_('grid.sort',  'Published', 'a.published', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					<th width="5%" nowrap="nowrap">
						<?php echo JHTML::_('grid.sort',  'Approved', 'a.approved', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					<th width="8%" nowrap="nowrap">
						<?php echo JHTML::_('grid.sort',  'Order', 'a.ordering', $this->lists['order_Dir'], $this->lists['order'] ); ?>
						<?php echo JHTML::_('grid.order',  $this->items ); ?>
					</th>
					<th width="15%"  class="title">
						<?php echo JHTML::_('grid.sort',  'Category', 'category', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					<th width="1%" nowrap="nowrap">
						<?php echo JHTML::_('grid.sort',  'ID', 'a.id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
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

				$link 	= JRoute::_( 'index.php?option=com_petitions&view=petition&task=edit&cid[]='. $row->id );

				$checked 	= JHTML::_('grid.checkedout',   $row, $i );
				$published 	= JHTML::_('grid.published', $row, $i );
				//$approved 	= JHTML::_('grid.published', $row, $i );
				$ordering = ($this->lists['order'] == 'a.ordering');

				$row->cat_link 	= JRoute::_( 'index.php?option=com_categories&section=com_petitions&task=edit&type=other&cid[]='. $row->catid );
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td>
						<?php echo $this->pagination->getRowOffset( $i ); ?>
					</td>
					<td>
						<?php echo $checked; ?>
					</td>
					<td align="center">
						<?php echo JHTML::_('date', $row->date, "%d %B %Y %H:%M") ?>
					</td>
					<td align="center">
						<?php
							if (  JTable::isCheckedOut($this->user->get ('id'), $row->checked_out ) ) {
								echo $row->surname;
							} else {
								?>
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'Edit signataire' );?>::<?php echo $row->surname; ?> <?php echo $row->name; ?>">
									<a href="<?php echo $link; ?>">
										<?php echo $row->surname; ?>
									</a>
								</span>
								<?php
							}
						?>
					</td>
					<td align="center">
						<?php echo $row->name;?>
					</td>
					<td align="center">
						<?php echo $row->mail;?>
					</td>
					<?php
					if ($row->comment) {
						$img = 'publish_g.png';
						$textcomment = $row->comment;
					} else{
						$img = 'publish_r.png';
						$textcomment = JText::_( 'Pas de commentaire' );
					}
					?>
					<td align="center" >
					<a
						href="javascript: void(0);"
						onmouseover="return overlib('<div class="Tooltip"><?php echo $textcomment; ?></div>', CAPTION, '<?php echo JText::_( 'Signee Comment' );?>', BELOW, RIGHT);"
						onmouseout="return nd();"
						>
						<img src="images/<?php echo $img;?>" width="15" height="15" border="0" alt="" />
					</a>
					</td>
					<td align="center">
						<?php echo $published;?>
					</td>
					<td align="center">
						<?php echo $row->approved;?>
					</td>
					<td class="order">
						<span><?php echo $this->pagination->orderUpIcon( $i, ($row->catid == @$this->items[$i-1]->catid),'orderup', 'Move Up', $ordering ); ?></span>
						<span><?php echo $this->pagination->orderDownIcon( $i, $n, ($row->catid == @$this->items[$i+1]->catid), 'orderdown', 'Move Down', $ordering ); ?></span>
						<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
						<input type="text" name="order[]" size="5" value="<?php echo $row->ordering;?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />
					</td>
					<td>
						<a href="<?php echo $row->cat_link; ?>" >
							<span class="editlinktip hasTip" title="<?php echo JText::_( 'Edit Category' );?>::<?php echo $row->category; ?>">
								<?php echo $row->category; ?>
							</span>
						</a>
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
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>