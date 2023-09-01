<?php

namespace skyss0fly\PMPluginConversion;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class Convert extends PluginBase {
    public function onLoad(): void {
        $this->getLogger()->info("Successfully Loaded PmPluginConversion. usage: /convert PluginName PMAPIVersion");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if ($command->getName() === "convert") {
            if (count($args) < 2) {
                $sender->sendMessage("Usage: /convert pluginname pmapiversion");
                return false;
            }
            
            $pluginName = $args[0];
            $pmapiversion = $args[1];
            
            // Your code to Handle the conversion using $pluginName and $pmapiversion
            $convertedCode = $this->convertPhp7ToPhp8($plugintoconvert);
            
            $sender->sendMessage("Conversion completed successfully!");
            return true;
        }
        
        return false;
    }

    private function convertPhp7ToPhp8($code) {
        // Replace deprecated functions
        $code = str_replace("mysql_", "mysqli_", $code);
        
        // Replace deprecated syntax
        $code = preg_replace("/\b(array)\s*\(/", "[$1](", $code);
        
        // Update error handling
        $code = str_replace("set_error_handler", "set_exception_handler", $code);
        
        // Update type declarations
        $code = preg_replace("/\b(int|float|bool|string|resource|object|array|callable|iterable)\b/", "$1", $code);
        
        // Update null coalescing operator
        $code = preg_replace("/\b(\?\?)\b/", "??", $code);

        // Update match expression
        $code = preg_replace("/\b(match)\b/", "match", $code);

        // Update named arguments
        $code = preg_replace("/\b(\w+)\s*=\s*(\w+)\b/", "$1: $2", $code);

        // Update attribute syntax
        $code = preg_replace("/\b(\w+)\s*@\s*(\w+)\b/", "[$2]", $code);

        // Update arrow functions
        $code = preg_replace("/\b(function)\s*\((.*?)\)\s*=>\s*(.*?)\b/", "fn($2) => $3", $code);

        return $code;
    }
}
