<?php

namespace Functional;

use App\Command\PurchaseCommand;
use App\Command\ShowStockCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class PurchaseStockCommandTest extends TestCase
{

    public function test_purchase_stock_command_snack_param_is_required()
    {
        $application = new Application();
        $application->add(new PurchaseCommand());
        $command = $application->find('purchase');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            [
            'snack' => '',
            'quantity' => 2,
            'amount' => 10.00
            ]
        );
        $output = $commandTester->getDisplay();
        $this->assertEquals('Stock column or row is missing.', trim($output));
    }

    public function test_purchase_stock_command_quantity_param_is_required()
    {
        $application = new Application();
        $application->add(new PurchaseCommand());
        $command = $application->find('purchase');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            [
            'snack' => '1a',
            'quantity' => '',
            'amount' => 10.00
            ]
        );
        $output = $commandTester->getDisplay();
        $this->assertEquals('Snack quantity is required.', trim($output));
    }

    public function test_purchase_stock_command_amount_param_is_required()
    {
        $application = new Application();
        $application->add(new PurchaseCommand());
        $command = $application->find('purchase');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            [
            'snack' => '1a',
            'quantity' => 2,
            'amount' => ''
            ]
        );
        $output = $commandTester->getDisplay();
        $this->assertEquals('Amount is required.', trim($output));
    }

    public function test_purchase_stock_command_snack_column_is_valid()
    {
        $application = new Application();
        $application->add(new PurchaseCommand());
        $command = $application->find('purchase');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            [
            'snack' => '1c',
            'quantity' => 200,
            'amount' => 10.00
            ]
        );
        $output = $commandTester->getDisplay();
        $this->assertEquals('Snack not found, check the column used.', trim($output));
    }

    public function test_purchase_stock_command_snack_row_is_valid()
    {
        $application = new Application();
        $application->add(new PurchaseCommand());
        $command = $application->find('purchase');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            [
            'snack' => '3a',
            'quantity' => 200,
            'amount' => 10.00
            ]
        );
        $output = $commandTester->getDisplay();
        $this->assertEquals('Snack not found, check the row used.', trim($output));
    }

    public function test_purchase_stock_command_amount_must_be_valid()
    {
        $application = new Application();
        $application->add(new PurchaseCommand());
        $command = $application->find('purchase');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            [
            'snack' => '1a',
            'quantity' => 200,
            'amount' => 11.00
            ]
        );
        $output = $commandTester->getDisplay();
        $validAmounts = [5,10,20,50];
        $validAmounts = implode(',', $validAmounts);
        $this->assertEquals("Invalid amount of money used, you can only use: {$validAmounts}", trim($output));
    }

    public function test_purchase_stock_command_amount_must_be_enough_for_purchase()
    {
        $application = new Application();
        $application->add(new PurchaseCommand());
        $command = $application->find('purchase');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            [
            'snack' => '1a',
            'quantity' => 200,
            'amount' => 10.00
            ]
        );
        $output = $commandTester->getDisplay();
        $this->assertEquals("You do not have enough money for this snack.", trim($output));
    }

    public function test_purchase_stock_command_is_executable()
    {
        $application = new Application();
        $application->add(new PurchaseCommand());
        $command = $application->find('purchase');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            [
            'snack' => '1a',
            'quantity' => 2,
            'amount' => 10.00
            ]
        );
        $commandTester->assertCommandIsSuccessful();
    }

    public function test_purchase_stock_command_returns_the_right_output()
    {
        $application = new Application();
        $application->add(new PurchaseCommand());
        $command = $application->find('purchase');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            [
            'snack' => '1a',
            'quantity' => 2,
            'amount' => 10.00
            ]
        );
        $commandTester->assertCommandIsSuccessful();
        $output = $commandTester->getDisplay();
        $sample_output = <<<EOD
                        You bought 2 packs of Mars for 5.98€, each for 2.99€
                        Your change is: 
                        +-------+-------+
                        | Coins | Count |
                        +-------+-------+
                        | 2     | 2     |
                        | 0.02  | 1     |
                        +-------+-------+
                        
                        EOD;
        $this->assertEquals($sample_output, $output);
    }

}