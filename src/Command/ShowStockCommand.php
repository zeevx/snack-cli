<?php

declare(strict_types=1);

namespace App\Command;

use App\Machine\Slot\Slots;
use App\Machine\SnackMachine;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ShowStockCommand extends Command
{
    protected  function configure(): void
    {
        $this
            ->setName('show-stock')
            ->setDescription('Command to show snacks stocks')
            ->setHelp('A command to help show the snacks available in stock');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
         $snackMachine = new SnackMachine(new Slots);
         $loadMachine = $snackMachine->loadMachine();

        $table = new Table($output);
        $table
            ->setHeaders($loadMachine['columns'])
            ->setRows($loadMachine['rows']);

        $table->render();

        return Command::SUCCESS;
    }
}
