<?php

namespace Encore\REPL;

use Encore\Console\Command as BaseCommand;
use Encore\Container\ContainerAwareTrait;
use Encore\Container\ContainerAwareInterface;

class Command extends BaseCommand implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public $name = 'repl';

    public function fire()
    {
        register_shutdown_function([$this, 'handleFatal']);

        if (isset($this->container)) {
            $this->container->launching([$this, 'repl']);

            $this->container['launcher'];
        } else {
            $this->repl();
        }
    }

    public function handleFatal()
    {        
        if (error_get_last()) {
            ob_end_flush();
            $this->repl();
        }
    }

    public function repl()
    {
        $input = $this->prompt();
        $buffer = null;

        while ($input != 'exit;') {
            try {
                $buffer .= $input;

                if ((new ShallowParser)->statements($buffer)) {
                    ob_start();
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

    protected function prompt($indent = false)
    {
        $dialog = $this->getHelperSet()->get('dialog');

        $indent = $indent ? '*' : null;

        return $dialog->ask($this->output, "<info>encore{$indent}></info>", null);
    }
}