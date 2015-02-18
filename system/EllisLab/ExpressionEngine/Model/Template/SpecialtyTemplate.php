<?php

namespace EllisLab\ExpressionEngine\Model\Template;

use EllisLab\ExpressionEngine\Service\Model\Model;

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2003 - 2014, EllisLab, Inc.
 * @license		http://ellislab.com/expressionengine/user-guide/license.html
 * @link		http://ellislab.com
 * @since		Version 3.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * ExpressionEngine Specialty Templates Model
 *
 * @package		ExpressionEngine
 * @subpackage	Template
 * @category	Model
 * @author		EllisLab Dev Team
 * @link		http://ellislab.com
 */
class SpecialtyTemplate extends Model {

	protected static $_primary_key = 'template_id';
	protected static $_table_name = 'specialty_templates';

	protected static $_relationships = array(
		'Site' => array(
			'type' => 'BelongsTo'
		),
		'LastAuthor' => array(
			'type'     => 'BelongsTo',
			'model'    => 'Member',
			'from_key' => 'last_author_id'
		),
	);

	protected $template_id;
	protected $site_id;
	protected $enable_template;
	protected $template_name;
	protected $data_title;
	protected $template_type;
	protected $template_subtype;
	protected $template_data;
	protected $template_notes;
	protected $edit_date;
	protected $last_author_id;

	/**
	 * A setter for the enable_template property
	 *
	 * @param str|bool $new_value Accept TRUE or 'y' for 'yes' or FALSE or 'n'
	 *   for 'no'
	 * @throws InvalidArgumentException if the provided argument is not a
	 *   boolean or is not 'y' or 'n'.
	 * @return void
	 */
	protected function set__enable_template($new_value)
	{
		if ($new_value === TRUE || $new_value == 'y')
		{
			$this->enable_template = 'y';
		}

		elseif ($new_value === FALSE || $new_value == 'n')
		{
			$this->enable_template = 'n';
		}

		else
		{
			throw new InvalidArgumentException('enable_template must be TRUE or "y", or FALSE or "n"');
		}
	}

	/**
	 * A getter for the enable_template property
	 *
	 * @return bool TRUE if this is the default; FALSE if not
	 */
	protected function get__enable_template()
	{
		return ($this->enable_template == 'y');
	}

	public function getAvailableVariables()
	{
		$vars = array(
			'admin_notify_reg'						=> array('name', 'username', 'email', 'site_name', 'control_panel_url'),
			'admin_notify_entry'					=> array('channel_name', 'entry_title', 'entry_url', 'comment_url', 'cp_edit_entry_url', 'name', 'email'),
			'admin_notify_comment'					=> array('channel_name', 'entry_title', 'entry_id', 'url_title', 'channel_id', 'comment_url_title_auto_path',  'comment_url', 'comment', 'comment_id', 'name', 'url', 'email', 'location', 'unwrap}{delete_link}{/unwrap', 'unwrap}{close_link}{/unwrap', 'unwrap}{approve_link}{/unwrap'),
			'admin_notify_forum_post'				=> array('name_of_poster', 'forum_name', 'title', 'body', 'thread_url', 'post_url'),
			'admin_notify_mailinglist'				=> array('email', 'mailing_list'),
			'mbr_activation_instructions'			=> array('name',  'username', 'email', 'activation_url', 'site_name', 'site_url'),
			'forgot_password_instructions'			=> array('name', 'reset_url', 'site_name', 'site_url'),
			'decline_member_validation'				=> array('name', 'site_name', 'site_url'),
			'validated_member_notify'				=> array('name', 'site_name', 'site_url'),
			'mailinglist_activation_instructions'	=> array('activation_url', 'site_name', 'site_url', 'mailing_list'),
			'comment_notification'					=> array('name_of_commenter', 'name_of_recipient', 'channel_name', 'entry_title', 'entry_id', 'url_title', 'channel_id', 'comment_url_title_auto_path', 'comment_url', 'comment', 'notification_removal_url', 'site_name', 'site_url', 'comment_id'),

			'comments_opened_notification'			=> array('name_of_recipient', 'channel_name', 'entry_title', 'entry_id', 'url_title', 'channel_id', 'comment_url_title_auto_path', 'comment_url', 'notification_removal_url', 'site_name', 'site_url', 'total_comments_added', 'comments', 'name_of_commenter', 'comment_id', 'comment', '/comments'),

			'forum_post_notification'				=> array('name_of_recipient', 'name_of_poster', 'forum_name', 'title', 'thread_url', 'body', 'post_url'),
			'private_message_notification'			=> array('sender_name', 'recipient_name','message_subject', 'message_content', 'site_url', 'site_name'),
			'pm_inbox_full'							=> array('sender_name', 'recipient_name', 'pm_storage_limit','site_url', 'site_name'),
			'forum_moderation_notification'			=> array('name_of_recipient', 'forum_name', 'moderation_action', 'title', 'thread_url'),
			'forum_report_notification'				=> array('forum_name', 'reporter_name', 'author', 'body', 'reasons', 'notes', 'post_url')
		);

		return (isset($vars[$this->template_name])) ? $vars[$this->template_name] : array();
	}

}