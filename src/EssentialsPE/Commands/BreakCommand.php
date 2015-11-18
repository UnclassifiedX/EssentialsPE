<?php
namespace EssentialsPE\Commands;

use EssentialsPE\BaseFiles\BaseCommand;
use EssentialsPE\Loader;
use pocketmine\block\Air;
use pocketmine\block\Block;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class BreakCommand extends BaseCommand{
    /**
     * @param Loader $plugin
     */
    public function __construct(Loader $plugin){
        parent::__construct($plugin, "break", "Breaks the block you're looking at", null, false);
        $this->setPermission("essentials.break.use");
    }

    /**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, $alias, array $args){
        if(!$this->testPermission($sender)){
            return false;
        }
        if(!$sender instanceof Player || count($args) !== 0){
            $this->sendUsage($sender, $alias);
            return false;
        }
        if(($block = $sender->getTargetBlock(100, [Block::AIR])) === null){
            $sender->sendMessage(TextFormat::RED . "There isn't a reachable block");
            return false;
        }
        if($block->getID() === Block::BEDROCK && !$sender->hasPermission("essentials.break.bedrock")){
            $sender->sendMessage(TextFormat::RED . "You can't break bedrock");
            return false;
        }
        /*$sender->getLevel()->useBreakOn(new Vector3($block->getX(), $block->getY(), $block->getZ()));
        $sender->getLevel()->useBreakOn($block);*/
        $sender->getLevel()->setBlock($block, new Air(), true, true);
        return true;
    }
} 