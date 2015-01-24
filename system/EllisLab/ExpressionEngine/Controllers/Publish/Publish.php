<?php

namespace EllisLab\ExpressionEngine\Controllers\Publish;

use CP_Controller;
use EllisLab\ExpressionEngine\Library\CP\Pagination;
use EllisLab\ExpressionEngine\Library\CP\Table;
use EllisLab\ExpressionEngine\Library\CP\URL;

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2003 - 2015, EllisLab, Inc.
 * @license		http://ellislab.com/expressionengine/user-guide/license.html
 * @link		http://ellislab.com
 * @since		Version 3.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * ExpressionEngine CP Publish Class
 *
 * @package		ExpressionEngine
 * @subpackage	Control Panel
 * @category	Control Panel
 * @author		EllisLab Dev Team
 * @link		http://ellislab.com
 */
class Publish extends CP_Controller {

	protected $isAdmin = FALSE;
	protected $assignedChannelIds = array();

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();

		if ( ! ee()->cp->allowed_group('can_access_content'))
		{
			show_error(lang('unauthorized_access'));
		}

		ee()->lang->loadfile('content');

		$this->isAdmin = (ee()->session->userdata['group_id'] == 1);
		$this->assignedChannelIds = array_keys(ee()->session->userdata['assigned_channels']);
	}

	protected function createChannelFilter()
	{
		$allowed_channel_ids = ($this->isAdmin) ? NULL : $this->assignedChannelIds;
		$channels = ee('Model')->get('Channel', $allowed_channel_ids)
			->filter('site_id', ee()->config->item('site_id'))
			->all();

		$channel_filter_options = array();
		foreach ($channels as $channel)
		{
			$channel_filter_options[$channel->channel_id] = $channel->channel_title;
		}
		$channel_filter = ee('Filter')->make('filter_by_channel', 'filter_by_channel', $channel_filter_options);
		$channel_filter->disableCustomValue(); // This may have to go
		return $channel_filter;
	}

}
// EOF