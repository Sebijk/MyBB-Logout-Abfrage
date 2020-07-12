<?php
/**
* Logout Abfrage für MyBB
* Webseite: 
* http://www.mybbcoder.info / 
* http://www.sebijk.com
* Lizenz: GPL
**/

if( !defined('IN_MYBB') )
{
	die("Hacking attempt!");
}

/** Hooks einbinden **/
$plugins->add_hook("global_end", "logout_js");

/** Infos über Logout Abfrage **/
function logout_info()
{
	return array(
		"name"			=> "Logout Abfrage / Logout ask",
		"description"	=> "Fragt den Benutzer ob er sich wirklich abmelden möchte.",
		"website"		=> "http://www.sebijk.com",
		"author"		=> "Home of the Sebijk.com",
		"authorsite"	=> "http://www.sebijk.com",
		"version"		=> "1.5",
		"guid" 			=> "",
        "compatibility" => "18*" 
	);
}

function logout_activate()
{
	include MYBB_ROOT."/inc/adminfunctions_templates.php";
	find_replace_templatesets("header_welcomeblock_member", "#".preg_quote('action=logout&amp;logoutkey={$mybb->user[\'logoutkey\']}')."#i", 'action=logout&amp;logoutkey={$mybb->user[\'logoutkey\']}" onclick="return log_out()');
}

// This function runs when the plugin is deactivated.
function logout_deactivate()
{
	include MYBB_ROOT."/inc/adminfunctions_templates.php";
	find_replace_templatesets("header_welcomeblock_member", "#".preg_quote('action=logout&amp;logoutkey={$mybb->user[\'logoutkey\']}" onclick="return log_out()')."#i", 'action=logout&amp;logoutkey={$mybb->user[\'logoutkey\']}');
}

function logout_js() {
	global $lang, $headerinclude;
	$lang->load("asklogout");

	$headerinclude .= '<!-- start js code for logout -->
	<script type="text/javascript">
	<!--
	function log_out()
	{
		grayfilter = document.getElementsByTagName("html");
		grayfilter[0].style.filter = "progid:DXImageTransform.Microsoft.BasicImage(grayscale=1)";
		if (confirm(\''.$lang->confirm_logout.'\n'.$lang->confirm_logout_okcancel.'\'))
		{ 
		return true; 
		}
		else
		{
		grayfilter[0].style.filter = "";
		return false; 
		}
	}
	//-->
	</script>
	<!-- end js code for logout -->';
}
?>