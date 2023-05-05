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

namespace Inaayat\Hacks\form\movement;

use Inaayat\Hacks\form\HackForm;
use Inaayat\Hacks\form\movement\speed\HackSpeedForm;
use Inaayat\Hacks\Main;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class MovementForm implements Form {

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
				$player->sendForm(new HackSpeedForm());
				break;
			case 1:
				$player->sendForm(new HackForm());
				break;
		}
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array {
		if (Main::getInstance()->hasSpeed($this->player)) {
			$speed = TextFormat::GRAY . "Speed\n" . TextFormat::GREEN . "Enabled";
		} else {
			$speed = TextFormat::GRAY . "Speed\n" . TextFormat::RED . "Disabled";
		}
		return [
			"type" => "form",
			"title" => TextFormat::BOLD . TextFormat::RED . "Movement Hacks",
			"content" => TextFormat::DARK_RED . "Select an option below:",
			"buttons" => [
				[
					"text" => $speed,
				],
				[
					"text" => TextFormat::DARK_RED . "Go Back",
				]
			]
		];
	}
}