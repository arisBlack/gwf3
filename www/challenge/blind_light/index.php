<?php
require_once 'settings.php';
require_once 'vuln.php';
if (isset($_GET['show']))
{
	header('Content-Type: text/plain');
	die(file_get_contents('vuln.php'));
}
chdir('../../');
define('GWF_PAGE_TITLE', 'Blinded by the light');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/blind_light/index.php', false);
}
$chall->showHeader();

if (Common::getGetString('reset') === 'me')
{
	blightReset();
	echo GWF_HTML::message(GWF_PAGE_TITLE, $chall->lang('msg_reset'));
}
elseif (isset($_POST['mybutton']))
{
	blightInit();
	$answer = Common::getPostString('thehash');
	$solution = blightGetHash();
	$attemp = blightAttemp();
	
	if (!strcasecmp($answer, $solution))
	{
		if ($attemp > (BLIGHT_ATTEMPS+1) )
		{
			echo GWF_HTML::error(GWF_PAGE_TITLE, $chall->lang('err_attempt', array($attemp, (BLIGHT_ATTEMPS+1))));
		}
		else
		{
			$chall->onChallengeSolved(GWF_Session::getUserID());
		}
		blightReset();
	}
	else
	{
		echo GWF_HTML::error(GWF_PAGE_TITLE, $chall->lang('err_wrong', array($attemp)));
	}
	
}
elseif (isset($_POST['inject']))
{
	blightInit();
	$password = Common::getPostString('injection');
	$success = blightVuln($password);
	$attemp = blightAttemp()+1;
	
	if ($success)
	{
		echo GWF_HTML::message(GWF_PAGE_TITLE, $chall->lang('msg_logged_in', array($attemp)));
	}
	else
	{
		echo GWF_HTML::error(GWF_PAGE_TITLE, $chall->lang('err_login', array($attemp)));
	}
	
	blightSetAttempt($attemp);
}

$url1 = 'index.php?show=source';
$url2 = 'index.php?highlight=christmas';
$url3 = 'index.php?reset=me';
$egg = '4970342d42344c5657636c3d763f68637461772f6d6f632e65627574756f792e7777772f2f3a70747468';
$egg = '<span style="color: #eee;">'.$egg.'</span>';
htmlTitleBox($chall->lang('title'), $chall->lang('info', array(BLIGHT_ATTEMPS, $url1, $url2, $url3, $egg)));
if (Common::getGetString('highlight') === 'christmas')
{
	echo GWF_Message::display('[php title=vuln.php]'.file_get_contents('challenge/blind_light/vuln.php').'[/php]');
}
?>
<div class="box box_c">
	<form method="post" action="index.php">
		<div><?php echo $chall->lang('th_injection'); ?>: <input name="injection" type="text" value="" /></div>
		<div><input name="inject" type="submit" value="<?php echo $chall->lang('btn_inject'); ?>" /></div>
	</form>
</div>

<div class="box box_c">
	<form method="post" action="index.php">
		<div><?php echo $chall->lang('th_thehash'); ?>: <input name="thehash" type="text" value="" /></div>
		<div><input name="mybutton" type="submit" value="<?php echo $chall->lang('btn_submit'); ?>" /></div>
	</form>
</div>
<?php
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
