<?php

namespace psycofeu\vSoupe;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener
{
    protected function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->notice("Plugin enable");
        $this->saveDefaultConfig();
    }
    public function itemUseEvent(PlayerItemUseEvent $event)
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        if (strtolower($item->getName()) === strtolower($this->getConfig()->get("item"))) {
            $health = $player->getHealth();
            $itemsToRemove = ($health < 3) ? 3 : (($health <= 11) ? 2 : (($health <= 19) ? 1 : 0));
            if ($itemsToRemove > 0) {
                $item->setCount($item->getCount() - $itemsToRemove);
                $player->getInventory()->setItemInHand($item);
                $player->setHealth($player->getMaxHealth());
            }
        }
    }
}
