<?php

namespace JGLP\Command;

use Atrapalo\Monolog\Formatter\ElasticsearchFormatter;
use JGLP\Services;
use Monolog\Logger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SeedLogs
 * @package JGLP\Command
 * @author Joe Green
 */
class SeedLogs extends Command
{
    const DEFAULT_NUM_USERS = 10;
    
    const DEFAULT_NUM_ENTRIES = 10;

    /**
     * @var \Atrapalo\Monolog\Formatter\ElasticsearchFormatter[]
     */
    protected $formatters = [];
    
    public function configure()
    {
        $this
            ->setName("seed-logs")
            ->setDescription("Seed logs through the audit logger with this command")
            ->addOption("users", "u", InputOption::VALUE_OPTIONAL, "Number of users to create logs for")
            ->addOption("events", "e", InputOption::VALUE_OPTIONAL, "Number of events per user")
        ;
    }
    
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $services = (new Services)->loadConfig();

        /** @var \Monolog\Logger $logger */
        $logger = $services->get("AuditLogger");

        $numUsers = (int) ($input->getOption("users") ?: static::DEFAULT_NUM_USERS);
        $numEntries = (int) ($input->getOption("events") ?: static::DEFAULT_NUM_ENTRIES);

        $output->writeln("Creating log entries for $numEntries events * $numUsers users:");

        for ($i = 1; $i <= $numEntries; $i++) {
            for ($j = 1; $j <= $numUsers; $j++) {
                $services->get("User")->setId($j);
                $this->updateLoggerHandlerFormatter($logger, $j);
                $logger->info("seeded log event number $i");
                $output->write(".");
            }
            $output->write("", true);
        }
    }

    /**
     * We assume here that we are using the strategy of a shared index with the user as the type.
     *
     * @param Logger $logger
     * @param int $userID
     */
    protected function updateLoggerHandlerFormatter(Logger $logger, $userID)
    {
        if (!array_key_exists($userID, $this->formatters)) {
            $this->formatters[$userID] = new ElasticsearchFormatter('audit-log-'.date('Ymd'), "user-$userID");
        }

        foreach ($logger->getHandlers() as $handler) {
            if ("Atrapalo\\Monolog\\Handler\\ElasticsearchHandler" === get_class($handler)) {
                $handler->setFormatter($this->formatters[$userID]);
            }
        }
    }
}