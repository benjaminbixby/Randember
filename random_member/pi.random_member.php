<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * Randember Plugin
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Plugin
 * @author		Benjamin Bixby
 * @link		http://benjaminbixby.com
 */

$plugin_info = array(
	'pi_name'		=> 'Randember',
	'pi_version'	=> '1.0.2',
	'pi_author'		=> 'Benjamin Bixby',
	'pi_author_url'	=> 'http://benjaminbixby.com',
	'pi_description'=> 'Returns a random member.',
	'pi_usage'		=> Random_member::usage()
);


class Random_member {

	public $return_data;
    
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();

		$sql_where = "";

		$allmembers = array();

		$multiple = array();

		$group = $this->EE->TMPL->fetch_param('groupid');

		$multiple = explode("|", $group);

			$i = 0;
			$c = count($multiple);

		if ($group != "" && $multiple != "")
		{
			foreach ($multiple as $k => $v)
			{
				if ($i++ < $c - 1)
				{
					$sql_where .= $v." AND ";
				}
				else
				{
					$sql_where .= $v;
				}
			}
		}

		// Check to see if a group was specified
		if ($group != "" && $c >= 2)
		{
			// Set sql with multiple group_id selection
			$sql = "SELECT `member_id` FROM `exp_members` WHERE `group_id`=$sql_where";
		}
		else if ($group != "" && $c <= 1)
		{
			// Set sql with one group_id selection
			$sql = "SELECT `member_id` FROM `exp_members` WHERE `group_id`=$group";
		}
		else
		{
			// Set sql for all available members
			$sql = "SELECT `member_id` FROM `exp_members`";
		}
			
		// Run the query
		$query = $this->EE->db->query($sql);

		// Check for returned values
		if ($query->num_rows() > 0)
	    {
	    	foreach($query->result_array() as $row)
	    	{
	    		array_push($allmembers, $row['member_id']);
	    	}

	    	// Select one member_id randomly, aka NEO
			$the_chosen_one = $allmembers[array_rand($allmembers, 1)];
			
			// Return the member_id and replace the tag
			$tagdata = $this->EE->TMPL->tagdata;
			return $this->return_data = str_replace("{random_member}", $the_chosen_one, $tagdata);
		}
		else
		{
			// do nothing
		}

	}
	
	// ----------------------------------------------------------------
	
	/**
	 * Plugin Usage
	 */
	public static function usage()
	{
		ob_start();
?>

Returns a random member_id.  Make sure you use "parse=inward" to the plugin. Ex:

{exp:random_member parse="inward"} ... {random_member} ... {/exp:random_member}

You can also use it to select a random member based on a member group id (single group or multiple groups... use standard EE syntax and separate group numbers by using the pipe character i.e. "3|4". Ex:

{exp:random_member groupid="3|5" parse="inward"} ... {random_member} ... {/exp:random_member}

<?php
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
}


/* End of file pi.random_member.php */
/* Location: /system/expressionengine/third_party/random_member/pi.random_member.php */