<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ServeCommand as BaseServeCommand;
use Illuminate\Support\Collection;
use Symfony\Component\Process\Process;

class ServeCommand extends BaseServeCommand
{
    /**
     * Start a new server process.
     *
     * Windows may expose environment variables like SystemRoot with mixed case,
     * so we match passthrough keys case-insensitively before spawning PHP.
     *
     * @param  bool  $hasEnvironment
     * @return \Symfony\Component\Process\Process
     */
    protected function startProcess($hasEnvironment)
    {
        $passthroughVariables = array_map('strtoupper', static::$passthroughVariables);

        $process = new Process($this->serverCommand(), public_path(), (new Collection($_ENV))->mapWithKeys(function ($value, $key) use ($hasEnvironment, $passthroughVariables) {
            if ($this->option('no-reload') || ! $hasEnvironment) {
                return [$key => $value];
            }

            return in_array(strtoupper($key), $passthroughVariables, true) ? [$key => $value] : [$key => false];
        })->merge(['PHP_CLI_SERVER_WORKERS' => $this->phpServerWorkers])->all());

        $this->trap(fn () => [SIGTERM, SIGINT, SIGHUP, SIGUSR1, SIGUSR2, SIGQUIT], function ($signal) use ($process) {
            if ($process->isRunning()) {
                $process->stop(10, $signal);
            }

            exit;
        });

        $process->start($this->handleProcessOutput());

        return $process;
    }
}
