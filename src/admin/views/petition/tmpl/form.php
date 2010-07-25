<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	// Set toolbar items for the page
	$edit		= JRequest::getVar('edit',true);
	$text = !$edit ? JText::_( 'New' ) : JText::_( 'Edit' );
	JToolBarHelper::title(   JText::_( 'Petition' ).': <small><small>[ ' . $text.' ]</small></small>' );
	JToolBarHelper::save();
	if (!$edit)  {
		JToolBarHelper::cancel();
	} else {
		// for existing items the button is renamed `close`
		JToolBarHelper::cancel( 'cancel', 'Close' );
	}
	JToolBarHelper::help( 'screen.petition.edit' );
?>

<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}

		// do field validation
		if (form.surname.value == ""){
			alert( "<?php echo JText::_( 'Petition item must have a surname', true ); ?>" );
		} else if (form.catid.value == "0"){
			alert( "<?php echo JText::_( 'You must select a category', true ); ?>" );
		} else if (form.mail.value == ""){
			alert( "<?php echo JText::_( 'You must have a mail.', true ); ?>" );
		} else {
			submitform( pressbutton );
		}
	}
</script>
<style type="text/css">
	table.paramlist td.paramlist_key {
		width: 92px;
		text-align: left;
		height: 30px;
	}
</style>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col width-50">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>
		<table class="admintable">
			<tr>
				<td width="100" align="right" class="key">
					<label for="ip">
						<?php echo JText::_( 'IP' ); ?> :
					</label>
				</td>
				<td>
					<input class="text_area" type="text" name="ip" id="ip" size="32" maxlength="100" value="<?php echo $this->petition->ip;?>" />
				</td>
			</tr>
			<tr>
				<td width="100" align="right" class="key">
					<label for="title">
						<?php echo JText::_( 'Civilite' ); ?> :
					</label>
				</td>
				<td>
					<input class="text_area" type="text" name="title" id="title" size="32" maxlength="30" value="<?php echo $this->petition->title;?>" />
				</td>
			</tr>
			<tr>
				<td width="100" align="right" class="key">
					<label for="surname">
						<?php echo JText::_( 'Surname' ); ?> :
					</label>
				</td>
				<td>
					<input class="text_area" type="text" name="surname" id="surname" size="32" maxlength="100" value="<?php echo $this->petition->surname;?>" />
				</td>
			</tr>
			<tr>
				<td width="100" align="right" class="key">
					<label for="name">
						<?php echo JText::_( 'Name' ); ?> :
					</label>
				</td>
				<td>
					<input class="text_area" type="text" name="name" id="name" size="32" maxlength="100" value="<?php echo $this->petition->name;?>" />
				</td>
			</tr>
			<tr>
				<td width="100" align="right" class="key">
					<label for="organisation">
						<?php echo JText::_( 'Organisation' ); ?> :
					</label>
				</td>
				<td>
					<input class="text_area" type="text" name="organisation" id="organisation" size="32" maxlength="250" value="<?php echo $this->petition->organisation;?>" />
				</td>
			</tr>
			<tr>
				<td width="100" align="right" class="key">
					<label for="mail">
						<?php echo JText::_( 'Email' ); ?> :
					</label>
				</td>
				<td>
					<input class="text_area" type="text" name="mail" id="mail" size="32" maxlength="250" value="<?php echo $this->petition->mail;?>" />
				</td>
			</tr>
			<tr>
				<td width="100" align="right" class="key">
					<label for="edit">
						<?php echo JText::_( 'Show' ); ?> <?php echo JText::_( 'Mail' ); ?>:
					</label>
				</td>
				<td>
					<input class="text_area" type="radio" name="edit" id="edit" value="y" <?php if($this->petition->edit=='y'){echo "checked='checked'";} ?> /><?php echo JText::_( 'Yes' ); ?>
					<input class="text_area" type="radio" name="edit" id="edit" value="n" <?php if($this->petition->edit=='n'){echo "checked='checked'";} ?> /><?php echo JText::_( 'No' ); ?>
				</td>
			</tr>
			<tr>
				<td valign="top" align="right" class="key">
					<label for="url">
						<?php echo JText::_( 'URL' ); ?> :
					</label>
				</td>
				<td>
					<input class="text_area" type="text" name="url" id="url" value="<?php echo $this->petition->url; ?>" size="32" maxlength="250" />
				</td>
			</tr>
			<tr>
				<td width="100" align="right" class="key">
					<label for="age">
						<?php echo JText::_( 'Age' ); ?> :
					</label>
				</td>
				<td>
					<input class="text_area" type="text" name="age" id="age" size="32" maxlength="250" value="<?php echo $this->petition->age;?>" />
				</td>
			</tr>
			<tr>
				<td width="100" align="right" class="key">
					<label for="profession">
						<?php echo JText::_( 'Profession' ); ?> :
					</label>
				</td>
				<td>
					<input class="text_area" type="text" name="profession" id="profession" size="32" maxlength="250" value="<?php echo $this->petition->profession;?>" />
				</td>
			</tr>
			<tr>
				<td width="100" align="right" class="key">
					<label for="localisation">
						<?php echo JText::_( 'Localisation' ); ?> :
					</label>
				</td>
				<td>
					<input class="text_area" type="text" name="localisation" id="localisation" size="32" maxlength="250" value="<?php echo $this->petition->localisation;?>" />
				</td>
			</tr>
			<tr>
				<td width="100" align="right" class="key">
					<label for="localisation2">
						<?php echo JText::_( 'Localisation2' ); ?> :
					</label>
				</td>
				<td>
					<input class="text_area" type="text" name="localisation2" id="localisation2" size="32" maxlength="250" value="<?php echo $this->petition->localisation2;?>" />
				</td>
			</tr>
			<tr>
				<td width="100" align="right" class="key">
					<label for="localisation3">
						<?php echo JText::_( 'Localisation3' ); ?> :
					</label>
				</td>
				<td>
					<input class="text_area" type="text" name="localisation3" id="localisation3" size="32" maxlength="250" value="<?php echo $this->petition->localisation3;?>" />
				</td>
			</tr>
			<tr>
				<td width="100" align="right" class="key">
					<label for="localisation4">
						<?php echo JText::_( 'Localisation4' ); ?> :
					</label>
				</td>
				<td>
					<input class="text_area" type="text" name="localisation4" id="localisation4" size="32" maxlength="250" value="<?php echo $this->petition->localisation4;?>" />
				</td>
			</tr>
			<tr>
				<td valign="top" align="right" class="key">
					<?php echo JText::_( 'Approved' ); ?> :
				</td>
				<td>
					<?php echo $this->lists['approved']; ?>
				</td>
			</tr>
			<tr>
				<td valign="top" align="right" class="key">
					<?php echo JText::_( 'Published' ); ?> :
				</td>
				<td>
					<?php echo $this->lists['published']; ?>
				</td>
			</tr>
			<tr>
				<td width="100" align="right" class="key">
					<label for="date">
						<?php echo JText::_( 'Date' ); ?>:
					</label>
				</td>
				<td>
					<?php echo JHTML::_('calendar', $this->petition->date, 'date', 'date', '%Y-%m-%d %H:%M:%S', array('class'=>'text_area', 'size'=>'32',  'maxlength'=>'19')); ?>
				</td>
			</tr>
			<tr>
				<td valign="top" align="right" class="key">
					<label for="catid">
						<?php echo JText::_( 'Category' ); ?> :
					</label>
				</td>
				<td>
					<?php echo $this->lists['catid']; ?>
				</td>
			</tr>
			<tr>
				<td valign="top" align="right" class="key">
					<label for="ordering">
						<?php echo JText::_( 'Ordering' ); ?> :
					</label>
				</td>
				<td>
					<?php echo $this->lists['ordering']; ?>
				</td>
			</tr>
		</table>
	</fieldset>
</div>
<div class="col width-50">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Parameters' ); ?></legend>

		<table class="admintable">
		<tr>
			<td colspan="2">
				<?php echo $this->params->render();?>
			</td>
		</tr>
		</table>
	</fieldset>
</div>

<div class="col width-50">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Comment' ); ?></legend>

		<table class="admintable">
		<tr>
			<td>
				<textarea class="text_area" cols="44" rows="9" name="comment" id="comment"><?php echo $this->petition->comment; ?></textarea>
			</td>
		</tr>
		</table>
	</fieldset>
</div>
<div class="clr"></div>

	<input type="hidden" name="option" value="com_petitions" />
	<input type="hidden" name="cid[]" value="<?php echo $this->petition->id; ?>" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>