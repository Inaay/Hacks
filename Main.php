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

namespace Inaayat\Hacks;

use Inaayat\Hacks\command\HackCommand;
use Inaayat\Hacks\listener\HackListener;
use Inaayat\Hacks\task\KillauraTask;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Main extends PluginBase {

	/**
	 * @var self
	 */
	private static $instance;

	public const PREFIX = TextFormat::GRAY . "[" . TextFormat::BOLD . TextFormat::RED . "InaaHacks" . TextFormat::RESET . TextFormat::GRAY . "] " . TextFormat::RESET;

	/**
	 * @var array
	 */
	private $killaura = [];

	/**
	 * @var array
	 */
	private $speed = [];

	/**
	 * @var array
	 */
	private $hitbox = [];

	/**
	 * @var array
	 */
	private $reach = [];

	/**
	 * @var array
	 */
	private $velocity = [];

	/**
	 * @var array
	 */
	private $noFall = [];

	/**
	 * @var array
	 */
	private $chestStealer = [];

	/**
	 * @var array
	 */
	private $scaffold = [];

	/**
	 * @var array
	 */
	private $nuker = [];

	/**
	 * @return void
	 */
	public function onEnable(): void {
		self::$instance = $this;
		$this->getServer()->getCommandMap()->register("hacks", new HackCommand());
		$this->getScheduler()->scheduleRepeatingTask(new KillauraTask($this), 1);
		$this->getServer()->getPluginManager()->registerEvents(new HackListener($this), $this);
	}

	/**
	 * @return self
	 */
	public static function getInstance(): self {
		return self::$instance;
	}

	/**
	 * @param Player $player
	 * 
	 * @return bool
	 */
	public function hasKillaura(Player $player): bool {
		return isset($this->killaura[$player->getName()]);
	}

	/**
	 * @param Player $player
	 * @param float $range
	 * 
	 * @return void
	 */
	public function enableKillaura(Player $player, float $range): void {
		$this->killaura[$player->getName()] = $range;
	}

	/**
	 * @param Player $player
	 * 
	 * @return void
	 */
	public function disableKillaura(Player $player): void {
		unset($this->killaura[$player->getName()]);
	}

	/**
	 * @param Player $player
	 * 
	 * @return float|null
	 */
	public function getKillauraRange(Player $player): ?float {
		return $this->killaura[$player->getName()] ?? null;
	}

	/**
	 * @param Player $player
	 * @param float $newRange
	 * 
	 * @return void
	 */
	public function modifyKillauraRange(Player $player, float $newRange): void {
		$this->killaura[$player->getName()] = $newRange;
	}

	/**
	 * @param Player $player
	 * 
	 * @return bool
	 */
	public function hasSpeed(Player $player): bool {
		return isset($this->speed[$player->getName()]);
	}

	/**
	 * @param Player $player
	 * @param float $speed
	 * 
	 * @return void
	 */
	public function enableSpeed(Player $player, float $speed): void {
		$this->speed[$player->getName()] = $speed;
		$player->setMovementSpeed($speed);
	}

	/**
	 * @param Player $player
	 * 
	 * @return void
	 */
	public function disableSpeed(Player $player): void {
		unset($this->speed[$player->getName()]);
		$player->setMovementSpeed(0.10);
	}

	/**
	 * @param Player $player
	 * 
	 * @return float|null
	 */
	public function getSpeedAmount(Player $player): ?float {
		return $this->speed[$player->getName()] ?? null;
	}

	/**
	 * @param Player $player
	 * @param float $newSpeed
	 * 
	 * @return void
	 */
	public function modifySpeedAmount(Player $player, float $newSpeed): void {
		$this->speed[$player->getName()] = $newSpeed;
		$player->setMovementSpeed($newSpeed);
	}

	/**
	 * @param Player $player
	 * 
	 * @return bool
	 */
	public function hasHitbox(Player $player): bool {
		return isset($this->hitbox[$player->getName()]);
	}

	/**
	 * @param Player $player
	 * @param float $range
	 * 
	 * @return void
	 */
	public function enableHitbox(Player $player, float $range): void {
		$this->hitbox[$player->getName()] = $range;
	}

	/**
	 * @param Player $player
	 * 
	 * @return void
	 */
	public function disableHitbox(Player $player): void {
		unset($this->hitbox[$player->getName()]);
	}

	/**
	 * @param Player $player
	 * 
	 * @return float|null
	 */
	public function getHitboxRange(Player $player): ?float {
		return $this->hitbox[$player->getName()] ?? null;
	}

	/**
	 * @param Player $player
	 * @param float $newRange
	 * 
	 * @return void
	 */
	public function modifyHitboxRange(Player $player, float $newRange): void {
		$this->hitbox[$player->getName()] = $newRange;
	}

	/**
	 * @param Player $player
	 * 
	 * @return bool
	 */
	public function hasReach(Player $player): bool {
		return isset($this->reach[$player->getName()]);
	}

	/**
	 * @param Player $player
	 * @param float $range
	 * 
	 * @return void
	 */
	public function enableReach(Player $player, float $range): void {
		$this->reach[$player->getName()] = $range;
	}

	/**
	 * @param Player $player
	 * 
	 * @return void
	 */
	public function disableReach(Player $player): void {
		unset($this->reach[$player->getName()]);
	}

	/**
	 * @param Player $player
	 * 
	 * @return float|null
	 */
	public function getReachRange(Player $player): ?float {
		return $this->reach[$player->getName()] ?? null;
	}

	/**
	 * @param Player $player
	 * @param float $newRange
	 * 
	 * @return void
	 */
	public function modifyReachRange(Player $player, float $newRange): void {
		$this->reach[$player->getName()] = $newRange;
	}

	/**
	 * @param Player $player
	 * 
	 * @return bool
	 */
	public function hasVelocity(Player $player): bool {
		return isset($this->velocity[$player->getName()]);
	}

	/**
	 * @param Player $player
	 * @param float $horizontal
	 * @param float $vertical
	 * 
	 * @return void
	 */
	public function enableVelocity(Player $player, float $horizontal, float $vertical): void {
		$this->velocity[$player->getName()]["horizontal"] = $horizontal;
		$this->velocity[$player->getName()]["vertical"] = $vertical;
	}

	/**
	 * @param Player $player
	 * 
	 * @return void
	 */
	public function disableVelocity(Player $player): void {
		unset($this->velocity[$player->getName()]);
	}

	/**
	 * @param Player $player
	 * 
	 * @return float|null
	 */
	public function getVelocityHorizontal(Player $player): ?float {
		return $this->velocity[$player->getName()]["horizontal"] ?? null;
	}

	/**
	 * @param Player $player
	 * 
	 * @return float|null
	 */
	public function getVelocityVertical(Player $player): ?float {
		return $this->velocity[$player->getName()]["vertical"] ?? null;
	}

	/**
	 * @param Player $player
	 * @param float $horizontal
	 * 
	 * @return void
	 */
	public function modifyVelocityHorizontal(Player $player, float $horizontal): void {
		$this->velocity[$player->getName()]["horizontal"] = $horizontal;
	}

	/**
	 * @param Player $player
	 * @param float $vertical
	 * 
	 * @return void
	 */
	public function modifyVelocityVertical(Player $player, float $vertical): void {
		$this->velocity[$player->getName()]["vertical"] = $vertical;
	}

	/**
	 * @param Player $player
	 * 
	 * @return bool
	 */
	public function hasNoFall(Player $player): bool {
		return isset($this->noFall[$player->getName()]);
	}

	/**
	 * @param Player $player
	 * @param int $percentage
	 * 
	 * @return void
	 */
	public function enableNoFall(Player $player, int $percentage): void {
		$this->noFall[$player->getName()] = $percentage;
	}

	/**
	 * @param Player $player
	 * 
	 * @return void
	 */
	public function disableNoFall(Player $player): void {
		unset($this->noFall[$player->getName()]);
	}

	/**
	 * @param Player $player
	 * 
	 * @return int|null
	 */
	public function getNoFallPercentage(Player $player): ?int {
		return $this->noFall[$player->getName()] ?? null;
	}

	/**
	 * @param Player $player
	 * @param int $newPercentage
	 * 
	 * @return void
	 */
	public function modifyNoFallPercentage(Player $player, int $newPercentage): void {
		$this->noFall[$player->getName()] = $newPercentage;
	}

	/**
	 * @param Player $player
	 * 
	 * @return bool
	 */
	public function hasChestStealer(Player $player): bool {
		return isset($this->chestStealer[$player->getName()]);
	}

	/**
	 * @param Player $player
	 * 
	 * @return void
	 */
	public function enableChestStealer(Player $player): void {
		$this->chestStealer[$player->getName()] = true;
	}

	/**
	 * @param Player $player
	 * 
	 * @return void
	 */
	public function disableChestStealer(Player $player): void {
		unset($this->chestStealer[$player->getName()]);
	}

	/**
	 * @param Player $player
	 * 
	 * @return bool
	 */
	public function hasScaffold(Player $player): bool {
		return isset($this->scaffold[$player->getName()]);
	}

	/**
	 * @param Player $player
	 * @param int $extend
	 * 
	 * @return void
	 */
	public function enableScaffold(Player $player, int $extend): void {
		$this->scaffold[$player->getName()] = $extend;
	}

	/**
	 * @param Player $player
	 * 
	 * @return void
	 */
	public function disableScaffold(Player $player): void {
		unset($this->scaffold[$player->getName()]);
	}

	/**
	 * @param Player $player
	 * 
	 * @return int|null
	 */
	public function getScaffoldExtend(Player $player): ?int {
		return $this->scaffold[$player->getName()] ?? null;
	}

	/**
	 * @param Player $player
	 * @param int $newExtend
	 * 
	 * @return void
	 */
	public function modifyScaffoldExtend(Player $player, int $newExtend): void {
		$this->scaffold[$player->getName()] = $newExtend;
	}

	/**
	 * @param Player $player
	 * 
	 * @return bool
	 */
	public function hasNuker(Player $player): bool {
		return isset($this->nuker[$player->getName()]);
	}

	/**
	 * @param Player $player
	 * @param int $radius
	 * 
	 * @return void
	 */
	public function enableNuker(Player $player, int $radius): void {
		$this->nuker[$player->getName()] = $radius;
	}

	/**
	 * @param Player $player
	 * 
	 * @return void
	 */
	public function disableNuker(Player $player): void {
		unset($this->nuker[$player->getName()]);
	}

	/**
	 * @param Player $player
	 * 
	 * @return int|null
	 */
	public function getNukerRadius(Player $player): ?int {
		return $this->nuker[$player->getName()] ?? null;
	}

	/**
	 * @param Player $player
	 * @param int $newRadius
	 * 
	 * @return void
	 */
	public function modifyNukerRadius(Player $player, int $newRadius): void {
		$this->nuker[$player->getName()] = $newRadius;
	}
}