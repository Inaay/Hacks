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

namespace Inaayat\Hacks\form\combat;

use Inaayat\Hacks\form\combat\hitbox\HackHitboxForm;
use Inaayat\Hacks\form\combat\killaura\HackKillauraForm;
use Inaayat\Hacks\form\combat\reach\HackReachForm;
use Inaayat\Hacks\form\combat\velocity\HackVelocityForm;
use Inaayat\Hacks\form\HackForm;
use Inaayat\Hacks\Main;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class CombatForm implements Form {

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
				$player->sendForm(new HackHitboxForm());
				break;
			case 2:
				$player->sendForm(new HackReachForm());
				break;
			case 3:
				$player->sendForm(new HackVelocityForm());
				break;
			case 4:
				$player->sendForm(new HackForm());
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
		return [
			"type" => "form",
			"title" => TextFormat::BOLD . TextFormat::RED . "Combat Hacks",
			"content" => TextFormat::DARK_RED . "Select an option below:",
			"buttons" => [
				[
					"text" => $killaura,
				],
				[
					"text" => $hitbox,
				],
				[
					"text" => $reach,
				],
				[
					"text" => $velocity,
				],
				[
					"text" => TextFormat::DARK_RED . "Go Back",
				]
			]
		];
	}
}