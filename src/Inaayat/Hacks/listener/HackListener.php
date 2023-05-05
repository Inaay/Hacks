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

namespace Inaayat\Hacks\listener;

use Inaayat\Hacks\Main;
use pocketmine\block\Block;
use pocketmine\block\inventory\ChestInventory;
use pocketmine\block\VanillaBlocks;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\inventory\InventoryOpenEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\AnimatePacket;
use pocketmine\player\Player;

class HackListener implements Listener {

	private $plugin;

	public function __construct(Main $plugin){
		$this->plugin = $plugin;
	}

	/**
	 * @param DataPacketReceiveEvent $event
	 * 
	 * @return void
	 */
	public function onPacketReceived(DataPacketReceiveEvent $event): void {
		$packet = $event->getPacket();
		$player = $event->getOrigin()->getPlayer();
		//hitbox
		if ($player instanceof Player && $this->plugin->hasHitbox($player)) {
			if ($packet instanceof AnimatePacket && $packet->action === AnimatePacket::ACTION_SWING_ARM) {
				foreach ($player->getWorld()->getEntities() as $target) {
					if ($target === $player) continue;
					$pos1 = $player->getEyePos();
					$pos2 = $target->getEyePos();
					$vector = $pos2->subtract($pos1->getX(), $pos1->getY(), $pos1->getZ());
					$distance = $vector->length();
					if ($distance <= $this->plugin->getHitboxRange($player)) {
						$damage = $player->getInventory()->getItemInHand()->getAttackPoints();
						$event = new EntityDamageByEntityEvent($player, $target, EntityDamageEvent::CAUSE_ENTITY_ATTACK, $damage);
						$target->attack($event);
					}
				}
			}
		}
		//reach
		if ($player instanceof Player && $this->plugin->hasReach($player)) {
			$reach = $this->plugin->getReachRange($player);
			if ($packet instanceof AnimatePacket && $packet->action === AnimatePacket::ACTION_SWING_ARM) {
				foreach ($player->getWorld()->getEntities() as $target) {
					if ($target === $player) continue;
					$pos1 = $player->getEyePos();
					$pos2 = $target->getEyePos();
					$vector = $pos2->subtract($pos1->getX(), $pos1->getY(), $pos1->getZ());
					$distance = $vector->length();
					if ($distance <= $reach) {
						$yaw = $player->getLocation()->getYaw();
						$pitch = $player->getLocation()->getPitch();
						// NOT THE BEST PS: Im bad at math. pull an open request | Idk why i didnt use raytrace
						$lx = -sin(deg2rad($yaw)) * cos(deg2rad($pitch));
						$ly = sin(deg2rad($pitch));
						$lz = cos(deg2rad($yaw)) * cos(deg2rad($pitch));
						$los = new Vector3($lx, $ly, $lz);
						if ($distance > 0 && $los->dot($vector) / $distance >= 0.99) {
							$damage = $player->getInventory()->getItemInHand()->getAttackPoints();
							$event = new EntityDamageByEntityEvent($player, $target, EntityDamageEvent::CAUSE_ENTITY_ATTACK, $damage);
							$target->attack($event);
						}
					}
				}
			}
		}
	}

	/**
	 * @param EntityDamageByEntityEvent $event
	 * 
	 * @return void
	 */
	public function onDamage(EntityDamageByEntityEvent $event): void {
		$entity = $event->getEntity();
		if (!($entity instanceof Player)) return;
		if (!$this->plugin->hasVelocity($entity)) return;
		$kbVertical = $this->plugin->getVelocityVertical($entity);
		$kbHorizontal = $this->plugin->getVelocityHorizontal($entity);
		if ($kbVertical == 4.0 && $kbHorizontal == 4.0) {
		} elseif ($kbVertical == 4.0) {
			$entity->setMotion($entity->getDirectionVector()->multiply($kbHorizontal)->add(0, $entity->getMotion()->y, 0));
		} elseif ($kbHorizontal == 4.0) {
			$entity->setMotion($entity->getDirectionVector()->multiply($event->getKnockBack())->add(0, $kbVertical, 0));
		} elseif ($kbVertical == 0 && $kbHorizontal == 0) {
			$event->setKnockBack(0);
		} else {
			$event->setKnockBack(sqrt($kbVertical * $kbVertical + $kbHorizontal * $kbHorizontal));
			$entity->setMotion($entity->getDirectionVector()->multiply($event->getKnockBack())->add(0, $kbVertical, 0));
		}
	}

	/**
	 * @param PlayerQuitEvent $event
	 * 
	 * @return void
	 */
	public function onQuit(PlayerQuitEvent $event): void {
		$player = $event->getPlayer();
		if ($player instanceof Player) {
			if ($this->plugin->hasHitbox($player)) {
				$this->plugin->disableHitbox($player);
			}
			if ($this->plugin->hasKillaura($player)) {
				$this->plugin->disableKillaura($player);
			}
			if ($this->plugin->hasSpeed($player)) {
				$this->plugin->disableSpeed($player);
			}
			if ($this->plugin->hasReach($player)) {
				$this->plugin->disableReach($player);
			}
			if ($this->plugin->hasVelocity($player)) {
				$this->plugin->disableVelocity($player);
			}
			if($this->plugin->hasNoFall($player)) {
				$this->plugin->disableNoFall($player);
			}
			if($this->plugin->hasChestStealer($player)) {
				$this->plugin->disableChestStealer($player);
			}
			if($this->plugin->hasScaffold($player)) {
				$this->plugin->disableScaffold($player);
			}
			if($this->plugin->hasNuker($player)) {
				$this->plugin->disableNuker($player);
			}
		}
	}

	/**
	 * @param EntityDamageEvent $event
	 * 
	 * @return void
	 */
	public function onEntityDamage(EntityDamageEvent $event): void {
		$entity = $event->getEntity();
		$cause = $event->getCause();
		if($cause == EntityDamageEvent::CAUSE_FALL){
			if (!($entity instanceof Player)) return;
			if (!$this->plugin->hasNoFall($entity)) return;
			$percentage = $this->plugin->getNoFallPercentage($entity);
			if($percentage >= 100 || mt_rand(1, 100) <= $percentage) {
				$event->cancel();
			}
		}
	}

	/**
	 * @param InventoryOpenEvent $event
	 * 
	 * @return void
	 */
	public function onInventoryOpen(InventoryOpenEvent $event): void {
        $player = $event->getPlayer();
        $inventory = $event->getInventory();
        if ($inventory instanceof ChestInventory) {
			if (!($player instanceof Player)) return;
			if (!$this->plugin->hasChestStealer($player)) return;
            foreach ($inventory->getContents() as $item) {
                if ($item !== null) {
                    $player->getInventory()->addItem($item);
                }
            }
            $inventory->clearAll();
        }
    }

	/**
	 * @param PlayerMoveEvent $event
	 * 
	 * @return void
	 */
	public function onPlayerMove(PlayerMoveEvent $event): void {
		$player = $event->getPlayer();
		if (!$player instanceof Player || !$this->plugin->hasScaffold($player)) return;
		$blockInHand = $player->getInventory()->getItemInHand()->getBlock();
		if (!$blockInHand instanceof Block) return;
		if ($blockInHand->getId() === VanillaBlocks::AIR()->getId()) return;
		$blockBelowPos = $player->getPosition()->floor()->subtract(0, 1, 0);
		if ($player->getWorld()->getBlock($blockBelowPos)->canBeReplaced()) {
			$player->getWorld()->setBlock($blockBelowPos, $blockInHand, true);
			$player->getInventory()->getItemInHand()->setCount($player->getInventory()->getItemInHand()->getCount() - 1);
		}
	}

	/**
	 * @param BlockBreakEvent $event
	 * 
	 * @return void
	 */
	public function onBlockBreak(BlockBreakEvent $event): void {
		$player = $event->getPlayer();
		if (!$player instanceof Player || !$this->plugin->hasNuker($player)) return;
		$radius = $this->plugin->getNukerRadius($player);
		$block = $event->getBlock();
		$world = $block->getPosition()->getWorld();
		$maxX = $block->getPosition()->getX() + $radius;
		$minX = $block->getPosition()->getX() - $radius;
		$maxY = $block->getPosition()->getY() + $radius;
		$minY = $block->getPosition()->getY() - $radius;
		$maxZ = $block->getPosition()->getZ() + $radius;
		$minZ = $block->getPosition()->getZ() - $radius;
		for ($x = $minX; $x <= $maxX; ++$x) {
			for ($z = $minZ; $z <= $maxZ; ++$z) {
				if (abs($x - $block->getPosition()->getX()) <= $radius &&
					abs($z - $block->getPosition()->getZ()) <= $radius) {
					for ($y = $minY; $y <= $maxY; ++$y) {
						$targetBlock = $world->getBlockAt($x, $y, $z);
						if ($targetBlock->getId() !== VanillaBlocks::AIR()->getId() &&
							abs($y - $block->getPosition()->getY()) <= $radius) {
							$world->useBreakOn($targetBlock->getPosition()->asVector3());
						}
					}
				}
			}
		}
	}
}