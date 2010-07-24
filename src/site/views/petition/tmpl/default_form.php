<?php defined('_JEXEC') or die('Restricted access'); ?>
<script language="javascript" type="text/javascript">
	/*<![CDATA[*/
		function submitbutton()
		{
			// do field validation
			regex =/^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/;
			regex2 = /^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/;
			if (document.getElementById('surname').value == "") {
				alert( "<?php echo JText::_( 'Vous devez saisir votre nom.', true ); ?>" );
				return false;
			} else if (document.getElementById('name').value == "") {
				alert( "<?php echo JText::_( 'Vous devez saisir votre prenom.', true ); ?>" );
				return false;
			} else if(document.getElementById('mail').value == "" ) {
				alert( "<?php echo JText::_( 'You must have a mail.', true ); ?>" );
				return false;
			} else if(!regex.test(document.getElementById('mail').value)) {
				alert( "<?php echo JText::_( 'You must have a valid mail.', true ); ?>" );
				return false;
			<?php if ($this->params->get('champ_url',0)) : ?>
			} else if((document.getElementById('url').value != "")&&(!regex2.test(document.getElementById('url').value))) {
				alert( "<?php echo JText::_( 'You must have a valid url.', true ); ?>" );
				return false;
			<?php endif; ?>
			<?php if ($this->params->get('use_captcha',0)) : ?>
			} else if (document.getElementById('ck_captcha_code').value == ""){
				alert( "<?php echo JText::_( 'You have to enter the captcha code', true ); ?>" );
			<?php endif; ?>
			return false;
			} else {
				document.petitionForm.submit();
			}
		}
	/*]]>*/
</script>
<script type="text/javascript">
	function reloadCAPTCHA() {
		var a= Math.floor(Math.random()*1000);
		document.getElementById('code').src='index.php?option=com_petitions&task=captcha&reload='+a;
	}
</script>
<?php if ($this->params->get('champ_commentaire',0)) : ?>
	<script language="Javascript">
		<!--// [CDATA[
			//	Mots interdits. (ne tient pas compte de la casse : 'WaGoN' sera d�tect� comme 'wagon' )
			var mots_interdits = new Array(<?php echo $this->params->get('disallowednames'); ?>);

			//	Si la variable suivante est � true, les mots interdits sont remplac�s par des �toiles.
			//	Sinon, il sont effac�s.
			var RemplacementEtoiles = true;

			//	Nombre de caract�res maximum du textarea
			//var Nombre_Caracteres_Maximum = <? echo $josp_maxicharcomment; ?>;
			var Nombre_Caracteres_Maximum = <?php echo $this->params->get('maxi_mots'); ?>;
			//	Nombre de caract�res minimimal � partir duquel il n'y a plus de doute :
			//	Le mot qui est scann� est bien un mot interdit.
			//	Valeur par d�faut : 4
			//	EXEMPLE :
			//		Mettez le mot 'con' dans le tableau des mots interdits.
			//		Tapez le mot conSpiration.
			//		Mettez le curseur du textarea juste avant le S.
			//		Tapez un espace. ===> le mot 'con' est remplac�.
			//		Si vous mettez la variable suivante � 3, et que vous recommencez l'op�ration, vous ne pourrez pas taper le mot conspiration.
			var Constante_Doute = 4;

			var StrLen;
			var Contenu;

			Constante_Doute--;

			function Etoiles(nb)	{
				v = '';
				j=0;
				while(j<nb)	{
					v += '*';
					j++;
				}
				if(!RemplacementEtoiles) v = '';
				return v;
			}

			function ReInit(valeur, nb, bool)	{
				if(bool == undefined)	bool = false;
				v = Etoiles(nb);
				espace = (RemplacementEtoiles) ? ' ' : '';
				Contenu = (! bool ) ? (valeur + v) : (v + espace + valeur);
				StrLen = Contenu.length;
			}

			function Compter(Target, compteur) {
				ReInit(Target.value, -1);
				for(i=0; i<mots_interdits.length; i++)	{
					reg = new RegExp(' '+mots_interdits[i]+' ', 'gi');
					v = ' '+Etoiles(mots_interdits[i].length)+' ';

					if((!RemplacementEtoiles)&&(i==0)) v += ' ';
					ReInit(Contenu.replace(reg, v), -1);

					if(Contenu.substring(0, mots_interdits[i].length+1).toLowerCase() == mots_interdits[i].toLowerCase()+' ')
						ReInit(Contenu.substring(mots_interdits[i].length+1, StrLen), mots_interdits[i].length, true);

					if((Contenu.substring(StrLen-mots_interdits[i].length, StrLen).toLowerCase() == mots_interdits[i].toLowerCase()) && (mots_interdits[i].length>Constante_Doute))
						ReInit(Contenu.substring(0, StrLen-mots_interdits[i].length), mots_interdits[i].length);
					/*
						script par SirJojO ===> forums http://www.editeurjavascript.com/
					*/
				}
				if (StrLen > Nombre_Caracteres_Maximum ) {
					Erreur = false;
					for(i=0; i<mots_interdits.length; i++)	{
						if(Contenu.substring(StrLen-mots_interdits[i].length, StrLen).toLowerCase() == mots_interdits[i].toLowerCase())	{
							ReInit(Contenu.substring(0, StrLen-mots_interdits[i].length), mots_interdits[i].length, true);
							Erreur = true;
						}
					}
					if(!Erreur)	ReInit(Contenu.substring(0,Nombre_Caracteres_Maximum), -1);
				}
				Target.value = Contenu;
				compteur.value = Nombre_Caracteres_Maximum-StrLen;
			}
		// ]] -->
	</script>
<?php endif; ?>
<?php if(isset($this->error)) : ?>
	<tr>
		<td><?php echo $this->error; ?></td>
	</tr>
<?php endif; ?>
<form action="<?php echo $this->action ?>" method="post" name="petitionForm" id="petitionForm" >
	<div class="componentheading">
		<?php echo JText::_( 'Signer la petition' );?>
	</div>
	<table cellpadding="4" cellspacing="1" border="0" width="100%">
		<?php if ($this->params->get('champ_ip',0)) : ?>
			<tr>
				<td width="16%">
				<?php echo JTEXT::_('IP address'); ?>		</td>
				<td width="84%">
				<input type="text" class="inputbox"  value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" disabled="disabled" />		</td>
			</tr>
		<?php endif; ?>
		<tr>
			<td width="16%">
				<label for="petitiontitle">
					<?php echo JText::_( 'Civilite' ); ?> :
				</label>
			</td>
			<td width="84%">
				<?php /*//TODO this is gender*/ ?>
				<select style="width:150px;" class="inputbox" size="1" id="petitiontitle" name="title">
					<option value="" selected="selected"><?php echo JText::_( '--- Choose ---' ); ?></option>
					<option><?php echo JText::_( 'Civilite1' ); ?></option>
					<option><?php echo JText::_( 'Civilite2' ); ?></option>
					<option><?php echo JText::_( 'Civilite3' ); ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td width="16%">
				<label for="petitionsurname">
					<?php echo JText::_( 'Surname' ); ?> * :
				</label>
			</td>
			<td width="84%">
				<input class="inputbox required"  type="text" id="surname" name="surname" size="50" maxlength="250" value="<?php echo $this->escape($this->petition->surname);?>" />	</td>
		</tr>
		<tr>
			<td width="16%">
				<label for="petitionname">
					<?php echo JText::_( 'Name' ); ?> * :		</label>	</td>
			<td width="84%">
				<input class="inputbox" type="text" id="name" name="name" size="50" maxlength="250" value="<?php echo $this->escape($this->petition->name);?>" />	</td>
		</tr>
		<tr>
			<td width="16%">
				<label for="petitionorganisation">
					<?php echo JText::_( 'Organisation' ); ?> :		</label>	</td>
			<td width="84%">
				<input class="inputbox" type="text" id="petitionorganisation" name="organisation" size="50" maxlength="250" value="<?php echo $this->escape($this->petition->organisation);?>" />	</td>
		</tr>
		<?php if ($this->params->get('champ_age',0)) : ?>
			<tr>
				<td width="16%">
					<label for="petitionage">
						<?php echo JText::_( 'Age' ); ?> :		</label>	</td>
				<td width="84%">
					<select style="width:60px;" class="inputbox" size="1" id="petitionage" name="age">
						<option value="" selected="selected">-----</option>
						<option>- 18</option>
						<option>18-29</option>
						<option>30-39</option>
						<option>40-49</option>
						<option>50-59</option>
						<option>+ 59</option>
					</select>
			    </td>
			</tr>
		<?php endif; ?>
		<?php if ($this->params->get('champ_profession',0)) : ?>
			<tr>
				<td width="16%">
					<label for="petitionprofession">
						<?php echo JText::_( 'Profession' ); ?>:
					</label>
				</td>
				<td width="84%">
					<input class="inputbox" type="text" id="petitionprofession" name="profession" size="50" maxlength="100" value="<?php echo $this->escape($this->petition->profession);?>" />
				</td>
			</tr>
		<?php endif; ?>
		<tr>
			<td width="16%">
				<label for="petitionlocalisation">
					<?php echo JText::_( 'Localisation' ); ?> :
				</label>
			</td>
			<td width="84%">
				<input class="inputbox" type="text" id="petitionlocalisation" name="localisation" size="50" maxlength="100" value="<?php echo $this->escape($this->petition->localisation);?>" />
			</td>
		</tr>
		<tr>
			<td width="16%">
				<label for="petitionlocalisation2">
					<?php echo JText::_( 'Localisation2' ); ?> :
				</label>
			</td>
			<td width="84%">
				<input class="inputbox" type="text" id="petitionlocalisation2" name="localisation2" size="50" maxlength="15" value="<?php echo $this->escape($this->petition->localisation2);?>" />
			</td>
		</tr>
		<tr>
			<td width="16%">
				<label for="petitionlocalisation3">
					<?php echo JText::_( 'Localisation3' ); ?> :		</label>	</td>
			<td width="84%">
				<input class="inputbox" type="text" id="petitionlocalisation3" name="localisation3" size="50" maxlength="100" value="<?php echo $this->escape($this->petition->localisation3);?>" />
			</td>
		</tr>
		<tr>
			<td width="16%">
				<label for="petitionlocalisation4">
					<?php echo JText::_( 'Localisation4' ); ?> :
				</label>
			</td>
			<td width="84%">
				<select style="width:330px;" size="1" id="petitionlocalisation4" name="localisation4">
					<?php
						if (file_exists(JPATH_COMPONENT.DS.'liste_pays_$lang.php')) {
							include(JPATH_COMPONENT.DS.'liste_pays_$lang.php');
						} else {
							include(JPATH_COMPONENT.DS.'liste_pays_french.php');
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td valign="top">
				<label for="petitionmail">
					<?php echo JText::_( 'Mail' ); ?> * :
				</label>
			</td>
			<td>
				<input class="inputbox required validate-email" type="text" id="mail" name="mail" value="<?php echo $this->petition->mail; ?>" size="50" maxlength="100" />
				<input type="checkbox" name="edit" id="petitionedit" value="1" class="inputbox required" />
				<label for="petitionedit">
					<?php echo JText::_( 'Edit mail' ); ?>
				</label>
			</td>
		</tr>
		<?php if ($this->params->get('champ_url',0)) : ?>
			<tr>
				<td valign="top">
					<label for="petitionURL">
						<?php echo JText::_( 'URL' ); ?> :
					</label>
				</td>
				<td>
					<input class="inputbox" type="text" id="url" name="url" value="<?php echo $this->petition->url; ?>" size="50" maxlength="100" />
				</td>
			</tr>
		<?php endif; ?>
		<?php if ($this->params->get('champ_commentaire',0)) : ?>
			<tr>
				<td valign="top">
					<label for="petitioncomment">
						<?php echo JText::_( 'Comment' ); ?> :
					</label>
				</td>
				<td>
					<textarea class="inputbox" cols="30" rows="6" id="petitioncomment" name="comment" style="width:330px" onkeyup="Compter(this, this.form.CharRestant);"><?php echo $this->escape( $this->petition->comment);?></textarea><br/>
					<?php echo JText::_( 'Number of remaining Chars' ); ?> : <input type='text' name='CharRestant' size='2' disabled='disabled'>
				</td>
			</tr>
		<?php endif; ?>
		<?php if ($this->params->get('use_captcha',0)) : ?>
			<tr>
				<td align="left" height="40">
					<span class="ck_mandatory ckhidden">
						<?php echo JText::_( 'Code obligatoire' ); ?>
					</span> * :
				</td>
				<td align="left" height="40">
					<img id="code" src="index.php?option=com_petitions&task=captcha" />
					<a href="javascript:reloadCAPTCHA();">
						<img src='components/com_petitions/images/reload.gif' title='Recharger le code' alt='Recharger le code' border='0' />
					</a>
					<input type="text" id="ck_captcha_code" name="ck_captcha_code" size="15" maxlength="8" />
				</td>
			</tr>
		<?php endif; ?>

		<tr>
			<td colspan="2" height="40">
				<?php echo JText::_( 'Champs obligatoires' ); ?>
			</td>
		</tr>
	</table>

	<input type="hidden" name="catid" value="<?php echo $this->category->id; ?>" />
	<?php if (!$this->params->get('validation_signature',0)) : ?>
		<input type="hidden" name="published" value="1" />
	<?php endif; ?>
	<input type="hidden" name="ip" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" />
	<input type="hidden" name="option" value="com_petitions" />
	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="controller" value="petition" />

	<?php echo JHTML::_( 'form.token' ); ?>

	<div>
		<button class="button validate" onclick="return submitbutton();" ><?php echo JText::_('Signer') ?></button>
		<button class="button validate" type="reset"><?php echo JText::_('Effacer') ?></button>
	</div>

</form>