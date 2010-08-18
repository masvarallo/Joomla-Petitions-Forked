<?php defined('_JEXEC') or die('Restricted access'); ?>
<script type="text/javascript">
	function tableOrdering( order, dir, task ) {
	var form = document.adminForm;

	form.filter_order.value 	= order;
	form.filter_order_Dir.value	= dir;
	document.adminForm.submit( task );
}
</script>
<script type="text/javascript" src="includes/js/overlib_mini.js"></script>
<form action="<?php echo JRoute::_($this->action); ?>" method="post" name="adminForm">
	<div class="com_petitions_displaylimit" style="text-align:center">
		<?php
			echo JText::_('Display Num') .'&nbsp;';
			echo $this->pagination->getLimitBox();
		?>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<?php if ( $this->params->def( 'show_headings', 1 ) ) : ?>
			<tr>
				<td width="10" style="text-align:right;" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?> head_number">
					<?php echo JText::_('Num'); ?>
				</td>
				<?php if ($this->params->get('col_mail',0)) : ?>
					<td width="20%" height="20" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?> head_email">
						<?php echo JHTML::_('grid.sort', JText::_('petitions column number'), 'mail', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</td>
				<?php endif; ?>
				<?php if ($this->params->get('col_organisation',0)) : ?>
					<td width="20%" height="20" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?> head_org">
						<?php echo JHTML::_('grid.sort', 'Organisation', 'organisation', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</td>
				<?php endif; ?>
					<td width="20%" height="20" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?> head_name">
						<?php
						$surnamename = JText::_( 'surname', true ).' '.JText::_( 'name', true );
						echo JHTML::_('grid.sort', $surnamename, 'surname', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</td>
				<?php if ($this->params->get('col_profession',0)) : ?>
					<td width="20%" height="20" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?> head_profession">
						<?php echo JHTML::_('grid.sort', 'Profession', 'profession', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</td>
				<?php endif; ?>
				<?php if ($this->params->get('col_date',0)) : ?>
					<td width="20%" height="20" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?> head_date">
						<?php echo JHTML::_('grid.sort', JText::_('petitions date'), 'date', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</td>
				<?php endif; ?>
				<td width="20%" height="20" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?> head_city">
					<?php echo JHTML::_('grid.sort', JText::_('petitions city'), 'localisation3', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</td>
				<?php if ($this->params->get('col_comment',0)) : ?>
					<td width="20%" height="20" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?> head_comment">
						<?php echo JHTML::_('grid.sort', JText::_('petitions comment'), 'comment', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</td>
				<?php endif; ?>
				<?php if ( $this->params->get( 'show_link_hits' ) ) : ?>
					<td width="30" height="20" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?> head_hits" style="text-align:center;" nowrap="nowrap">
						<?php echo JHTML::_('grid.sort', JText::_('petitions hits'), 'hits', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</td>
				<?php endif; ?>
			</tr>
		<?php endif; ?>
		<?php foreach ($this->items as $item) : ?>
			<tr class="sectiontableentry<?php echo $item->odd + 1; ?>">
				<td class="val_number" align="right">
					<?php echo $this->pagination->getRowOffset( $item->count ); ?>
				</td>
				<?php if ($this->params->get('col_mail',0)) : ?>
					<td class="val_email" height="20">
						<?php
							if ($item->edit == 'y') :
								echo '<a href="mailto:' . $item->mail . '">' . JHTML::_('image', 'components/com_petitions/images/email.png', $this->escape($item->mail), 'title="'.$item->mail.'" border="0" height="16" width="16" class="png" hspace="3"') . '</a>';
							endif;
						?>
					</td>
				<?php endif; ?>
				<?php if ($this->params->get('col_organisation',0)) : ?>
					<td class="val_organisation">
						<?php echo $this->escape($item->organisation); ?>
					</td>
				<?php endif; ?>
					<td class="val_name">
						<?php echo $this->escape($item->surname); ?> <?php echo $this->escape($item->name); ?>
					</td>
				<?php if ($this->params->get('col_profession',0)) : ?>
					<td class="val_profession">
						<?php echo $this->escape($item->profession); ?>
					</td>
				<?php endif; ?>
				<?php if ($this->params->get('col_date',0)) : ?>
					<td class="val_date">
						<?php echo JHTML::_('date', $item->date, "%d %B %Y %H:%M") ?>
					</td>
				<?php endif; ?>
				<td class="val_city">
					<?php echo $item->localisation3; ?>
				</td>
				<?php if ($this->params->get('col_comment',0)) : ?>
					<td class="val_comment">
						<?php
							if ($item->comment) {
								$img = 'publish_g.png';
								$textcomment = $item->comment;
							} else{
								$img = 'publish_r.png';
								$textcomment = JText::_( 'petitions comments none' );
							}
						?>
						<a
							href="javascript:void(0);"
							onmouseover="return overlib(
								'<div style=\'background-color:#ffffff;\'><?php echo $this->escape($textcomment); ?></div>',
								CAPTION,
								'<div style=\'background-color:#000000;\'><?php echo JText::_( 'petitions signee comment' );?></div>',
								BELOW,
								RIGHT);"
							onmouseout="return nd();"
							>
							<img src="administrator/images/<?php echo $img; ?>" width="15" height="15" border="0" alt="" />
						</a>
					</td>
				<?php endif; ?>
			</tr>
		<?php endforeach; ?>
		<tr>
			<td align="center" colspan="4" class="sectiontablefooter<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
				<?php echo $this->pagination->getPagesLinks(); ?>
			</td>
		</tr>
		<tr>
			<td colspan="4" align="right" class="pagecounter">
				<?php echo $this->pagination->getPagesCounter(); ?>
			</td>
		</tr>
	</table>
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="" />
</form>