<?php
final class Spell_firebolt extends SR_CombatSpell
{
	public function getSpellLevel() { return 1; }
	
	public function getHelp() { return 'Cast a firebolt against an enemy. Does some damage.'; }
	
	public function getRequirements() { return array('magic'=>2); }
	
	public function getCastTime($level) { return Common::clamp(30-$level, 20, 40); }
	
	public function getManaCost(SR_Player $player, $level)
	{
		return 2 + ($level*0.5);
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
//		echo "Casting Firebolt with level $level and $hits hits.\n";
		$min = 1.00 + $level*0.5;
		$max = $min + $level*1.2 + $hits*0.35;
		$damage = Shadowfunc::diceFloat($min, $max);
		return $this->spellDamageSingleTarget($player, $target, $level, '10040', $damage);
	}
}
?>