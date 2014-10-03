<?php

namespace ride\library\cli\command\symfony\console;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use ride\library\cli\output\symfony\console\Output;
use ride\library\cli\command\AbstractCommand;

/**
 * This base class facilitates Symfony console commands integration into the Ride framework.
 *
 * <code>
 *   use Symfony\Component\Console\Command\SomeSymfonyCommand;
 *
 *   class MySymfonyCommand extends AbstractSymfonyCommand {{
 *     public function __construct() {{
 *       parent::__construct(new SomeSymfonyCommand(), 'some symfony command');
 *     }
 *   }
 * </code>
 */
abstract class AbstractSymfonyCommand extends AbstractCommand {
    /**
     * @var \Symfony\Component\Console\Application
     */
    private $application;

    /**
     * @var \Symfony\Component\Console\Command\Command
     */
    private $command;

    /**
     * @param \Symfony\Component\Console\Command\Command $command
     * @param string $name
     * @param string|null $description If null, will be retrieved from $command
     */
    public function __construct(Command $command, $name, $description = null) {
        parent::__construct($name, $description);

        $this->application = new Application();
        $this->setCommand($command);
    }

    /**
     * @param \Symfony\Component\Console\Application $application
     */
    public function setApplication(Application $application) {
        $this->application = $application;
    }

    /**
     * @return \Symfony\Component\Console\Application
     */
    protected function getApplication() {
        return $this->application;
    }

    /**
     * @param \Symfony\Component\Console\Command\Command $command
     */
    private function setCommand(Command $command) {
        $this->command = $command;
        $this->arguments = array();
        $this->flags = array();

        foreach ($command->getDefinition()->getArguments() as $arg) {
            $this->addArgument($arg->getName(), $arg->getDescription(), $arg->isRequired());
        }

        foreach ($command->getDefinition()->getOptions() as $opt) {
            $this->addFlag($opt->getName(), $opt->getDescription());
        }

        if ($this->getDescription() === null) {
            $this->setDescription($this->command->getDescription());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function execute() {
        $args = array('command' => $this->command->getName());

        foreach ($this->input->getArguments() as $arg) {
            /** @var \ride\library\cli\command\CommandArgument $arg */
            $args[$arg->getName()] = $arg->getDescription();
        }

        foreach ($this->input->getFlags() as $flag => $value) {
            $args['--' . $flag] = $value;
        }

        $input = new ArrayInput($args/*, $this->command->getDefinition()*/);

        $this->command->setApplication($this->getApplication());
        $this->command->run($input, new Output($this->output));
    }
}