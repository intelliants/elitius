<?php /* Smarty version 2.6.14, created on 2008-04-19 10:07:07
         compiled from register.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<h2><?php echo $this->_tpl_vars['lang']['create_new_account']; ?>
</h2>

<?php echo $this->_tpl_vars['msg']; ?>


<form name="create_account" action="register.php" method="post" >
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody>
	<tr>
		<td>
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
			<tr>
			    <td class="title"><?php echo $this->_tpl_vars['lang']['account_Info']; ?>
</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
    <tr>
		<td><img src="<?php echo $this->_tpl_vars['images']; ?>
pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
	</tr>
    <tr>
		<td class="smallText"><br><font color="#ff0000"><small><b><?php echo $this->_tpl_vars['lang']['NOTE']; ?>
:</b></small></font> <?php echo $this->_tpl_vars['lang']['already_have_account']; ?>
.</td>
	</tr>
    <tr>
		<td><img src="<?php echo $this->_tpl_vars['images']; ?>
pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
    </tr>
    <tr>
	    <td>
			<table border="0" cellpadding="2" cellspacing="0" width="100%">
			<tbody><tr>
            <td class="main"><b><?php echo $this->_tpl_vars['lang']['personal_details']; ?>
</b></td>
           <td class="inputRequirement" align="right">* <?php echo $this->_tpl_vars['lang']['required_info']; ?>
</td>
          </tr>
        </tbody></table></td>

      </tr>
      <tr>
        <td><table class="infoBox" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody><tr class="infoBoxContents">
            <td><table border="0" cellpadding="2" cellspacing="2">
              <tbody>
              <tr>
                <td class="title"><?php echo $this->_tpl_vars['lang']['first_name']; ?>
:</td>
                <td class="main"><input name="firstname" type="text" value="<?php echo $this->_tpl_vars['form']['firstname']; ?>
">&nbsp;<span class="inputRequirement">*</span></td>
              </tr>
              <tr>
                <td class="title"><?php echo $this->_tpl_vars['lang']['last_name']; ?>
:</td>

                <td class="main"><input name="lastname" type="text" value="<?php echo $this->_tpl_vars['form']['lastname']; ?>
">&nbsp;<span class="inputRequirement">*</span></td>
              </tr>
              <tr>

                <td class="title"><?php echo $this->_tpl_vars['lang']['email_address']; ?>
:</td>
                <td class="main"><input name="email" type="text" value="<?php echo $this->_tpl_vars['form']['email']; ?>
">&nbsp;<span class="inputRequirement">*</span></td>
              </tr>
              <tr>

                <td class="title"><?php echo $this->_tpl_vars['lang']['tax_id']; ?>
:</td>
                <td class="main"><input name="taxid" type="text" value="<?php echo $this->_tpl_vars['form']['taxid']; ?>
">&nbsp;<span class="inputRequirement">*</span></td>
              </tr>
              <tr>
                <td class="title"><?php echo $this->_tpl_vars['lang']['checks_payable']; ?>
:</td>
                <td class="main"><input name="check" type="text" value="<?php echo $this->_tpl_vars['form']['check']; ?>
">&nbsp;<span class="inputRequirement">*</span></td>
              </tr>

            </tbody></table></td>
          </tr>
        </tbody></table></td>
      </tr>
      <tr>

        <td><img src="<?php echo $this->_tpl_vars['images']; ?>
pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo $this->_tpl_vars['lang']['company_details']; ?>
</b></td>
      </tr>
      <tr>
        <td><table class="infoBox" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody><tr class="infoBoxContents">

            <td><table border="0" cellpadding="2" cellspacing="2">
              <tbody>
			<tr>
                <td class="title"><?php echo $this->_tpl_vars['lang']['company_name']; ?>
:</td>
                <td class="main"><input name="company" type="text" value="<?php echo $this->_tpl_vars['form']['company']; ?>
">&nbsp;<span class="inputRequirement">*</span></td>
            </tr>
			<tr>
                <td class="title"><?php echo $this->_tpl_vars['lang']['website_url']; ?>
:</td>
                <td class="main"><input name="url" type="text" value="<?php echo $this->_tpl_vars['form']['url']; ?>
">&nbsp;<span class="inputRequirement">*</span></td>
            </tr>
            </tbody></table></td>
          </tr>
        </tbody></table></td>

      </tr>
      <tr>
        <td><img src="<?php echo $this->_tpl_vars['images']; ?>
pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo $this->_tpl_vars['lang']['your_address']; ?>
</b></td>
      </tr>
      <tr>

        <td><table class="infoBox" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody><tr class="infoBoxContents">
            <td><table border="0" cellpadding="2" cellspacing="2">
              <tbody><tr>
                <td class="title"><?php echo $this->_tpl_vars['lang']['street_address']; ?>
:</td>
                <td class="main"><input name="address" type="text" value="<?php echo $this->_tpl_vars['form']['address']; ?>
">&nbsp;<span class="inputRequirement">*</span></td>
              </tr>
              <tr>
                <td class="title"><?php echo $this->_tpl_vars['lang']['zip_code']; ?>
:</td>
                <td class="main"><input name="zip" type="text" value="<?php echo $this->_tpl_vars['form']['zip']; ?>
">&nbsp;<span class="inputRequirement">*</span></td>
              </tr>

              <tr>
                <td class="title"><?php echo $this->_tpl_vars['lang']['frontend_city']; ?>
:</td>
                <td class="main"><input name="city" type="text" value="<?php echo $this->_tpl_vars['form']['city']; ?>
">&nbsp;<span class="inputRequirement">*</span></td>
              </tr>
              <tr>
                <td class="title"><?php echo $this->_tpl_vars['lang']['state_province']; ?>
:</td>
                <td class="main">

					<input name="state" type="text" value="<?php echo $this->_tpl_vars['form']['state']; ?>
">&nbsp;<span class="inputRequirement">*</span></td>
              </tr>
              <tr>
                <td class="title"><?php echo $this->_tpl_vars['lang']['frontend_country']; ?>
:</td>
                <td class="main"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "countries.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>

              </tr>
            </tbody></table></td>
          </tr>
        </tbody></table></td>
      </tr>
      <tr>
        <td><img src="<?php echo $this->_tpl_vars['images']; ?>
pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
      </tr>
      <tr>

        <td class="main"><b><?php echo $this->_tpl_vars['lang']['your_contact_Info']; ?>
</b></td>
      </tr>
      <tr>
        <td><table class="infoBox" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody><tr class="infoBoxContents">
            <td><table border="0" cellpadding="2" cellspacing="2">
              <tbody><tr>
                <td class="title"><?php echo $this->_tpl_vars['lang']['telephone_number']; ?>
:</td>

                <td class="main"><input name="phone" type="text" value="<?php echo $this->_tpl_vars['form']['phone']; ?>
">&nbsp;<span class="inputRequirement">*</span></td>
              </tr>
              <tr>
                <td class="title"><?php echo $this->_tpl_vars['lang']['fax_number']; ?>
:</td>
                <td class="main"><input name="fax" type="text" value="<?php echo $this->_tpl_vars['form']['fax']; ?>
">&nbsp;</td>
              </tr>
            </tbody></table></td>
          </tr>

        </tbody></table></td>
      </tr>
      <tr>
        <td><img src="<?php echo $this->_tpl_vars['images']; ?>
pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
      </tr>
      <tr>
        <td><img src="<?php echo $this->_tpl_vars['images']; ?>
pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo $this->_tpl_vars['lang']['your_password']; ?>
</b></td>

      </tr>
      <tr>
        <td><table class="infoBox" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody><tr class="infoBoxContents">
            <td><table border="0" cellpadding="2" cellspacing="2">
              <tbody>
			<tr>
                <td class="title"><?php echo $this->_tpl_vars['lang']['username']; ?>
:</td>
                <td class="main"><input name="username" type="text" value="<?php echo $this->_tpl_vars['form']['username']; ?>
">&nbsp;<span class="inputRequirement">*</span></td>
            </tr>
			<tr>
                <td class="title"><?php echo $this->_tpl_vars['lang']['password']; ?>
:</td>
                <td class="main"><input name="password" maxlength="40" type="password" value="<?php echo $this->_tpl_vars['form']['password']; ?>
">&nbsp;<span class="inputRequirement">*</span></td>
            </tr>
              <tr>
                <td class="title"><?php echo $this->_tpl_vars['lang']['password_confirm']; ?>
:</td>
                <td class="main"><input name="password2" maxlength="40" type="password" value="<?php echo $this->_tpl_vars['form']['password']; ?>
">&nbsp;<span class="inputRequirement">*</span></td>
              </tr>
            </tbody></table></td>
          </tr>
        </tbody></table></td>

      </tr>
      <tr>
        <td><img src="<?php echo $this->_tpl_vars['images']; ?>
pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
      </tr>
      <tr>
        <td><table class="infoBox" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody><tr class="infoBoxContents">
            <td><table border="0" cellpadding="2" cellspacing="0" width="100%">
              <tbody><tr style="text-align: right;">

                <td width="10"><img src="<?php echo $this->_tpl_vars['images']; ?>
pixel_trans.gif" alt="" border="0" height="1" width="10"></td>
                <td><input src="<?php echo $this->_tpl_vars['images']; ?>
button_continue.gif" alt=" <?php echo $this->_tpl_vars['lang']['continue']; ?>
 " title=" <?php echo $this->_tpl_vars['lang']['continue']; ?>
 " border="0" type="image"></td>
                <td width="10"><img src="<?php echo $this->_tpl_vars['images']; ?>
pixel_trans.gif" alt="" border="0" height="1" width="10"></td>
              </tr>
            </tbody></table></td>
          </tr>
        </tbody></table></td>
      </tr>
    </tbody></table>

	<input type="hidden" name="register" value="1" />
</form>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>