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

namespace Inaayat\Hacks\form\player\scaffold;

use Inaayat\Hacks\form\player\PlayerForm;
use Inaayat\Hacks\Main;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class HackScaffoldForm implements Form {

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
				if ($hackPlugin->hasScaffold($player)) {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "Scaffold is already enabled");
				} else {
					$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have enabled Scaffold. Extend: " . TextFormat::BLUE . "5");
					$hackPlugin->enableScaffold($player, 5);
				}
				break;
			case 1:
				if ($hackPlugin->hasScaffold($player)) {
					$player->sendForm(new HackScaffoldModifyForm($player, (int) Main::getInstance()->getScaffoldExtend($player)));
				} else {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "Scaffold is not enabled");
				}
				break;
			case 2:
				if (!$hackPlugin->hasScaffold($player)) {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "Scaffold is not enabled");
				} else {
					$hackPlugin->disableScaffold($player);
					$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have disabled Scaffold.");
				}
				break;
			case 3:
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
			"title" => TextFormat::GRAY . "Scaffold",
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
				],
				[
					"text" => TextFormat::DARK_RED . "Go Back",
				]
			]
		];
	}
}