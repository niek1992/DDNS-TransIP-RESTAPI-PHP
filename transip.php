<?php

use Transip\Api\Library\Entity\Domain\DnsEntry;
use Transip\Api\Library\TransipAPI;

require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__. '/auth.php');

// Fetching timestamp for logging purposes
$time = date('d/m/Y H:i:s', time());

// fetching current home IP
$homeIpAddress = file_get_contents('https://ipecho.net/plain');
echo "Current IP: ".$homeIpAddress . PHP_EOL;

// Setting domainName. could be hardcoded..
$domainName="niekdejong.nl";

// Trying to fetch a single dnsEntry 
try{
    $dnsEntries = $api->domainDns()->getByDomainName($domainName);
        foreach($dnsEntries as $dnsEntry){
            
            // fetching '@' record
            if(($dnsEntry->getType() == DnsEntry::TYPE_A) && ($dnsEntry->getName() == '@')){
                
                // Checking if it has changed
                if($dnsEntry->getContent() != $homeIpAddress){
                    
                    // Updating IP address
                    $dnsEntry->setContent($homeIpAddress);
                
                    // logging it to seperate file for easier readability
                    file_put_contents("changelog.txt", "". $time ." - !!UPDATED!! --> New IP: ". $ipAddress ." \r\n", FILE_APPEND);
                    file_put_contents("logging.txt", "". $time ." Update applied. See changelog.txt. " . $homeIpAddress . ".\r\n", FILE_APPEND);
                }
                else{
                    file_put_contents("logging.txt", "". $time ." No update needed, current IP: " . $homeIpAddress . " remains unchanged.\r\n", FILE_APPEND);
                }
            }
        }
}catch (Exception $e){                                      /// TODO: use some better exception handling with builtin exceptions of TransIP API library.
    file_put_contents("logging.txt", "" . $time . "Caught exception: " . $e->getMessage() . "\r\n", FILE_APPEND);
}

?>