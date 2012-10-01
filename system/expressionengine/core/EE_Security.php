<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2003 - 2012, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * ExpressionEngine Core Security Class
 *
 * @package		ExpressionEngine
 * @subpackage	Core
 * @category	Core
 * @author		EllisLab Dev Team
 * @link		http://expressionengine.com
 */
class EE_Security extends CI_Security {

	// Small note, if you feel the urge to add a constructor,
	// do not call get_instance(). The CI Security library
	// is sometimes instantiated before the controller is loaded.
	// i.e. when turning CI's csrf_protection on. Which you shouldn't
	// do in EE anywho. -pk

	// --------------------------------------------------------------------

	/**
	 * Secure Forms Check
	 *
	 * @param 	string
	 * @return	bool
	 */
	public function secure_forms_check($xid)
	{	
		$check = $this->check_xid($xid);
		
		$this->delete_xid($xid);

		return $check;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Check for Valid Security Hash
	 *
	 * @param 	string
	 * @return	bool
	 */
	public function check_xid($xid)
	{
		$EE =& get_instance();
		
		if ($EE->config->item('secure_forms') != 'y')
		{
			return TRUE;
		}
		
		if ( ! $xid)
		{
			return FALSE;
		}

		$total = $EE->db->where('hash', $xid)
			->where('session_id', $EE->session->userdata('session_id'))
			->where('date > UNIX_TIMESTAMP()-7200')
			->from('security_hashes')
			->count_all_results();
		
		if ($total === 0)
		{
			return FALSE;
		}
		
		return TRUE;		
	}
	
	// --------------------------------------------------------------------

	/**
	 * Generate Security Hash
	 *
	 * @return String XID generated
	 */
	public function generate_xid($count = 1, $array = FALSE)
	{
		$EE =& get_instance();

		$hashes = array();
		$inserts = array();

		$query = "INSERT INTO exp_security_hashes (date, session_id, hash) VALUES ";
		
		while ($count > 0) {
			$hash = $EE->functions->random('encrypt');
			$inserts[] = "(UNIX_TIMESTAMP(), '".$EE->session->userdata('session_id')."', '".$hash."')";
			$hashes[] = $hash;
			$count--;
		};

		$EE->db->query($query.implode(',', $inserts));
		return (count($hashes) > 1 OR $array) ? $hashes : $hashes[0];
	}

	// --------------------------------------------------------------------

	/**
	 * Delete Security Hash
	 *
	 * @param 	string
	 * @return	void
	 */
	public function delete_xid($xid)
	{
		$EE =& get_instance();
		
		if ($EE->config->item('secure_forms') != 'y' OR $xid === FALSE)
		{
			return;
		}

		$EE->db->where('hash', $xid)
			->or_where('date < UNIX_TIMESTAMP()-7200')
			->delete('security_hashes');
		
		return;		
	}

	// --------------------------------------------------------------------

	/**
	 * Deletes out of date XIDs
	 */
	public function garbage_collect_xids()
	{
		$EE =& get_instance();
		$EE->db->where('date < UNIX_TIMESTAMP()-7200')
			->delete('security_hashes');
	}

}
// END CLASS

/* End of file EE_Security.php */
/* Location: ./system/expressionengine/libraries/EE_Security.php */
