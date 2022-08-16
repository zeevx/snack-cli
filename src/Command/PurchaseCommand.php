<?php

declare(strict_types=1);

namespace App\Command;

use App\Machine\Slot\Purchase;
use App\Machine\Slot\Slots;
use App\Machine\SnackMachine;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class PurchaseCommand extends Command
{
    /**
     * @return void
     */
    protected  function configure(): void
    {
        $this
            ->setName('purchase')
            ->setDescription('Command to make a purchase of snacks from the stocks')
            ->setHelp('A command to help you make a purchase of snacks from the stocks')
            ->addArgument('snack', InputArgument::REQUIRED, 'The snack you want to purchase.')
            ->addArgument('quantity', InputArgument::REQUIRED, 'The number of snack(s) you want to purchase.')
            ->addArgument('amount', InputArgument::REQUIRED, 'The amount you want to use for the purchase.');
    }

    /**
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $pricePerSnack = 2.99;
            $snack = $input->getArgument('snack');
            $quantity = intval($input->getArgument('quantity'));
            $amount = floatval($input->getArgument('amount'));

            $snackMachine = new SnackMachine(new Slots);
            $snackMachine->execute(
                new Purchase(
                    snack: $snack,
                    paidAmount: $amount,
                    quantity: $quantity,
                    pricePerSnack: $pricePerSnack
                )
            );
            $snackName = $snackMachine->getSnackName();
            $amountSpent = $snackMachine->getAmountSpent();
            $change = $snackMachine->getChange();

            $output->writeLn("You bought {$quantity} packs of {$snackName} for {$amountSpent}€, each for {$pricePerSnack}€");
            $output->writeLn("Your change is: ");

            $table = new Table($output);
            $table
                ->setHeaders(['Coins', 'Count'])
                ->setRows($change);

            $table->render();
            return Command::SUCCESS;
        }
        catch (\Exception $exception){

            $output->writeln($exception->getMessage());
            return Command::FAILURE;
        }
    }
}
