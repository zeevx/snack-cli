<?php

declare(strict_types=1);

namespace App\Command;

use App\Machine\SnackMachine;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ShowStockCommand extends Command
{
    protected  function configure(): void
    {
        //...
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // $snackMachine = new SnackMachine...

        $table = new Table($output);
        $table
            ->setHeaders(['', 'a', 'b'])
            ->setRows([
                //...
                ['1', 'Mars', 'Coke'],
                ['2', "M&M's", 'Pepsi'],
            ]);

        $table->render();

        return 0;
    }
}
