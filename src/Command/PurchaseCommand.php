<?php

declare(strict_types=1);

namespace App\Command;

use App\Machine\SnackMachine;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class PurchaseCommand extends Command
{
    protected  function configure(): void
    {
        //...
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // $snackMachine = new SnackMachine...

        $output->writeLn("You bought 2 packs of M&M's for 5.98€, each for 2.99€");
        $output->writeLn("Your change is: ");

        $table = new Table($output);
        $table
            ->setHeaders(['Coins', 'Count'])
            ->setRows([
                //...
                ['2', 2],
                ['0.02', 1],
            ]);

        $table->render();

        return 0;
    }
}
