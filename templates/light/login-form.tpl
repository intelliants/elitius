		<div class="login-small">
			
			<h3 class="miniheader">{$lang.login}</h3>
			<table cellpadding="0" cellspacing="0" id="toolbar" style="border: 0;">
				<tr height="60" valign="top" align="center">
					<td>
						<form action="login.php" method="post" name="login" style="text-align: left;">
							<table class="login-form" cellpadding="0" cellspacing="0">
								<tr>
									<td>
										<label for="mod_login_username">{$lang.username}</label><br />
										<input name="username" id="mod_login_username" class="inputbox-small" size="18" type="text"/><br />
									</td>
								</tr>
								<tr>
									<td>
										<label for="mod_login_password">{$lang.password}</label><br/>
										<input id="mod_login_password" name="password" class="inputbox-small" size="18" alt="password" type="password"/><br/>
									</td>
								</tr>
								<tr>
									<td>
										<input name="option" value="login" type="hidden"/>
										<input name="Submit" class="button-small" value="{$lang.login}" type="submit"/>
									</td>
								</tr>
								<tr>
									<td>
										<a href="forgot.php">{$lang.forgot_password}</a>
									</td>
								</tr>
								<tr>
									<td>
										<span style="font-size: 13px;">{$lang.no_account_yet}</span><br/><a href="register.php">{$lang.create_one}</a>
									</td>
								</tr>
							</table>
							<input type="hidden" name="authorize" value="1" />
						</form>
					</td>
				</tr>
			</table>

		</div>
