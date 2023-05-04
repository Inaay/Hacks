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

namespace Inaayat\Hacks\form\nuker;

use Inaayat\Hacks\Main;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class HackNukerForm implements Form {

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
				if ($hackPlugin->hasNuker($player)) {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "Nuker is already enabled");
				} else {
					$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have enabled Nuker. Radius: " . TextFormat::BLUE . "3");
					$hackPlugin->enableNuker($player, 3);
				}
				break;
			case 1:
				if ($hackPlugin->hasNuker($player)) {
					$player->sendForm(new HackNukerModifyForm($player, (int) Main::getInstance()->getNukerRadius($player)));
				} else {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "Nuker is not enabled");
				}
				break;
			case 2:
				if (!$hackPlugin->hasNuker($player)) {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "Nuker is not enabled");
				} else {
					$hackPlugin->disableNuker($player);
					$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have disabled Nuker.");
				}
				break;
		}
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array {
		return [
			"type" => "form",
			"title" => TextFormat::GRAY . "Nuker",
			"content" => TextFormat::DARK_RED . "Select an option below:",
			"buttons" => [
				[
					"text" => TextFormat::GREEN . "Enable"
				],
				[
					"text" => TextFormat::BLUE . "Modify"
				],
				[
					"text" => TextFormat::RED . "Disable"
				]
			]
		];
	}
}