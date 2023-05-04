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

namespace Inaayat\Hacks\form;

use Inaayat\Hacks\form\cheststealer\HackChestStealerForm;
use Inaayat\Hacks\form\hitbox\HackHitboxForm;
use Inaayat\Hacks\form\killaura\HackKillauraForm;
use Inaayat\Hacks\form\nofall\HackNoFallForm;
use Inaayat\Hacks\form\nuker\HackNukerForm;
use Inaayat\Hacks\form\reach\HackReachForm;
use Inaayat\Hacks\form\scaffold\HackScaffoldForm;
use Inaayat\Hacks\form\speed\HackSpeedForm;
use Inaayat\Hacks\form\velocity\HackVelocityForm;
use Inaayat\Hacks\Main;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

// using apis to create forms is boring :wink: :wink:

class HackForm implements Form {

	/** @var Player */
	private $player;

	public function __construct(Player $player) {
		$this->player = $player;
	}

	/**
	 * @param Player $player
	 * @param mixed $data
	 * 
	 * @return void
	 */
	public function handleResponse(Player $player, $data): void {
		if ($data === null) {
			return;
		}
		switch ($data) {
			case 0:
				$player->sendForm(new HackKillauraForm());
				break;
			case 1:
				$player->sendForm(new HackSpeedForm());
				break;
			case 2:
				$player->sendForm(new HackHitboxForm());
				break;
			case 3:
				$player->sendForm(new HackReachForm());
				break;
			case 4:
				$player->sendForm(new HackVelocityForm());
				break;
			case 5:
				$player->sendForm(new HackNoFallForm());
				break;
			case 6:
				$player->sendForm(new HackChestStealerForm());
				break;
			case 7:
				$player->sendForm(new HackScaffoldForm());
				break;
			case 8:
				$player->sendForm(new HackNukerForm());
				break;
		}
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array {
		if (Main::getInstance()->hasKillaura($this->player)) {
			$killaura = TextFormat::GRAY . "Killaura\n" . TextFormat::GREEN . "Enabled";
		} else {
			$killaura = TextFormat::GRAY . "Killaura\n" . TextFormat::RED . "Disabled";
		}
		if (Main::getInstance()->hasSpeed($this->player)) {
			$speed = TextFormat::GRAY . "Speed\n" . TextFormat::GREEN . "Enabled";
		} else {
			$speed = TextFormat::GRAY . "Speed\n" . TextFormat::RED . "Disabled";
		}
		if (Main::getInstance()->hasHitbox($this->player)) {
			$hitbox = TextFormat::GRAY . "Hitbox\n" . TextFormat::GREEN . "Enabled";
		} else {
			$hitbox = TextFormat::GRAY . "Hitbox\n" . TextFormat::RED . "Disabled";
		}
		if (Main::getInstance()->hasReach($this->player)) {
			$reach = TextFormat::GRAY . "Reach\n" . TextFormat::GREEN . "Enabled";
		} else {
			$reach = TextFormat::GRAY . "Reach\n" . TextFormat::RED . "Disabled";
		}
		if (Main::getInstance()->hasVelocity($this->player)) {
			$velocity = TextFormat::GRAY . "Velocity\n" . TextFormat::GREEN . "Enabled";
		} else {
			$velocity = TextFormat::GRAY . "Velocity\n" . TextFormat::RED . "Disabled";
		}
		if (Main::getInstance()->hasNoFall($this->player)) {
			$noFall = TextFormat::GRAY . "NoFall\n" . TextFormat::GREEN . "Enabled";
		} else {
			$noFall = TextFormat::GRAY . "NoFall\n" . TextFormat::RED . "Disabled";
		}
		if (Main::getInstance()->hasChestStealer($this->player)) {
			$chestStealer = TextFormat::GRAY . "ChestStealer\n" . TextFormat::GREEN . "Enabled";
		} else {
			$chestStealer = TextFormat::GRAY . "ChestStealer\n" . TextFormat::RED . "Disabled";
		}
		if (Main::getInstance()->hasScaffold($this->player)) {
			$scaffold = TextFormat::GRAY . "Scaffold\n" . TextFormat::GREEN . "Enabled";
		} else {
			$scaffold = TextFormat::GRAY . "Scaffold\n" . TextFormat::RED . "Disabled";
		}
		if (Main::getInstance()->hasNuker($this->player)) {
			$nuker = TextFormat::GRAY . "Nuker\n" . TextFormat::GREEN . "Enabled";
		} else {
			$nuker = TextFormat::GRAY . "Nuker\n" . TextFormat::RED . "Disabled";
		}
		return [
			"type" => "form",
			"title" => TextFormat::BOLD . TextFormat::RED . "InaaHacks",
			"content" => TextFormat::DARK_RED . "Select an option below:",
			"buttons" => [
				[
					"text" => TextFormat::GRAY . $killaura,
				],
				[
					"text" => TextFormat::GRAY . $speed,
				],
				[
					"text" => TextFormat::GRAY . $hitbox,
				],
				[
					"text" => TextFormat::GRAY . $reach,
				],
				[
					"text" => TextFormat::GRAY . $velocity,
				],
				[
					"text" => TextFormat::GRAY . $noFall,
				],
				[
					"text" => TextFormat::GRAY . $chestStealer,
				],
				[
					"text" => TextFormat::GRAY . $scaffold,
				],
				[
					"text" => TextFormat::GRAY . $nuker,
				]
			]
		];
	}
}