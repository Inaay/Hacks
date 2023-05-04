<?php

/**
*
*  ██ ███    ██  █████   █████  ██    ██  █████  ████████
*  ██ ████   ██ ██   ██ ██   ██  ██  ██  ██   ██    ██
*  ██ ██ ██  ██ ███████ ███████   ████   ███████    ██
*  ██ ██  ██ ██ ██   ██ ██   ██    ██    ██   ██    ██
*  ██ ██   ████ ██   ██ ██   ██    ██    ██   ██    ██
*
* @author Inaayat
* @link https://github.com/Inaay
*
*/

declare(strict_types=1);

namespace Inaayat\Hacks\task;

use Inaayat\Hacks\Main;
use pocketmine\entity\animation\ArmSwingAnimation;
use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\scheduler\Task;

class KillauraTask extends Task {

	private $plugin;

	public function __construct(Main $plugin){
		$this->plugin = $plugin;
	}

	/**
	 * @return void
	 */
	public function onRun(): void {
		foreach ($this->plugin->getServer()->getOnlinePlayers() as $player) {
			if ($this->plugin->hasKillaura($player)) {
				$range = $this->plugin->getKillauraRange($player);
				foreach ($player->getWorld()->getNearbyEntities($player->getBoundingBox()->expandedCopy($range, $range, $range)) as $entity) {
					if ($entity instanceof Entity && $entity !== $player && $entity->isAlive()) {
						$damage = $player->getInventory()->getItemInHand()->getAttackPoints();
						$event = new EntityDamageByEntityEvent($player, $entity, EntityDamageEvent::CAUSE_ENTITY_ATTACK, $damage);
						$player->broadcastAnimation(new ArmSwingAnimation($player));
						$entity->attack($event);
					}
				}
			}
		}
	}
}