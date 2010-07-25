<?php defined('_JEXEC') or die('Restricted access'); ?>
<script language="javascript" type="text/javascript">
	function tableOrdering( order, dir, task ) {
	var form = document.adminForm;

	form.filter_order.value 	= order;
	form.filter_order_Dir.value	= dir;
	document.adminForm.submit( task );
}
</script>
<script type="text/javascript" src="includes/js/overlib_mini.js"></script>
<form action="<?php echo $this->action; ?>" method="post" name="adminForm">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td align="right" colspan="4">
				<?php
					echo JText::_('Display Num') .'&nbsp;';
					echo $this->pagination->getLimitBox();
				?>
			</td>
		</tr>
		<?php if ( $this->params->def( 'show_headings', 1 ) ) : ?>
			<tr>
				<td width="10" style="text-align:right;" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
					<?php echo JText::_('Num'); ?>
				</td>
				<?php if ($this->params->get('col_mail',0)) : ?>
					<td width="20%" height="20" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
						<?php echo JHTML::_('grid.sort', JText::_('petitions column number'), 'mail', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</td>
				<?php endif; ?>
				<?php if ($this->params->get('col_organisation',0)) : ?>
					<td width="20%" height="20" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
						<?php echo JHTML::_('grid.sort',  'Organisation', 'organisation', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</td>
				<?php endif; ?>
					<td width="20%" height="20" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
						<?php
						$surnamename = JText::_( 'surname', true ).' '.JText::_( 'name', true );
						echo JHTML::_('grid.sort', $surnamename, 'surname', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</td>
				<?php if ($this->params->get('col_profession',0)) : ?>
					<td width="20%" height="20" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
						<?php echo JHTML::_('grid.sort',  'Profession', 'profession', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</td>
				<?php endif; ?>
				<?php if ($this->params->get('col_date',0)) : ?>
					<td width="20%" height="20" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
						<?php echo JHTML::_('grid.sort', JText::_('petitions date'), 'date', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</td>
				<?php endif; ?>
					<td width="20%" height="20" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
						<?php echo JHTML::_('grid.sort', JText::_('petitions city'), 'localisation3', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</td>
				<?php if ($this->params->get('col_comment',0)) : ?>
					<td width="20%" height="20" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
						<?php echo JHTML::_('grid.sort', JText::_('petitions comment'), 'comment', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</td>
				<?php endif; ?>
				<?php if ( $this->params->get( 'show_link_hits' ) ) : ?>
					<td width="30" height="20" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?>" style="text-align:center;" nowrap="nowrap">
						<?php echo JHTML::_('grid.sort', JText::_('petitions hits'), 'hits', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</td>
				<?php endif; ?>
			</tr>
		<?php endif; ?>
		<?php foreach ($this->items as $item) : ?>
			<tr class="sectiontableentry<?php echo $item->odd + 1; ?>">
				<td align="right">
					<?php echo $this->pagination->getRowOffset( $item->count ); ?>
				</td>
				<?php if ($this->params->get('col_mail',0) AND $item->edit=='y') { ?>
					<td height="20">
						<?php echo "<a href=\"mailto:$item->mail\">".JHTML::_('image', 'components/com_petitions/images/email.png', $item->mail, 'title="'.$item->mail.'" border="0" height="16" width="16" class="png" hspace="3"')."</a>";?>
					</td>
				<?php } elseif ($this->params->get('col_mail',0)){?>
					<td height="20">
					</td>
				<?php } ?>
				<?php if ($this->params->get('col_organisation',0)) : ?>
					<td>
						<?php echo $item->organisation; ?>
					</td>
				<?php endif; ?>
					<td>
						<?php echo $item->surname; ?> <?php echo $item->name; ?>
					</td>
				<?php if ($this->params->get('col_profession',0)) : ?>
					<td>
						<?php echo $item->profession; ?>
					</td>
				<?php endif; ?>
				<?php if ($this->params->get('col_date',0)) : ?>
					<td>
						<?php echo JHTML::_('date', $item->date, "%d %B %Y %H:%M") ?>
					</td>
				<?php endif; ?>
					<td>
						<?php echo $item->localisation3; ?>
					</td>
				<?php if ($this->params->get('col_comment',0)) : ?>
					<td>
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
								'<div style="background-color:#ffffff;"><?php echo $textcomment; ?></div>',
								CAPTION,
								'<div style="background-color:#000000;"><?php echo JText::_( 'petitions signee comment' );?></div>',
								BELOW,
								RIGHT);"
							onmouseout="return nd();"
							>
							<img src="administrator/images/<?php echo $img;?>" width="15" height="15" border="0" alt="" />
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