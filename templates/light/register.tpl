{include file="header.tpl"}

<h2>{$lang.create_new_account}</h2>

{$msg}

<form name="create_account" action="register.php" method="post" >
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody>
	<tr>
		<td>
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
			<tr>
			    <td class="title">{$lang.account_Info}</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
    <tr>
		<td><img src="{$images}pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
	</tr>
    <tr>
		<td class="smallText"><br><font color="#ff0000"><small><b>{$lang.NOTE}:</b></small></font> {$lang.already_have_account}.</td>
	</tr>
    <tr>
		<td><img src="{$images}pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
    </tr>
    <tr>
	    <td>
			<table border="0" cellpadding="2" cellspacing="0" width="100%">
			<tbody><tr>
            <td class="main"><b>{$lang.personal_details}</b></td>
           <td class="inputRequirement" align="right">* {$lang.required_info}</td>
          </tr>
        </tbody></table></td>

      </tr>
      <tr>
        <td><table class="infoBox" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody><tr class="infoBoxContents">
            <td><table border="0" cellpadding="2" cellspacing="2">
              <tbody>
              <tr>
                <td class="title">{$lang.first_name}:</td>
                <td class="main"><input name="firstname" type="text" value="{$form.firstname}">&nbsp;<span class="inputRequirement">*</span></td>
              </tr>
              <tr>
                <td class="title">{$lang.last_name}:</td>

                <td class="main"><input name="lastname" type="text" value="{$form.lastname}">&nbsp;<span class="inputRequirement">*</span></td>
              </tr>
              <tr>

                <td class="title">{$lang.email_address}:</td>
                <td class="main"><input name="email" type="text" value="{$form.email}">&nbsp;<span class="inputRequirement">*</span></td>
              </tr>
              <tr>

                <td class="title">{$lang.tax_id}:</td>
                <td class="main"><input name="taxid" type="text" value="{$form.taxid}">&nbsp;<span class="inputRequirement">*</span></td>
              </tr>
              <tr>
                <td class="title">{$lang.checks_payable}:</td>
                <td class="main"><input name="check" type="text" value="{$form.check}">&nbsp;<span class="inputRequirement">*</span></td>
              </tr>

            </tbody></table></td>
          </tr>
        </tbody></table></td>
      </tr>
      <tr>

        <td><img src="{$images}pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
      </tr>
      <tr>
        <td class="main"><b>{$lang.company_details}</b></td>
      </tr>
      <tr>
        <td><table class="infoBox" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody><tr class="infoBoxContents">

            <td><table border="0" cellpadding="2" cellspacing="2">
              <tbody>
			<tr>
                <td class="title">{$lang.company_name}:</td>
                <td class="main"><input name="company" type="text" value="{$form.company}">&nbsp;<span class="inputRequirement">*</span></td>
            </tr>
			<tr>
                <td class="title">{$lang.website_url}:</td>
                <td class="main"><input name="url" type="text" value="{$form.url}">&nbsp;<span class="inputRequirement">*</span></td>
            </tr>
            </tbody></table></td>
          </tr>
        </tbody></table></td>

      </tr>
      <tr>
        <td><img src="{$images}pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
      </tr>
      <tr>
        <td class="main"><b>{$lang.your_address}</b></td>
      </tr>
      <tr>

        <td><table class="infoBox" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody><tr class="infoBoxContents">
            <td><table border="0" cellpadding="2" cellspacing="2">
              <tbody><tr>
                <td class="title">{$lang.street_address}:</td>
                <td class="main"><input name="address" type="text" value="{$form.address}">&nbsp;<span class="inputRequirement">*</span></td>
              </tr>
              <tr>
                <td class="title">{$lang.zip_code}:</td>
                <td class="main"><input name="zip" type="text" value="{$form.zip}">&nbsp;<span class="inputRequirement">*</span></td>
              </tr>

              <tr>
                <td class="title">{$lang.frontend_city}:</td>
                <td class="main"><input name="city" type="text" value="{$form.city}">&nbsp;<span class="inputRequirement">*</span></td>
              </tr>
              <tr>
                <td class="title">{$lang.state_province}:</td>
                <td class="main">

					<input name="state" type="text" value="{$form.state}">&nbsp;<span class="inputRequirement">*</span></td>
              </tr>
              <tr>
                <td class="title">{$lang.frontend_country}:</td>
                <td class="main">{include file="countries.tpl"}</td>

              </tr>
            </tbody></table></td>
          </tr>
        </tbody></table></td>
      </tr>
      <tr>
        <td><img src="{$images}pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
      </tr>
      <tr>

        <td class="main"><b>{$lang.your_contact_Info}</b></td>
      </tr>
      <tr>
        <td><table class="infoBox" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody><tr class="infoBoxContents">
            <td><table border="0" cellpadding="2" cellspacing="2">
              <tbody><tr>
                <td class="title">{$lang.telephone_number}:</td>

                <td class="main"><input name="phone" type="text" value="{$form.phone}">&nbsp;<span class="inputRequirement">*</span></td>
              </tr>
              <tr>
                <td class="title">{$lang.fax_number}:</td>
                <td class="main"><input name="fax" type="text" value="{$form.fax}">&nbsp;</td>
              </tr>
            </tbody></table></td>
          </tr>

        </tbody></table></td>
      </tr>
      <tr>
        <td><img src="{$images}pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
      </tr>
      <tr>
        <td><img src="{$images}pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
      </tr>
      <tr>
        <td class="main"><b>{$lang.your_password}</b></td>

      </tr>
      <tr>
        <td><table class="infoBox" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody><tr class="infoBoxContents">
            <td><table border="0" cellpadding="2" cellspacing="2">
              <tbody>
			<tr>
                <td class="title">{$lang.username}:</td>
                <td class="main"><input name="username" type="text" value="{$form.username}">&nbsp;<span class="inputRequirement">*</span></td>
            </tr>
			<tr>
                <td class="title">{$lang.password}:</td>
                <td class="main"><input name="password" maxlength="40" type="password" value="{$form.password}">&nbsp;<span class="inputRequirement">*</span></td>
            </tr>
              <tr>
                <td class="title">{$lang.password_confirm}:</td>
                <td class="main"><input name="password2" maxlength="40" type="password" value="{$form.password}">&nbsp;<span class="inputRequirement">*</span></td>
              </tr>
            </tbody></table></td>
          </tr>
        </tbody></table></td>

      </tr>
      <tr>
        <td><img src="{$images}pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
      </tr>
      <tr>
        <td><table class="infoBox" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody><tr class="infoBoxContents">
            <td><table border="0" cellpadding="2" cellspacing="0" width="100%">
              <tbody><tr style="text-align: right;">

                <td width="10"><img src="{$images}pixel_trans.gif" alt="" border="0" height="1" width="10"></td>
                <td><input src="{$images}button_continue.gif" alt=" {$lang.continue} " title=" {$lang.continue} " border="0" type="image"></td>
                <td width="10"><img src="{$images}pixel_trans.gif" alt="" border="0" height="1" width="10"></td>
              </tr>
            </tbody></table></td>
          </tr>
        </tbody></table></td>
      </tr>
    </tbody></table>

	<input type="hidden" name="register" value="1" />
</form>

{include file="footer.tpl"}
