DROP TABLE IF EXISTS `{prefix}admins`;
CREATE TABLE `{prefix}admins` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `username` varchar(50) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `super` enum('0','1') NOT NULL default '0',
  `date` date NOT NULL default '0000-00-00',
  `time` time NOT NULL default '00:00:00',
  `primary` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `{prefix}multi_tier_levels`;
CREATE TABLE `{prefix}multi_tier_levels` (
`id` int( 10 ) NOT NULL AUTO_INCREMENT ,
`level` int( 10 ) NOT NULL default '0',
`amt` decimal( 10, 2 ) NOT NULL default '0.00',
PRIMARY KEY ( `id` ) 
) TYPE = MYISAM ;

INSERT INTO `{prefix}multi_tier_levels` VALUES (1, 1, 18.00);
INSERT INTO `{prefix}multi_tier_levels` VALUES (2, 2, 10.00);
INSERT INTO `{prefix}multi_tier_levels` VALUES (3, 3, 5.00);

INSERT INTO `{prefix}admins` ( `id` , `username` , `password` , `email` , `super` , `date` , `time` , `primary` )
VALUES ( 1 , '{admin_username}', '{admin_password}', '{email}', '1', NOW(), NOW(), '1');

DROP TABLE IF EXISTS `{prefix}commissions`;
CREATE TABLE `{prefix}commissions` (
  `id` int(11) NOT NULL auto_increment,
  `aff_id` int(11) NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `payout` decimal(10,2) NOT NULL default '0.00',
  `order_number` varchar(64) NOT NULL default '',
  `tier_aff_id` int(11) NOT NULL default '0',
  `percentage` varchar(4) NOT NULL default '',
  `type_commission` varchar(10) NOT NULL default '',
  `approved` enum('0','1','2') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `{prefix}ads`;
CREATE TABLE `{prefix}ads` (
  `id` int(10) NOT NULL auto_increment,
  `pid` int(11) NOT NULL default '0',
  `title` varchar(64) NOT NULL default '',
  `content` text NOT NULL,
  `visible` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `{prefix}affiliates`;
CREATE TABLE `{prefix}affiliates` (
  `id` int(10) NOT NULL auto_increment,
  `date_reg` datetime NOT NULL default '0000-00-00 00:00:00',
  `username` varchar(50) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `approved` enum('0','1','2') NOT NULL default '1',
  `firstname` varchar(50) NOT NULL default '',
  `lastname` varchar(50) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `address` varchar(64) NOT NULL default '',
  `city` varchar(64) NOT NULL default '',
  `state` varchar(40) NOT NULL default '',
  `zip` varchar(20) NOT NULL default '',
  `country` varchar(64) NOT NULL default '',
  `phone` varchar(40) NOT NULL default '',
  `fax` varchar(40) NOT NULL default '',
  `url` varchar(128) NOT NULL default '',
  `hits` int(255) NOT NULL default '0',
  `sales` int(255) NOT NULL default '0',
  `level` int(5) NOT NULL default '0',
  `parent` int(11) NOT NULL default '0',
  `taxid` varchar(50) NOT NULL default '',
  `check` varchar(64) NOT NULL default '',
  `company` varchar(64) NOT NULL default '',
  `paypal_email` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `{prefix}archived_sales`;
CREATE TABLE `{prefix}archived_sales` (
  `id` int(100) NOT NULL auto_increment,
  `aff_id` int(255) NOT NULL default '0',
  `uid` int(10) NOT NULL default '0',
  `date` date NOT NULL default '0000-00-00',
  `time` time NOT NULL default '00:00:00',
  `payment` decimal(10,2) NOT NULL default '0.00',
  `payout` decimal(10,2) NOT NULL default '0.00',
  `ip` varchar(64) NOT NULL default '',
  `order_number` varchar(64) NOT NULL default '',
  `merchant` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `record` (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `{prefix}banners`;
CREATE TABLE `{prefix}banners` (
  `id` int(3) NOT NULL auto_increment,
  `pid` int(11) NOT NULL default '0',
  `visible` enum('0','1') NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `x` int(10) NOT NULL default '0',
  `y` int(10) NOT NULL default '0',
  `path` varchar(64) NOT NULL default '',
  `desc` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `{prefix}config`;
CREATE TABLE `{prefix}config` (
  `id` int(4) NOT NULL auto_increment,
  `id_group` tinyint(4) NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  `multiple_values` text NOT NULL,
  `type` enum('text','textarea','checkbox','radio','select','divider','hidden') NOT NULL default 'text',
  `description` text NOT NULL,
  `order` float NOT NULL default '0',
  `hint` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) TYPE=MyISAM;

INSERT INTO `{prefix}config` VALUES (1, 1, 'company_name', '', '1', 'text', 'Company or Website name', 2, 'Enter your Company or Website name');
INSERT INTO `{prefix}config` VALUES (3, 2, 'pay_day', '1st', '''1st'',''2nd'',''3rd'',''4th'',''5th'',''7th'',''8th'',''9th'',''10th'',''11th'',''12th'',''13th'',''14th'',''15th'',''16th'',''17th'',''18th'',''19th'',''20th'',''21st'',''22nd'',''23rd'',''24th'',''25th'',''26th'',''27th'',''28th'',''29th'',''30th'',''31st''', 'select', 'Pay Day (day of the month)', 20, 'Pay Day - day of the month when your affiliates is paid');
INSERT INTO `{prefix}config` VALUES (9, 2, 'payout_balance', '20', '1', 'text', 'Payout Balance Required', 22, 'Minimum balance the affiliate must have to be paid. If affiliate balance does not meet minimum payout balance requirement, the earned money is transferred to the next month balance.');
INSERT INTO `{prefix}config` VALUES (14, 1, 'xpurl', '{xpurl}', '1', 'text', 'eLitius Installation URL', 4, 'Enter eLitius installation URL here (tipically it is xp folder)');
INSERT INTO `{prefix}config` VALUES (6, 1, 'incoming_page', '{incoming_page}', '1', 'text', 'Incoming Traffic Page', 5, 'Your site incoming traffic page, usually: http://www.yoursite.com/index.php or html');
INSERT INTO `{prefix}config` VALUES (7, 1, 'admin_email', '{email}', '1', 'text', 'Administrator Email', 6, 'Administrator email');
INSERT INTO `{prefix}config` VALUES (13, 1, 'base', '{base}', '1', 'text', 'Website URL', 3, 'Your website url');
INSERT INTO `{prefix}config` VALUES (8, 2, 'credit_style', '1', '''0'',''1''', 'select', 'Crediting Style', 21, 'This Option lets you set which affiliate gets credits first or last one');
INSERT INTO `{prefix}config` VALUES (15, 1, 'templates', 'templates/', '1', 'text', 'Templates directory', 12, 'Directory where templates for affiliate panel are located');
INSERT INTO `{prefix}config` VALUES (12, 2, 'payout_percent', '18', '1', 'text', 'Payout Level (%)', 25, 'Payout Level shows what percentage the affiliate earns');
INSERT INTO `{prefix}config` VALUES (16, 1, 'tmpl', '{tmpl}', '{tmpl-multi}', 'select', 'Your skin template', 13, 'The Affiliate Panel template you are currently using');
INSERT INTO `{prefix}config` VALUES (17, 1, 'lang', '{lang}', '{lang-multi}', 'select', 'Script language', 15, 'Language that is currently in use');
INSERT INTO `{prefix}config` VALUES (18, 1, 'charset', 'utf-8', '1', 'text', 'Default charset for pages', 16, 'Default charset for template pages');
INSERT INTO `{prefix}config` VALUES (19, 2, 'auto_approve_affiliate', '1', "'0','1'", 'select', 'Auto Approve Affiliates', 26, '');
INSERT INTO `{prefix}config` VALUES (20, 2, 'use_muti_tier', '0', "'0','1'", 'select', 'Use Multi-tier', 28, '');


DROP TABLE IF EXISTS `{prefix}config_categs`;
CREATE TABLE `{prefix}config_categs` (
  `id` smallint(6) NOT NULL auto_increment,
  `title` varchar(150) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

INSERT INTO `{prefix}config_categs` (`id`, `title`) VALUES (1, 'Global Configuration'),
(2, 'Accounts'),
(3, 'Sales and Commissions'),
(4, 'Marketing'),
(5, 'Statistics'),
(6, 'Help');

DROP TABLE IF EXISTS `{prefix}config_groups`;
CREATE TABLE `{prefix}config_groups` (
  `id` smallint(6) NOT NULL auto_increment,
  `id_categ` smallint(6) NOT NULL default '0',
  `title` varchar(150) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

INSERT INTO `{prefix}config_groups` (`id`, `id_categ`, `title`) VALUES (1, 1, 'Site Configuration'),
(2, 1, 'General Settings'),
(3, 1, 'Email Templates'),
(4, 1, 'Statistics'),
(5, 1, 'Database Backup'),
(6, 1, 'Commission Statistics'),
(7, 1, 'Admin Manager'),
(8, 2, 'Account Manager'),
(9, 2, 'Approve Accounts'),
(10, 2, 'Tier Structure'),
(11, 2, 'Email Partners'),
(12, 3, 'Approve Commissions'),
(13, 3, 'Recurring Commissions'),
(14, 3, 'Create a Commission'),
(15, 3, 'Pay Affiliates'),
(16, 4, 'Products'),
(17, 4, 'Banners'),
(18, 4, 'Text Ads'),
(19, 4, 'Custom Links'),
(20, 5, 'Current Commissions'),
(21, 5, 'Traffic Summary'),
(22, 5, 'Traffic Logs'),
(23, 5, 'Accounting History'),
(24, 5, 'Marketing Statistics'),
(25, 5, 'Commission Statistics');

DROP TABLE IF EXISTS `{prefix}emails`;
CREATE TABLE `{prefix}emails` (
  `id` int(3) NOT NULL auto_increment,
  `key` varchar(255) NOT NULL default '',
  `name` varchar(30) NOT NULL default '',
  `group` enum('admin','affiliate','general') NOT NULL default 'admin',
  `description` varchar(150) NOT NULL default '',
  `subject` varchar(150) NOT NULL default '',
  `body` text NOT NULL,
  `footer` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

INSERT INTO `{prefix}emails` (`id`, `key`, `name`, `group`, `description`, `subject`, `body`, `footer`) VALUES (1, 'admin_new_account', 'New Account', 'admin', 'Sent When New Account Is Created', 'New Affiliate On {your_sitename}', 'Dear Sir/Madam,\r\n\r\nYou have a new affiliate on your {your_sitename}.  If you chose to approve new accounts, you will need to login to your admin'' center and either approve or decline this account.\r\n\r\nUsername: {affiliate_username}\r\n', '-----------------------------------------\r\nAuto Message Sent By eLitius'),
(2, 'afiliate_account_approved', 'Account Approved', 'affiliate', 'Sent When Account Has Been Approved', '{your_sitename} Account Approved', 'Dear {full_username},\r\n\r\nWe have approved your account!  You can now login and get your banner linking code, check stats, etc.\r\n', 'Sincerely,\r\n\r\nAffiliates Manager\r\n{your_sitename}\r\n{your_sitename_link}'),
(3, 'admin_new_sale', 'New Sale', 'admin', 'Sent When You Have New Affiliate Sale', 'New Affiliate Sale', 'Dear Sir/Madam,\r\n\r\nYou have a new affiliate sale on your site.  If you chose to approve sales, you will need to login to your admin panel and either approve or decline this sale.\r\n', '-----------------------------------------\r\nAutomatic Message Sent By eLitius'),
(4, 'admin_performance_reward', 'Performance Reward', 'admin', 'Sent When Performance Reward Issues', 'Performance Reward Issued', 'Dear Sir/Madam,\r\n\r\neLitius has automatically increase the payout level of an affiliate.\r\n', '-----------------------------------------\r\nAutomatic Message Sent By eLitius'),
(5, 'affiliate_new_account_signup', 'New Account Signup', 'affiliate', 'Sent When New Member Is Registered', 'Welcome To The {your_sitename}', 'Dear {full_username},\r\n\r\nWelcome to the {your_sitename} affiliate program.  Once we have approved your account, you can login and retrieve your banner linking code, check your sales and traffic stats and much more.\r\n\r\nUsername: {affiliate_username}\r\nPassword: {affiliate_password}\r\n\r\n', 'Sincerely,\r\n\r\nAffiliates Manager\r\n{your_sitename}\r\n{your_sitename_link}'),
(6, 'affiliate_account_declined', 'Account Declined', 'affiliate', 'Sent When An Account Declined', '{your_sitename} Affiliate Decline Notice', 'Dear {full_username},\r\n\r\nWe''re sorry to inform you that we have decided not to approve your affiliate account at this time.  If you''d like more information, please respond to this email and we''d be happy to explain our decision in more details.\r\n', 'Sincerely,\r\n\r\nAffiliates Manager\r\n{your_sitename}\r\n{your_sitename_link}'),
(7, 'affiliate_new_approved_sale_generated', 'New Approved Sale Generated', 'affiliate', 'Sent When New Sale Generated', 'New Sale Notification - {your_sitename}', 'Dear {full_username},\r\n\r\nCongratulations!  You''ve generated a sale on the {your_sitename} affiliate program.  Be sure to login to your account and check your accounting history and current stats.\r\n', 'Sincerely,\r\n\r\nAffiliates Manager\r\n{your_sitename}\r\n{your_sitename_link}'),
(8, 'affiliate_commission_payment', 'Commission Payment', 'affiliate', 'Sent When A Payment Is Made', 'Payment Notification - {your_sitename}', 'Dear {full_username},\r\n\r\nWe have sent your commission check for this month.  Be sure to login and check your financial history as well as other important stats.  We hope to continue building a strong partnership with you!\r\n\r\nCommission Amount: {commission_amount}\r\n', 'Sincerely,\r\n\r\nAffiliates Manager\r\n{your_sitename}\r\n{your_sitename_link}'),
(9, 'general_default_footer2Affiliates', 'Default Footer To Affiliates', 'general', '', '', '', 'Sincerely,\r\n\r\nAffiliates Manager\r\n{your_sitename}\r\n{your_sitename_link}'),
(10, 'affiliate_performance_reward', 'Performance Reward', 'affiliate', 'Sent When An Affiliate Is Rewarded', 'Payout Level Increase From {your_sitename}', 'We have automatically increased your payout level!  Thanks for your continued participation in our affiliate program.\r\n', 'Sincerely,\r\n\r\nAffiliates Manager\r\n{your_sitename}\r\n{your_sitename_link}');

DROP TABLE IF EXISTS `{prefix}language`;
CREATE TABLE `{prefix}language` (
  `id` int(8) NOT NULL auto_increment,
  `key` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  `lang` varchar(50) NOT NULL default 'English',
  `category` enum('admin','frontend','common','notifs','errors') NOT NULL default 'admin',
  PRIMARY KEY  (`id`),
  KEY `lang` (`lang`,`key`)
) TYPE=MyISAM;

INSERT INTO `{prefix}language` (`id` ,`key` ,`value` ,`lang` ,`category`) VALUES ( NULL , 'join_aff', 'join Affiliate Program', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'control_panel', 'Control Panel', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'unwriteable', 'Unwriteable', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'writeable', 'Writeable', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'manage_general_settings', 'Manage General Settings', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_config_cannot_be_writing', 'Config file cannot be opened for writing!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_configuration_saved', 'Configuration saved', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'general_templates', 'General Templates', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'affiliate_emails', 'Affiliate Emails', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'template_description', 'Description', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'admin_emails', 'Admin Emails', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'manage_email_templates', 'Manage Email Templates', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'banner_image', 'Banner Image', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'yes', 'Yes', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'no', 'No', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'show_banner', 'Show Banner', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'select_image', 'Select Image', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'banner_URL', 'Banner URL', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'details', 'Details', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'pls_select_image', 'Please select an image', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'must_provide_banner_name', 'You must provide a banner name.', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'cancel', 'Cancel', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'upload', 'Upload', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'path_add_banner', 'add-new-banner', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'path_edit_banner', 'edit-banner ', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'manage_banners_path', 'manage-banners', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'disapprove_affiliate', 'Disapprove Affiliate', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'disapproval_accounts', 'Disapproval Accounts', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'usage_recommendations_text', 'You should backup these files as often as possible.  Once a day would be ideal.  Should you lose your database, just import the contents of the backup file into phpMyAdmin (described above).  To be on the really safe side, you should also store these backup files offline in case you lose your entire server as well as your database.', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'usage_recommendations', 'Usage &amp; Recommendations', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'backups_info', '<ol>\r\n						<li>All current tables will be removed then recreated using the most current structure.</li>\r\n						<li>All fields within each table will be recreated.</li>\r\n						<li>All data within each field will be re-inserted.</li>\r\n					</ol>', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'what_happens_when_this', 'What Happens When I Do This?', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'create_backup', 'Create Backup', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'about_database_backups', 'About Database Backups', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'how_use_backup', 'How Do I Use These Backups?', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'backup_text_info', 'The content created in this backup file allows you to easily cut and paste directly in your PHP admin software (ie. phpMyAdmin).  In phpMyAdmin, click on your database then click on the SQL link at the top of the page.  Just paste the contents of your backup file into the box and click the ''Go'' button.', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'show2screen', 'Show on the screen', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'save2your_PC', 'Save to your PC', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'backup_structure_and_data', 'Backup structure and data', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'backup_data_only', 'Backup data only', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'backup_structure_only', 'Backup structure only', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'choose_operation', 'Choose Operation', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'backup_MySQL_database', 'Backup MySQL Database', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'backup', 'Backup', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'manage_database_backups', 'Manage Database Backups', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'total', 'Total', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'non_approved', 'Non-Approved', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'important_note_text', 'All sales entered on this page will need approved.  After you enter the sale, click on Approve Sales.You will see your new sale listed.', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'important_note', 'Important Note', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'order_number_transaction', 'Order Number (Transaction ID)', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'affiliate', 'Affiliate', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'account_details', 'Account Details', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'click_here_to_edit', 'Click Here to Edit', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'months_name', '|Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_pls_correct_fields', 'Please correct the following fields', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_sale_success_added', 'New sale was successfully added.', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'create_commission_admin', 'Create Commission', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'info_payout_percentage', '<p>Pay-Per-Sale (Percentage Payouts)</p>\r\n					<p>If you''re going to offer multiple payout levels, we recommend increasing the payout amount for each level.  This allows you to reward your higher producing affiliates with increased commissions.</p>\r\n					<ul style="list-style-type: none;">\r\n						<li>Sample Payout Levels</li>\r\n						<li>Level 1: 25% (default level)</li>\r\n						<li>Level 2: 40%</li>\r\n						<li>Level 3: 50%</li>\r\n					</ul>\r\n					 \r\n					<p>The criteria you choose to increment an affiliate level is completely up to you.  We recommend using a scale based on number of sales, total revenue, etc.  These are just ideas, it''s up to you to decide when and why an affiliate gets an increase.  Multiple levels are also useful for partnership agreements with other sites.  Example: You offer one site 30% and another site 35%.  Just set each account accordingly.</p>', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'additional_info', 'Additional Information', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'add', 'add', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'payout_percentage', 'Payout Percentage', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'payout_level', 'Payout Level', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'add_payout_level', 'Add Payout Level', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'level', 'Level', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'small_delete', 'delete', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'payout_amount', 'Payout Amount', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'pay_level', 'Pay Level', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'commissions_settings_percentage', 'Commission Settings for Pay-Per-Sale (Percentage)', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_new_payout_level_added', 'New payout level has been added!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_changes_success_saved', 'Changes were successfully saved!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_payout_level_deleted', 'Payout Level was successfully deleted!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'save', 'Save', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'manage_commission_settings', 'Manage Commission Settings', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'view_details', 'View Details', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'commission_amount', 'Commission Amount', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'order_number', 'Order Number', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'affiliate_name', 'Affiliate Name', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_commission_success', 'Commission(s) was(were) successfully ', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'status_declined', 'declined', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'decline', 'Decline', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'edit_banner', 'Edit Banner', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'approve_commissions', 'Approve Commissions', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_banners_success_modify', 'Banner was successfully modified!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_banner_success_deleted', 'Banner was successfully deleted!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_banner_success_added', 'New banner was successfully added!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_pls_select2delete', 'Please select the items to delete!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_cannot_edit_same_time', 'You cannot edit more than one item at the same time!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_pls_select2edit', 'Please select the items to edit!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'manage_banners', 'Manage Banners', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'full_details', 'full details', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'view', 'View', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'real_name', 'Real Name', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'approve_affiliate', 'Approve Affiliate', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'approval_accounts', 'Approval Accounts', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'primary_account', 'primary account', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'last_logged', 'Last Logged', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_new_admin_assigned', 'New primary administrator was successfully assigned!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_admin_success_deleted', 'Administrator was successfully deleted!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_select_admin2delete', 'Please select administrator to delete!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_select_admin2edit', 'Please select administrator to edit!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_cannot_admin_modify', 'Cannot modify more than one admin at the same time!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_admin_success_added', 'New administrator was successfully added!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'manage_administrators', 'Manage Administrators', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'edit', 'edit', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'status_approved', 'approved', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'status_pending', 'pending', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'status_disapproved', 'declined', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'hits', 'Hits', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'view_account_details', 'View Account Details', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_account_success_pending', 'Account was successfully pending!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_account_success_approved', 'Account was successfully approved!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_account_success_disapproved', 'Account was successfully disapproved!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_account_success_modify', 'Account details were successfully modified!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_account_success_delete', 'Account was successfully deleted!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_select_account2delete', 'Please select account to delete!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_select_account', 'Please select account to modify status!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_cannot_modify', 'Cannot modify more than one account at the same time!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_new_account_created', 'New account was successfully created!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'delete', 'Delete', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'pending', 'Pending', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'approve', 'Approve', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'create', 'Create', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'view_history', 'view history', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'process', 'Process', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'total_payments', 'Total Payments', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'average_payment', 'Average Payment', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'last_payment', 'Last Payment', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'view_accounting_history', 'View Accounting History', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'admin_welcome', 'Welcome to eLitius Admin Panel!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'earnings2date', 'Earnings to Date', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'total_transations', 'Total Transations', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'already_have_account', 'If you already have an account with us, please login at the <a href="login.php"><u>login page</u></a>', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'NOTE', 'NOTE', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'account_Info', 'My Account Information', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'history_clear', 'Your Payment History Is Clear (No payouts were made yet)', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'time', 'Time', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'date', 'Date', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'payment_id', 'Payment ID', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'create_one', 'Create one', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'no_account_yet', 'No account yet?', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'forgot_password', 'Forgot password?', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'warning_noscript', '!Warning! Javascript must be enabled for proper operation of the Administrator', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'login_message', '<p>Welcome to eLitius!</p>\r\n				<p>Use a valid username and password to gain access to the affiliate area.</p>', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'total_earnings', 'Total Earnings', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'total_sales', 'Total Sales', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'current_earnings', 'Current Earnings', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'sales_ratio', 'Sales Ratio', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'sales', 'Sales', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'unique_visitors', 'Unique Visitors', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'visits', 'Visits', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'traffic_stat', 'Traffic Statistics', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'earnings', 'Earnings', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_please_register', 'Please enter the email address you provided at registration', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'transactions', 'Transactions', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'password_recovery', 'Password Recovery', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'source_code', 'Source Code: click [Select ALL] button then copy selected text into your email', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'password_confirm', 'Password Confirmation', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'fax_number', 'Fax Number', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'username_not_allowed', 'username change not allowed', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'telephone_number', 'Telephone Number', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'frontend_country', 'Country', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'your_contact_Info', 'Your Contact Information', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'state_province', 'State/Province', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'frontend_city', 'City', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'zip_code', 'Zip Code/Post Code', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'street_address', 'Street Address', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'your_address', 'Your Address', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'website_url', 'Website URL', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'company_name', 'Company Name', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'company_details', 'Company Details', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'checks_payable', 'Checks Payable', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'tax_id', 'Tax ID/SSN/VAT', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'last_name', 'Last Name', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'first_name', 'First Name', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'required_info', 'Required information', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'personal_details', 'Your Personal Details', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'edit_account Info', 'Edit Account Information', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'continue', 'Continue', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'please_select', 'Please Select', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'enquiry', 'Enquiry', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'full_name', 'Full Name', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'email_address', 'E-Mail Address', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'small_view_details', 'view details', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'small_pending', 'pending', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'small_approved', 'approved', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'action', 'Action', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'sale_amount', 'Sale Amount', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'status', 'Status', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'approved', 'Approved', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'sale_date', 'Sale Date', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'pending_approval', 'Pending Approval', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'commissions', 'Commissions', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'banner_desc', 'Banner Description', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'banner_code', 'Banner Code (Copy and Paste to your website)', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'banner_size', 'Banner Size', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'select_all', 'Select ALL', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'banner_name', 'Banner Name', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'banner_details', 'Banner Details', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'logout_first', 'Logout first, please...', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'create_new_account', 'Create New Account', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_please_correct', 'Please correct %s field', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_your_account_modified', 'Your account details were successfully modified', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'aff_area', 'Affiliate Area', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'join_us', 'Join US!', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'site_title', 'eLitius Affiliate Program', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'email_links', 'Email Links', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'text_links', 'Text Links', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'edit_myaccount', 'Edit My Account', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'commission_details', 'Commission Details', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'payment_history', 'Payment History', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'affiliate_login', 'Affiliate Login', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'create_account', 'Create an account', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'my_account', 'My Account', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'general_statistics', 'General Statistics', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'contact_added', 'Thank you! Your enquiry was successfully sent!', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_username_exists', 'Username already taken. Please input different username.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_username_empty', 'Please input correct username.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_reciprocal_domain', 'Please make sure you use a backlink from your domain.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_reciprocal_link', 'Please input correct reciprocal link.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_password_match', 'Password do not match.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_password_empty', 'Please input correct password.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_min_description', 'Your description length should be more than  symbols.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_comment', 'Make sure you entered valid comment.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_comment_author', 'Make sure you entered valid comment author.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_comment_email', 'Make sure you entered valid author email.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_max_comment', 'Your comment length should be less than  symbols.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_min_comment', 'Your comment length should be more than  symbols.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_no_editor_email', 'No editors registered with this email.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_root_category', 'You can not suggest in root category. Please choose an appropiate category and try again.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_suggest_logged', 'You should be logged in to suggest links.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_max_description', 'Your description length should be less than  symbols.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_url', 'Make sure you entered valid link URL.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_title', 'Make sure you entered valid link title.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_file_upload', 'Unknown error during file upload.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_link_present', 'Your link already exists in directory.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_email_incorrect', 'Make sure you entered valid email.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_sponsored', 'You should choose sponsored plan. Only sponsored links are accepted.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_description', 'Make sure you entered valid link description.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_contact_fullname', 'Please fill in full name.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_contact_body', 'Please fill in contact reason.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_category_exists', 'Category was already suggested before.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_category_empty', 'Please go into appropriate category and become editor there.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_captcha', 'Your confirmation code is incorrect.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'category_locked', 'You can not add links in this category.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_already_voted', 'You already voted. Please try later.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_banned', 'Link was banned. Please do not try to add it again.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'error_broken_link', 'Link seems to be broken. Please check it manually.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'detailed_description', 'Detailed Description', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'url', 'Link URL', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'title', 'Link title', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'description', 'Link description', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'email', 'Email', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'reciprocal', 'Reciprocal URL', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'welcome', 'Welcome', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'your_link_title', 'Link title', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'your_link_description', 'Link description', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'your_link_reciprocal', 'Link reciprocal URL', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'your_password', 'Your password', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'your_username', 'Your username', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'your_username_here', 'Your username here:', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'your_link_url', 'Link URL', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'your_link_category', 'Link category', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'your_email', 'Email', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'view_my_categories', 'Categories To Edit', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'view_my_links', 'View My Links', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'view_link', 'View Link', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'total_num_links', 'Total number of links:', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'total_num_categories', 'Total number of categories:', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'top_links', 'Top Links', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'thank_text', 'to get back to index page', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'title_incorrect', 'Make sure you entered valid <b>link title</b>.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'title_empty', 'Title is empty!', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'username_empty', 'Make sure you entered valid username.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'username', 'Username', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'url_incorrect', 'Make sure you entered valid <b>link URL</b>.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'url_empty', 'url is empty!', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'register_editor', 'Register Editor', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'register', 'Register', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'reciprocal_empty', 'Reciprocal link is empty!', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'posted', 'posted on ', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'popular_links', 'Popular Links', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'password_incorrect', 'You entered incorrect password.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'password_empty', 'You have not entered a new password.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'passwords_dont_match', 'Passwords you entered do not match.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'password_changed', 'Password has been successfully changed.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'password', 'Password', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'pagerank', 'Pagerank', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'suggest_link_top1', 'You are going to suggest your link to the following category:', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'suggest_link_top2', 'Please make sure your link fits this category.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'suggest_link', 'Suggest Link', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'suggest_category_top1', 'You are going to suggest category here:', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'suggest_category', 'Suggest Category', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'sponsored_plans', 'Sponsored Plans', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'sponsored_links', 'Sponsored', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'statistics', 'Statistics', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'search', 'Search', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'related_categories', 'Related Categories', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'previous', 'Previous', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'partner_links', 'Partner Links', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'page', 'Page', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'no_approval_links', 'No links waiting for approval in your categories', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'not_available', 'Not available', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'not_found_links', 'No links found. Please try to broaden your search criterias!', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'non_sponsored', 'Non sponsored link', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'no_results', 'No results', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'next', 'Next', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'no_backlink', 'No reciprocal link', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'neighbour_categories', 'Neighbour Categories', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'new_password2', 'New Password[confirm]', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'new_password', 'New Password', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'new_links', 'New Links', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'my_links', 'My Links', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'my_categories', 'My Categories', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'logged_out', 'You have been logged out.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'logout', 'Logout', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'login', 'Login', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'links_found', 'Links Found: ', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'links', 'Links', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'link_submitted', 'Thank you! Your link was submitted for consideration', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'link_status', 'Link Status', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'link_rank', 'Link Rank', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'link_present', 'Your link already exists in directory', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'link_details', 'Link Details', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'link_changed', 'Link changed', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'link_added', 'Link added', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'leave_comment', 'Leave Comment', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'last', 'Last', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'home', 'Home', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'help_content', 'Here you should place short or long help.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'help', 'Help', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'first', 'First', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'featured_links', 'Featured Links', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'exact_match', 'exact match', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'email_incorrect', 'Make sure you entered valid <b>email</b>.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'editors_area', 'Editors Area', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'editor_username_exists', 'Username already taken.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'editor_login', 'Editor Login', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'editor_no_links', 'You have not submitted any links. Please choose correct category and make sure it fits your link best. Then click SUGGEST LINK, input requested information and submit it. <br /> Usually it takes about 24 hours for a link to be reviewed by administrator.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'editor_links', 'My Links', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'editorpsw_incorrect', 'Please fill in password', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'editor_incorrect', 'Please fill in username', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'editor_email_exists', 'Account with this email already exists!', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'edit_link', 'Edit Link', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'edit_account', 'Edit Account', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'directory_home', 'Directory Home', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'description_incorrect', 'Make sure you entered valid <b>link description</b>.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'description_empty', 'Description is empty!', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'current_password', 'Current Password', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'contact_us', 'Contact Us', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'company_terms', 'Terms Of Service', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'company_policy', 'Company Policy', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'company_jobs', 'Company Jobs', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'comment_empty', 'You have not input comments.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'company_info', 'Company Info', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'comments', 'Comments', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'comment_added', 'Comment added.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'category_empty', 'Please go into appropriate category and become editor there.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'click_here', 'Click here', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'clicks', 'Clicks', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'change_password', 'Change Password', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'category_exists', 'Category was already suggested before.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'category_submitted', 'Category was submitted for consideration!', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'category', 'Category', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'category_title', 'Category title', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'categories', 'Categories', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'broken_link', 'Link is broken', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'approval_links', 'Waiting Approval', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'all_words', 'all words', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'any_word', 'any word', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'advertise_with_us', 'Advertise with Us', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'advanced_search', 'Advanced Search', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'account_created', 'Account created! Thank you!', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'disapprove', 'Decline', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'disapprove_accounts', 'Disapprove Accounts', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'marketing', 'Marketing', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'install_not_removed', 'Folder install not removed! Please remove it.', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'sales_commission', 'Sales &amp; Commission', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'manage_accounts', 'Manage Accounts', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'global_configuration', 'Configuration', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'accounting_history', 'Accounting History', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'traffic_logs', 'Traffic Logs', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'traffic_summary', 'Traffic Summary', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'current_commissions', 'Current Commissions', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'text_ads', 'Text Ads', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'banners', 'Banners', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'pay_affiliates', 'Pay Affiliates', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'create_commission', 'Create A Commission', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'approval_commissions', 'Approval Commissions', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'mass_mail', 'Mass Mail', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'approve_accounts', 'Approve Accounts', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'admin_manager', 'Admin Manager', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'account_manager', 'Account Manager', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'database_backup', 'Database Backup', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'commission_settings', 'Commission Settings', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'email_templates', 'Email Templates', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'general_settings', 'General Settings', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'site_configuration', 'Site Configuration', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'expand_all', 'expand all', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'collapse_all', 'collapse all', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'admin_panel', 'Admin panel', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'home', 'Home', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'site_home', 'home', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'logout', 'logout', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'global_configuration', 'Site Configuration', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'global_configuration_manage', 'Global Configuration Management', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'manage_admins', 'Manage Admins', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'accounts', 'Accounts', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'sales_commission_management', 'Sales &amp; Commission Management', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'products_marketing', 'Products Marketing', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'reports_statistics', 'Reports &amp; Statistics', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'date_today', 'Today', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'pending_approval_accounts', 'Pending Approval Accounts', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'pending_approval_commissions', 'Pending Approval Commissions', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'last_days_commission', 'Last 30 days commission activity', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'last_days_traffic', 'Last 30 days incoming traffic activity', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_incorrect_username_password', 'Incorrect Username and Password, please try again', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'administration', 'Administration', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'welcome_admin_info', '<p>Welcome to eLitius!</p>\r\n<p>Use a valid username and password to gain access to the administration console.</p>', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, '2go_admin_panel', ' to go to admin panel login page.', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'manage_affiliate_account', 'Manage Affiliate Account', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'add_affiliate', 'Add Affiliate', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'account_status', 'Account Status', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'approval', 'Approval', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'affiliate_personal_details', 'Affiliate Personal Details', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'address', 'Address', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'contact_Info', 'Contact Information', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'phone', 'Phone', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'fax', 'Fax', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'account_statistics', 'Account Statistics', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'manage_ads', 'Manage Ads', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'edit_ad', 'Edit Ad', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'add_new', 'Add New', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'ad_provide_title', 'You must provide a ad title.', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'ad_provide_content', 'You must provide ad content.', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'ad_title', 'Ad Title', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'ad_content', 'Ad Content', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'show_ad', 'Show Ad', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'text_ad_review', 'Text Ad Preview', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'manage_admin', 'Manage Admin', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'administrator', 'Administrator', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_admin_success_modified', 'Administrator was successfully modified!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'admin_account_details', 'Administrator Account Details', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'manage_commission', 'Manage Commission', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'commission_status', 'Commission Status', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_pls_go_back', 'Please go back and select a commission to approve/decline', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'commission_status_approval', 'Commission Status: APPROVAL', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'affiliate_username', 'Affiliate Username', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'order_date', 'Order Date', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'order_time', 'Order Time', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'sale_total', 'Sale Total', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'manage_payment', 'Manage Payment', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'payment_success_archived', 'Payment was successfully archived.', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'archive_payment', 'Archive Payment', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'affiliate_info', 'Affiliate Information', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'federal_tax', 'Federal Tax ID/SSN', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'billing_address', 'Billing Address (Checks are payable to)', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'commission', 'Commission', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'number_sales', 'Number of Sales', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'sales_this_payment', 'Sales In This Payment', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'earned_commission', 'Earned Commission', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'pay_using_PayPal', 'Pay Using PayPal', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'PayPal_payment_not_available', 'PayPal Payment Not Available', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'manage_template', 'Manage Template', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'edit_email_template', 'Edit Email Template', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_email_emplate_success_saved', 'Email Template has been successfully saved!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'subject', 'Subject', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'message_body', 'Message Body', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'footer', 'Footer', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'mass_mailer', 'Mass Mailer', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'email_affiliates', 'Email Affiliates', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'send', 'Send', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'send_to', 'Send To', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'all_affiliates', 'All Affiliates', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'only_approved_affiliates', 'Only Approved Affiliates', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'only_non_approved_affiliates', 'Only Non-Approved Affiliates', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'only_pending_affiliates', 'Only Pending Affiliates', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'message', 'Message', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'balance', 'Balance', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'sale_details', 'Sale Details', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'account', 'Account', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'affiliate_email', 'Affiliate Email', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'payment_provider', 'Payment Provider', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'manage_website_configuration', 'Manage Website Configuration', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_pls_choose2edit', 'Please choose the item to edit!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_pls_select_item2edit', 'Please select the item to delete!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_text_ad_success_deleted', 'Text ad was successfully deleted!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_new_text_ad_success_added', 'New text ad was successfully added!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_text_ad_success_edited', 'Text ad was successfully edited!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'ad_text', 'Ad Text', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'ad_visibility', 'Ad Visibility', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'filter_accounts', 'Filter Accounts', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'all_accounts', 'All Accounts', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'incoming_IP_address', 'Incoming IP Address', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'referring_URL', 'Referring URL', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'traffic_log', 'Traffic Log', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'visitors', 'Visitors', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_error_incorrect_file_type', 'Error! Incorrect file type.', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_file_success_uploaded', 'File was successfully uploaded.', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_file_uploaded_successfully', 'File wasn''t uploaded successfully!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'add_new_banner', 'Add New Banner', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'file_upload', 'File Upload', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'max_size', 'Max size', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'ACTIVE', 'ACTIVE', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'APPROVAL_', 'APPROVAL', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'BANNED', 'BANNED', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'view_affiliate_account', 'View Affiliate Account', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_cannot_modify_account_go_back', 'Cannot modify more than one account at the same time. Please go back and select an account to modify.', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_pls_go_back_account2edit', 'Please go back and select an account to edit.', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_affiliate_success_deleted', 'Affiliate(s) was(were) successfully deleted.', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'current_sales_SUM', 'Current Sales (SUM)', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'view_payment_history', 'View Payment History', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'amount', 'Amount', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'total_amount', 'Total Amount', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'hints', 'Hints', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'here_will be_some_hints', 'here will be some hints', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_mass_mail_sent', 'Emails were successfully sent. %d email messages were sent.<br /><a href="mass-mail.php">Create new broadcast message.</a>', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_account_pending_approval', '<div style="background:#FFDDCC; padding: 4px; border: 1px dashed #a6a6a6;">Your account is pending approval.<br />Once your account approved you will be granted access to all the necessary tools to start your campaign</div>', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'msh_incorrect_param', 'Error! Incorrect parameter.', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'return_go_back', 'Go Back', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'back2page', 'Back to Page - ', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'user', 'user', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'cancel', 'Cancel', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'save2server', 'Save to Server', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'default_level', 'Default Level', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_accounts_success_delete', 'Accounts were successfully deleted!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_accounts_success_modify', 'Accounts details were successfully modified!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_accounts_success_disapproved', 'Accounts were successfully disapproved!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_accounts_success_approved', 'Accounts were successfully approved!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_accounts_success_pending', 'Accounts were successfully pending!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_admins_success_deleted', 'Administrators were successfully deleted!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_banners_success_deleted', 'Banners were successfully deleted!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_text_ads_success_deleted', 'Text ads were successfully deleted!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'reg_mail_from', 'eLitius Support', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'language_manager', 'Language Manager', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'edit_translate', 'Edit / Translate {language} phrases', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'language', 'Language', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'default', 'Default', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'download', 'download', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'set_default', 'Set Default', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'search_in_phrases', 'Search in Phrases', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'add_phrase', 'Add Phrase', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'download_upload', 'Download/''Upload', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'phrase_group', 'Phrase Group', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'all_groups', 'All Groups', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'display', 'Display', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'reset', 'Reset', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'phrase_manager', 'Phrase Manager', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'key', 'Key', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'value', 'Value', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'phrase_var', 'Phrase Variable Name', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'phrase_text', 'Phrase Text', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'search_in', 'Search in', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'phrase_text_var', 'Phrase Text and Phrase Variable Name', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'incorrect_key', 'Please enter the value of the key.', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'incorrect_value', 'Please enter the value of the key.', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'key_not_valid', 'Key is not valid only alphanumeric and underscore characters allowed.', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'key_exists', 'The phrase with similar key already exists.', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'deleted', 'Deleted', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'lang_incorrect', 'Please choose correct language.', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'filename', 'Filename', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'import', 'Import', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'import_from_pc', 'Import the language file from PC', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'import_from_server', 'Import the language file from your server', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'cant_open_sql', 'Could not open file with sql instructions: {filename}.sql.', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'changes_saved', 'Changes saved.', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'last2send', 'Last To Send Visitor Gets Credits', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'first2send', 'First To Send Visitor Gets Credits', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'site_product', 'Manage Product', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'product_name', 'Product Name', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'percentage', 'Percentage', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_products_deleted', 'Products were successfully deleted!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_product_deleted', 'Product was successfully deleted!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_products_modified', 'Products details were successfully modified!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_product_modified', 'Product details were successfully modified!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'msg_product_success_added', 'New Product was successfully added!', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'visitor_id', 'Visitor Id', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'products', 'Products', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'product_description', 'Product Description', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'desc_index', 'eLitius Affiliate Management Software', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'desc_forgot', 'forgot password', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'desc_account', 'my account', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'desc_ad_details', 'ad details', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'desc_banner_details', 'banner details', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'desc_banners', 'manage banners', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'desc_commission_details', 'view commission details', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'desc_contact', 'contact us', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'desc_email_links', 'manage email links', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'desc_login', 'login to your account', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'desc_logout', 'logout', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'desc_payments', 'manage payments', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'desc_register', 'create new account', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'desc_statistics', 'view statistics', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'desc_text_ads', 'manage text ads', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'desc_text_links', 'manage html links', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'desc_edit_account', 'edit account', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'keyword_index', 'affiliate tracking software, affiliate software', 'English', 'common');
INSERT INTO `{prefix}language` VALUES (NULL, 'keyword_forgot', 'forgot password eLitius', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'keyword_account', 'my eLitius account', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'keyword_ad_details', 'text ad details', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'keyword_banner_details', 'banner details', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'keyword_banners', 'manage banners', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'keyword_commission_details', 'view commission details', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'keyword_contact', 'contact us', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'keyword_email_links', 'manage email links', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'keyword_login', 'login to your account', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'keyword_logout', 'logout ', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'keyword_payments', 'manage payments', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'keyword_register', 'create new account', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'keyword_statistics', 'view statistics', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'keyword_text_ads', 'manage text ads', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'keyword_text_links', 'manage html links', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'keyword_edit_account', 'edit account', 'English', 'frontend');
INSERT INTO `{prefix}language` VALUES (NULL, 'auto_approve_product', 'Auto-approve Commissions', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'shopping_cart_integration', 'Integration Wizard', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'multi_tier_commissions', 'Manage Tiers', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'shopping_cart_integration_title', 'Shopping cart integration', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'shopping_cart_integration_desc', 'Manage shopping cart integration', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'paypal_integration_4', 'Please add the following code to <b>every</b> PayPal button form<BR><BR>', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'paypal_integration_5', 'That''s all you have to do for integration.', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'paypal_integration_3', 'It''s important whether you use PayPal buttons on your website or shopping cart working via PayPal!<br />In case you are using shopping cart working via PayPal please use the shopping cart integration method not this one!<br />We use PayPal IPN callback.<BR />', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'paypal_integration_2', 'Integration method', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'paypal_integration_1', 'To complete the eLitius installation you have to add some code to your website pages or change your payment gateway/shopping cart settings.<br /> The integration method depends on a specific payment gateway/shopping cart you use.', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, '2co_integration_1', 'Log-in to 2checkout supplier(vendor) panel, go to <B>Look and Feel</B> and put the following url to the <B>Affiliate URL</B> &lt;img src = field:<BR><BR>', 'English', 'admin');
INSERT INTO `{prefix}language` VALUES (NULL, 'tier_tree', 'Tier Tree', 'English', 'admin');


DROP TABLE IF EXISTS `{prefix}product`;
CREATE TABLE `{prefix}product` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `percentage` varchar(10) NOT NULL default '',
  `auto` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;



DROP TABLE IF EXISTS `{prefix}paylevels`;
CREATE TABLE `{prefix}paylevels` (
  `id` int(10) NOT NULL auto_increment,
  `level` int(10) NOT NULL default '0',
  `amt` decimal(10,2) NOT NULL default '0.00',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

INSERT INTO `{prefix}paylevels` (`id`, `level`, `amt`) VALUES (1, 1, 30.00),
(2, 2, 40.00),
(3, 3, 60.00);

DROP TABLE IF EXISTS `{prefix}payments`;
CREATE TABLE `{prefix}payments` (
  `id` int(100) NOT NULL auto_increment,
  `aff_id` int(10) NOT NULL default '0',
  `uid` int(10) NOT NULL default '0',
  `date` date NOT NULL default '0000-00-00',
  `time` time NOT NULL default '00:00:00',
  `sales` decimal(10,2) NOT NULL default '0.00',
  `commission` decimal(10,2) NOT NULL default '0.00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `{prefix}sales`;
CREATE TABLE `{prefix}sales` (
  `id` int(100) NOT NULL auto_increment,
  `aff_id` int(255) NOT NULL default '0',
  `date` date NOT NULL default '0000-00-00',
  `time` time NOT NULL default '00:00:00',
  `payment` decimal(10,2) NOT NULL default '0.00',
  `payout` decimal(10,2) NOT NULL default '0.00',
  `approved` enum('0','1','2') NOT NULL default '1',
  `ip` varchar(64) NOT NULL default '',
  `order_number` varchar(64) NOT NULL default '',
  `tracking` varchar(64) NOT NULL default '',
  `merchant` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `record` (`id`)
) TYPE=MyISAM;

CREATE TABLE IF NOT EXISTS `{prefix}tiertracking` (
  `id` int(11) NOT NULL default '0',
  `aff_id` int(11) NOT NULL default '0',
  `uid` varchar(64) NOT NULL default '',
  `referrer` varchar(128) NOT NULL default '',
  `date` date NOT NULL default '0000-00-00',
  `time` time NOT NULL default '00:00:00'
) TYPE=MyISAM;

DROP TABLE IF EXISTS `{prefix}tracking`;
CREATE TABLE `{prefix}tracking` (
  `id` int(255) NOT NULL auto_increment,
  `aff_id` int(255) NOT NULL default '0',
  `pid` int(11) NOT NULL default '0',
  `uid` varchar(64) NOT NULL default '',
  `referrer` varchar(128) NOT NULL default '',
  `date` date NOT NULL default '0000-00-00',
  `time` time NOT NULL default '00:00:00',
  PRIMARY KEY  (`id`),
  KEY `aff_id` (`aff_id`,`pid`,`uid`)
) TYPE=MyISAM;
