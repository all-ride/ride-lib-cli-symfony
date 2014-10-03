<?php

namespace ride\library\cli\output\symfony\console;

use ride\library\cli\output\Output as RideOutput;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Output\Output as SymfonyOutput;

/**
 * This class proxies all Symfony console command output through Ride output.
 */
class Output extends SymfonyOutput {
    /**
     * @var \ride\library\cli\output\Output
     */
    private $rideCommandOutput;

    /**
     * @param \ride\library\cli\output\Output $rideCommandOutput
     */
    public function __construct(RideOutput $rideCommandOutput) {
        $this->rideCommandOutput = $rideCommandOutput;
        $this->setFormatter(new OutputFormatter());
    }

    /**
     * Writes a message to the output.
     *
     * @param string $message A message to write to the output
     * @param bool $newline Whether to add a newline or not
     */
    protected function doWrite($message, $newline) {
        $method = 'write' . ($newline ? 'Line' : '');

        $this->rideCommandOutput->$method($message);
    }

}