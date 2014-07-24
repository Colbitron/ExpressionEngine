<?php

$lang = array(

/**
 * Menu
 */

'communicate' =>
'Communicate',

'sent' =>
'Sent',

'cp_translation' =>
'<abbr title="Control Panel">CP</abbr> Translation',

'php_info' =>
'PHP Info',

'import_tools' =>
'Import Tools',

'file_converter' =>
'File Converter',

'member_import' =>
'Member Import',

'sql_manager' =>
'SQL Manager',

'query_form' =>
'Query Form',

'data_operations' =>
'Data Operations',

'cache_manager' =>
'Cache Manager',

'statistics' =>
'Statistics',

'search_and_replace' =>
'Search and Replace',

/**
 * Communicate
 */

'email_subject' =>
'e-mail Subject',

'email_body' =>
'e-mail Body',

'send_as' =>
'send as',

'word_wrap' =>
'word wrap',

'your_email' =>
'Your e-mail',

'from_email' =>
'From e-mail',

'attachment' =>
'Attachment',

'attachment_desc' =>
'Attachments are <b>not</b> saved, after sending.',

'recipient_options' =>
'Recipient Options',

'primary_recipients' =>
'Primary recipient(s)',

'primary_recipients_desc' =>
'To e-mail(s). Separate multiple recipients with a comma.',

'cc_recipients' =>
'<abbr title="Carbon Copied">CC</abbr> recipient(s)',

'cc_recipients_desc' =>
'<abbr title="Carbon Copied">CC</abbr> e-mail(s). Separate multiple recipients with a comma.',

'bcc_recipients' =>
'<abbr title="Blind Carbon Copied">BCC</abbr> recipient(s)',

'bcc_recipients_desc' =>
'<abbr title="Blind Carbon Copied">BCC</abbr> e-mail(s). Separate multiple recipients with a comma.',

'mailing_lists' =>
'Mailing list(s)',

'mailing_lists_desc' =>
'Send e-mail to <b>all</b> members in chosen list(s).',

'add_member_groups' =>
'Add member group(s)',

'add_member_groups_desc' =>
'Send e-mail to <b>all</b> members in chosen group(s).',

'btn_send_email' =>
'Send e-mail',

'btn_send_email_working' =>
'Sending...',

'none'		=> 'Plain Text',
'auto_br'	=> 'Auto &lt;br /&gt;',
'xhtml'		=> 'XHTML',

/**
 * CP Translation
 */

'language_files'		=>	'Language Files',
'search_files_button'	=>	'Search Files',
'file_name'				=>	'File Name',
'export_download'		=>	'Export (Download)',
'cannot_access'			=>	'cannot be accessed',
'cannot_create_zip'		=>	'Cannot create a .zip file',
'no_files_selected'		=>	'No files were selected for export',
'invalid_path' 			=> 'The path you submitted is not valid:',
'file_saved'			=> 'The translation file has been saved to system/expressionengine/translations/',
'trans_file_not_writable'=> 'Translation file is not writeable.',
'translate_btn' 		=>	'Save Translations',
'translate_btn_working' =>	'Saving...',

/**
 * PHP Info
 */

'php_info_title' =>
'<abbr title="Preprocessor Hypertext Processor">PHP</abbr> %s Info',

/**
 * Cache Manager
 */

'caches_to_clear' =>
'Caches to clear',

'caches_to_clear_desc' =>
'All caches selected will be cleared.',

'templates' =>
'Templates',

'tags' =>
'Tags',

'database' =>
'Database',

'all' =>
'All',

'btn_clear_caches' =>
'Clear Caches',

'btn_clear_caches_working' =>
'Clearing...',

'caches_cleared' =>
'Caches cleared.',

'caches_cleared_error' =>
'You must select at least one cache type to clear.',

/**
 * Search and Replace
 */

'sandr' =>
'Data Search and Replace',

'sandr_warning' =>
'<p><b>Warning</b>: <b class="no">Advanced users only.</b> Please be very careful with using this feature.</p>
<p>Depending on the syntax used, this function can produce undesired results. Consult the user guide and backup your database.</p>',

'sandr_search_text' =>
'Search for this text',

'sandr_replace_text' =>
'Replace with this text',

'sandr_in' =>
'Search and replace in',

'sandr_in_desc' =>
'Select the field you want to run this search and replace on.',

'rows_replaced' =>
'Number of database records in which a replacement occurred: %s',

'current_password' =>
'Current password',

'sandr_password_desc' =>
'You <b>must</b> enter your password to search and replace.',

'site_preferences'		=> 'Site Preferences',
'channel_entry_title'	=> 'Channel Entry Titles',
'channel_fields'		=> 'Channel Fields',
'replace_in_templates'	=> 'In ALL Templates',
'template_groups'		=> 'Template Groups',
'choose_below'			=> '(Choose from the following)',

'btn_sandr' =>
'Search and Replace',

'btn_sandr_working' =>
'Replacing...',

/**
 * Import Converter
 */

'import_converter' =>
'Import File Converter',

'file_location' =>
'File location',

'file_location_desc' =>
'Path location of your <mark>delimited</mark> file.',

'delimiting_char' =>
'Delimiting character',

'delimiting_char_desc' =>
'Character used to delimit the above file.',

'comma_delimit' =>
'Comma',

'tab_delimit' =>
'Tab',

'pipe_delimit' =>
'Pipe',

'other_delimit' =>
'Other <i>Type character below</i>',

'enclosing_char' =>
'Enclosing character',

'enclosing_char_desc' =>
'Character that encloses your data.',

'import_convert_btn' =>
'Convert File',

'import_convert_btn_working' =>
'Converting...',

'assign_fields' =>
'Assign Fields',

'import_password_warning' =>
'<b>Warning</b>: If you don\'t map one of your data points to "Password", a random encrypted password will be assigned to each imported user. These users will need to reset their password via the "Forgot Password" link.',

'plain_text_passwords' =>
'Plain text passwords?',

'plain_text_passwords_desc' =>
'When set to <b>yes</b>, passwords will be imported in plain text.',

'btn_assign_fields' =>
'Assign Fields',

'btn_assign_fields_working' =>
'Saving...',

'duplicate_field_assignment' =>
'Duplicate field assignment: %x',

'duplicate_member_id' =>
'Duplicate Member ID: "%x"<br />It is recommended that you do not use a &lt;member_id&gt; tag and allow ExpressionEngine to auto-increment member_id',

'duplicate_screen_name' =>
'Duplicate screen_name: ',

'duplicate_username' =>
'Duplicate username: ',

'member_id_warning' =>
'WARNING: If you have &lt;member_id&gt; tags in your XML, existing members with the same member_id will be OVERWRITTEN!  Proceed with caution!',

'missing_email_field' =>
'You must assign a field to "email"',

'missing_screen_name_field' =>
'You must assign a field to "screen_name"',

'missing_username_field' =>
'You must assign a field to "username"',

'not_enough_fields' =>
'Not enough fields',

'not_enough_fields_desc' =>
'You must have at least 3 fields: username, screen_name, and email address',

'select' =>
'Select field',

'confirm_assignments' =>
'Confirm Assignments',

'plaintext_passwords' =>
'Passwords are plain text.',

'encrypted_passwords' =>
'Passwords are encrypted.',

'btn_create_file' =>
'Create [file]',

'btn_create_file_working' =>
'Creating...',

'xml_code' =>
'XML Code',

'btn_download_file' =>
'Download File',

'btn_copy_to_clipboard' =>
'Copy to Clipboard',

/**
 * Member Import
 */

'mbr_xml_file' =>
'<abbr title="Extensible Markup Language">XML</abbr> file location',

'mbr_xml_file_location' =>
'<abbr title="Unified Resource Locator">URL</abbr> location of your <abbr title="Extensible Markup Language"><mark>xml</mark></abbr> file.',

'mbr_import_default_options' =>
'Default Options',

'member_group' =>
'Member group',

'mbr_language' =>
'Language',

'mbr_timezone' =>
'Timezone',

'mbr_timezone_desc' =>
'Local timezone for any date and time displays.',

'mbr_datetime_fmt' =>
'Date &amp; time format',

'mbr_datetime_fmt_desc' =>
'Preferred date and time formats.<br><i>Used in the control panel only.</i>',

'mbr_create_custom_fields' =>
'Create custom fields?',

'mbr_create_custom_fields_desc' =>
'When set to <b>yes</b>, import will automatically create custom member fields for any data that does not match a default member field.',

'mbr_import_btn' =>
'Import Members',

'mbr_import_btn_working' =>
'Importing...',

'confirm_import' =>
'Confirm Import',

'confirm_import_warning' =>
'<p class="caution"><span title="excercise caution"></span> <b>Caution</b>: If your <abbr title="Extensible Markup Language">XML</abbr> file contains a tag named "<b>member_id</b>", stop.</p>
<p>Members in your database with matching <abbr title="Identifier">ID</abbr>s will be <b>overwritten</b> if you confirm this import.</p>',

'option' =>
'Option',

'value' =>
'Value',

'btn_confirm_import_working' =>
'Importing...',

'custom_fields' =>
'Custom Fields',

'map_custom_fields' =>
'Map Custom Fields',

'map_custom_fields_desc' =>
'Your <abbr title="Extensible Markup Language">XML</abbr> file has fields that don\'t map directly to our importer, please review and assign custom fields as needed.',

'field_name' =>
'Field Name',

'field_label' =>
'Field Label',

'field_required' =>
'Required?',

'field_public' =>
'Public?',

'field_registration' =>
'Registration?',

'btn_add_fields' =>
'Add Fields',

'btn_add_fields_working' =>
'Adding...',

'new_fields_success' =>
'The following custom member fields were successfully added:',

'import_success' =>
'Import was successful',

'file_read_error' =>
'Unable to read file',

'file_read_error_desc' =>
'The XML file was not able to be read, check that the file exists and has proper read permissions.',

'xml_parse_error' =>
'Unable to parse XML',

'xml_parse_error_desc' =>
'Check the XML file for any incorrect syntax.',

/**
 * SQL Query Form
 */

'sql_query_form' =>
'SQL Query Form',

'sql_query_form_abbr' =>
'<abbr title="Structured Query Language">SQL</abbr> Query Form',

'sql_query_abbr' =>
'<abbr title="Structured Query Language">SQL</abbr> Query',

'sql_warning' =>
'<p><b>Warning</b>: <b class="no">Advanced users only.</b> Please be very careful with using this feature.</p>
<p>Depending on the syntax used, this function can produce undesired results. Consult the user guide and backup your database.</p>',

'common_queries' =>
'Common queries',

'common_queries_desc' =>
'Some common queries you can run, to learn more about your database content.',

'sql_query_to_run' =>
'Query to run',

'enable_sql_errors' =>
'Enable My<abbr title="Structured Query Language">SQL</abbr> errors',

'sql_password_desc' =>
'You <b>must</b> enter your password to run queries.',

'query_btn' =>
'Run Query',

'query_btn_working' =>
'Running...',

'query_results' =>
'Query Results',

'total_results' =>
'Total Results',

'affected_rows' =>
'Affected Rows',

'sql_not_allowed' =>
'Query type not allowed',

'sql_not_allowed_desc' =>
'You cannot run FLUSH, REPLACE, GRANT, REVOKE, LOCK or UNLOCK queries.',

'search_table' =>
'search table',

'type_phrase' =>
'type phrase...',

/**
 * Statistics
 */

'manage_stats' =>
'Manage Statistics',

'source' =>
'Source',

'record_count' =>
'Record Count',

'members' =>
'Members',

'channel_titles' =>
'Channel Entries',

'sites' =>
'Sites',

'forums' =>
'Forums',

'forum_topics' =>
'Forum Topics',

'sync' =>
'Sync',

'sync_completed' =>
'Synchronization Completed',

''=>''
);

/* End of file tools_lang.php */
/* Location: ./system/expressionengine/language/english/tools_lang.php */
