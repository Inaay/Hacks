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

namespace Inaayat\Hacks\form\killaura;

use Inaayat\Hacks\Main;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class HackKillauraForm implements Form {

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
				if ($hackPlugin->hasKillaura($player)) {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "Killaura is already enabled");
				} else {
					$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have enabled Killaura. Range: " . TextFormat::BLUE . "3.0");
					$hackPlugin->enableKillaura($player, (float) 3);
				}
				break;
			case 1:
				if ($hackPlugin->hasKillaura($player)) {
					$player->sendForm(new HackKillauraModifyForm($player, (float) Main::getInstance()->getKillauraRange($player)));
				} else {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "Killaura is not enabled");
				}
				break;
			case 2:
				if (!$hackPlugin->hasKillaura($player)) {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "Killaura is not enabled");
				} else {
					$hackPlugin->disableKillaura($player);
					$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have disabled Killaura.");
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
			"title" => TextFormat::GRAY . "Killaura",
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