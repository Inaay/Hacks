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

namespace Inaayat\Hacks\form\combat\hitbox;

use Inaayat\Hacks\form\combat\CombatForm;
use Inaayat\Hacks\Main;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class HackHitboxForm implements Form {

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
				if ($hackPlugin->hasHitbox($player)) {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "Hitbox is already enabled");
				} else {
					$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have enabled Hitbox. Range: " . TextFormat::BLUE . "0.5");
					$hackPlugin->enableHitbox($player, (float) 0.5);
				}
				break;
			case 1:
				if ($hackPlugin->hasHitbox($player)) {
					$player->sendForm(new HackHitboxModifyForm($player, (float) Main::getInstance()->getHitboxRange($player)));
				} else {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "Hitbox is not enabled");
				}
				break;
			case 2:
				if (!$hackPlugin->hasHitbox($player)) {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "Hitbox is not enabled");
				} else {
					$hackPlugin->disableHitbox($player);
					$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have disabled Hitbox.");
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
			"title" => TextFormat::GRAY . "Hitbox",
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