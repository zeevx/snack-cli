<?php

namespace Functional;

use App\Command\ShowStockCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ShowStockCommandTest extends TestCase
{
    public function test_show_stock_command_is_executable()
    {
        $application = new Application();
        $application->add(new ShowStockCommand());
        $command = $application->find('show-stock');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);
        $commandTester->assertCommandIsSuccessful();
    }

    public function test_show_stock_command_returns_the_right_output()
    {
        $application = new Application();
        $application->add(new ShowStockCommand());
        $command = $application->find('show-stock');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);
        $commandTester->assertCommandIsSuccessful();
        $output = $commandTester->getDisplay();
        $sample_output = <<<EOD
                        +---+-------+-------+
                        |   | a     | b     |
                        +---+-------+-------+
                        | 1 | Mars  | Coke  |
                        | 2 | M&M's | Pepsi |
                        +---+-------+-------+
                        
                        EOD;
        $this->assertEquals($sample_output, $output);
    }
}
