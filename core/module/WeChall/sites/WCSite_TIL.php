<?php
/**
 * This Is Legal
#31:75:350:462:36 
#196:0:350:462:36 
 */
class WCSite_TIL extends WC_Site
{
	public function parseStats($url)
	{
		if (false === ($result = GWF_HTTP::getFromURL($url, false))) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}

		$stats = explode(":", $result);
		if (count($stats) !== 5) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		$rank = intval($stats[0]);
		$onsitescore = intval($stats[1]);
		$maxscore = intval($stats[2]);
		$usercount = intval($stats[3]);
		$challcount = intval($stats[4]);
		if ($maxscore === 0 || $challcount === 0 || $usercount === 0) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		return array($onsitescore, $rank, -1, $maxscore, $usercount, $challcount);
	}
}
?>