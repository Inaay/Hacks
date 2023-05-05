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

use Inaayat\Hacks\form\combat\CombatForm;
use Inaayat\Hacks\form\movement\MovementForm;
use Inaayat\Hacks\form\player\PlayerForm;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

// using apis to create forms is boring :wink: :wink:

class HackForm implements Form {

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
				$player->sendForm(new CombatForm($player));
				break;
			case 1:
				$player->sendForm(new MovementForm($player));
				break;
			case 2:
				$player->sendForm(new PlayerForm($player));
				break;
		}
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array {
		return [
			"type" => "form",
			"title" => TextFormat::BOLD . TextFormat::RED . "InaaHacks",
			"content" => TextFormat::DARK_RED . "Select an option below:",
			"buttons" => [
				[
					"text" => TextFormat::BOLD . TextFormat::GRAY . "Combat",
				],
				[
					"text" => TextFormat::BOLD . TextFormat::GRAY . "Movement",
				],
				[
					"text" => TextFormat::BOLD . TextFormat::GRAY . "Player",
				]
			]
		];
	}
}