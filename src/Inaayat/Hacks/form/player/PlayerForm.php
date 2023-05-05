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

namespace Inaayat\Hacks\form\player;

use Inaayat\Hacks\form\HackForm;
use Inaayat\Hacks\form\player\cheststealer\HackChestStealerForm;
use Inaayat\Hacks\form\player\nofall\HackNoFallForm;
use Inaayat\Hacks\form\player\nuker\HackNukerForm;
use Inaayat\Hacks\form\player\scaffold\HackScaffoldForm;
use Inaayat\Hacks\Main;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class PlayerForm implements Form {

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
				$player->sendForm(new HackNoFallForm());
				break;
			case 1:
				$player->sendForm(new HackChestStealerForm());
				break;
			case 2:
				$player->sendForm(new HackScaffoldForm());
				break;
			case 3:
				$player->sendForm(new HackNukerForm());
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
			"title" => TextFormat::BOLD . TextFormat::RED . "Player Hacks",
			"content" => TextFormat::DARK_RED . "Select an option below:",
			"buttons" => [
				[
					"text" => $noFall,
				],
				[
					"text" => $chestStealer,
				],
				[
					"text" => $scaffold,
				],
				[
					"text" => $nuker,
				],
				[
					"text" => TextFormat::DARK_RED . "Go Back",
				]
			]
		];
	}
}