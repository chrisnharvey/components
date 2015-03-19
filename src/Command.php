<?php

namespace Encore\Repl;

use Encore\Console\Command as BaseCommand;
use Encore\Container\ContainerAwareTrait;
use Encore\Container\ContainerAwareInterface;

class Command extends BaseCommand implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    protected $name = 'repl';

    /**
     * Execute the command
     * 
     * @return void
     */
    public function fire()
    {
        if (isset($this->container)) {
            $this->container->launching([$this, 'repl']);

            $this->container['launcher'];
        } else {
            $this->repl();
        }
    }

    /**
     * Run the REPL loop
     * 
     * @return void
     */
    public function repl()
    {
        $input = $this->prompt();
        $buffer = null;

        while ($input != 'exit;') {
            try {
                $buffer .= $input;

                if ((new ShallowParser)->statements($buffer)) {
                    ob_start();
                    $app = $this->container;
                    eval($buffer);
                    $response = ob_get_clean();
                    
                    if ( ! empty($response)) $this->output->writeln(trim($response));

                    $buffer = null;
                }
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }

            $input = $this->prompt($buffer !== null);
        }

        if ($input == 'exit;') exit;
    }

    /**
     * Prompt the user for an input
     * 
     * @param  boolean $indent
     * @return string
     */
    protected function prompt($indent = false)
    {
        $dialog = $this->getHelperSet()->get('dialog');

        $indent = $indent ? '*' : null;

        return $dialog->ask($this->output, "<info>encore{$indent}></info>", null);
    }
}