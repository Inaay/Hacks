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

namespace Inaayat\Hacks\form\player\cheststealer;

use Inaayat\Hacks\form\player\PlayerForm;
use Inaayat\Hacks\Main;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class HackChestStealerForm implements Form {

	/**
	 * @param Player $player
	 * @param mixed $data
	 * 
	 * @return void
	 */
	public function handleResponse(Player $player, $data): void {
		$hackPlugin = Main::getInstance();
		if ($data === null) {
			return;
		}
		switch ($data) {
			case 0:
				if ($hackPlugin->hasChestStealer($player)) {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "ChestStealer is already enabled");
				} else {
					$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have enabled ChestStealer.");
					$hackPlugin->enableChestStealer($player);
				}
				break;
			case 1:
				if (!$hackPlugin->hasChestStealer($player)) {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "ChestStealer is not enabled");
				} else {
					$hackPlugin->disableChestStealer($player);
					$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have disabled ChestStealer.");
				}
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
			"title" => TextFormat::GRAY . "Chest Stealer",
			"content" => TextFormat::DARK_RED . "Select an option below:",
			"buttons" => [
				[
					"text" => TextFormat::GREEN . "Enable"
				],
				[
					"text" => TextFormat::RED . "Disable"
				],
				[
					"text" => TextFormat::DARK_RED . "Go Back",
				]
			]
		];
	}
}