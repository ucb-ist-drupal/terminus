<?php

namespace Pantheon\Terminus\Helpers\Traits;

use Pantheon\Terminus\Exceptions\TerminusException;

/**
 * Trait CommandExecutorTrait.
 *
 * @package Pantheon\Terminus\Helpers\Traits
 */
trait CommandExecutorTrait
{
    /**
     * Executes the command.
     *
     * @param string $command
     * @param array $replacements
     *
     * @return array
     *
     * @throws \Pantheon\Terminus\Exceptions\TerminusException
     */
    public function execute(string $command, array $replacements = []): array
    {
        $commandToExecute = vsprintf($command, $replacements);
        $process = proc_open(
            $commandToExecute,
            [
                1 => ['pipe', 'w'],
                2 => ['pipe', 'w'],
            ],
            $pipes
        );

        $stdout = trim(stream_get_contents($pipes[1]) ?? '');
        fclose($pipes[1]);

        $stderr = trim(stream_get_contents($pipes[2]) ?? '');
        fclose($pipes[2]);

        $exitCode = proc_close($process);

        if (0 !== $exitCode) {
            throw new TerminusException(
                sprintf('Command execution exited with code %d. Error: "%s"', $exitCode, $stderr)
            );
        }

        return [$stdout, $exitCode, $stderr];
    }
}
