<?php
final class Harbor_Ship1 extends SR_Tower
{
	public function getAreaSize() { return 80; }
	public function getFoundPercentage() { return 80.0; }
	
// 	public function getFoundText(SR_Player $player) { return 'You found a ship called "Saint Marry". "Dumb name", you think by yourself.'; }
// 	public function getEnterText(SR_Player $player) { return 'You enter the "Saint Marry" ship ...'; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	
	public function onEnter(SR_Player $player)
	{
		$party = $player->getParty();
		
		$player->message($this->lang($player, 'no_enter'));
// 		$player->message('You cannot find any open entrance to the ship ... Yet.');
		
		return false;
	}
}
?>