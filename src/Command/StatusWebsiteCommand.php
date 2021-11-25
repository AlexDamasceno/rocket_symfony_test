<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\HttpClient\CurlHttpClient;

use App\Repository\WebsiteHandlerRepository;

class StatusWebsiteCommand extends Command
{
    protected static $defaultName = 'app:status-website';
    protected static $defaultDescription = 'Update website status codes';

    private $entityManager;

    public function __construct(WebsiteHandlerRepository $websiteHandlerRepository)
    {
        $this->websiteHandlerRepository = $websiteHandlerRepository;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        //find all the website
        $websites = $this->websiteHandlerRepository->findAll();

       // uses the cURL PHP extension
        $client = new CurlHttpClient();

        $table = new Table($output);
        foreach($websites as $website) {

            $table
                ->setHeaders(['Url', 'Status'])
                ->setRows([
                    [
                        $website->getUrl(), 
                        $website->getStatus()
                    ],
                ])
            ;
            $table->render();
        }

        $io->success('Everything gone well ! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
