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

namespace Inaayat\Hacks\form\combat\reach;

use Inaayat\Hacks\form\combat\CombatForm;
use Inaayat\Hacks\Main;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class HackReachForm implements Form {

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
				if ($hackPlugin->hasReach($player)) {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "Reach is already enabled");
				} else {
					$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have enabled Reach. Range: " . TextFormat::BLUE . "4.0");
					$hackPlugin->enableReach($player, (float) 4.0);
				}
				break;
			case 1:
				if ($hackPlugin->hasReach($player)) {
					$player->sendForm(new HackReachModifyForm($player, (float) Main::getInstance()->getReachRange($player)));
				} else {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "Reach is not enabled");
				}
				break;
			case 2:
				if (!$hackPlugin->hasReach($player)) {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "Reach is not enabled");
				} else {
					$hackPlugin->disableReach($player);
					$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have disabled Reach.");
				}
				break;
			case 3:
				$player->sendForm(new CombatForm($player));
				break;
		}
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array {
		return [
			"type" => "form",
			"title" => TextFormat::GRAY . "Reach",
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