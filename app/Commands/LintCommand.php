<?php

namespace App\Commands;

use App\Services\ApiService;
use LaravelZero\Framework\Commands\Command;

class LintCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'lint
                            {file : The .gitlab-ci.yml file.}';

    /**
     * @var string
     */
    protected $description = 'Checks if your .gitlab-ci.yml file is valid.';

    /**
     * @param \App\Services\ApiService $service
     * @return void
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(ApiService $service)
    {
        if (!$this->validate()) {
            return;
        }

        $this->checkLint(
            $service->lintCi(file_get_contents($this->argument('file')))
        );
    }

    /**
     * @return bool
     */
    protected function validate(): bool
    {
        $file = $this->argument('file');

        if (!is_file($file)) {
            $this->output->error("File does not exist at path $file");

            return false;
        }

        return true;
    }

    /**
     * @param object $response
     * @return void
     */
    protected function checkLint(object $response)
    {
        if ($response->status === 'invalid') {
            foreach ($response->errors as $error) {
                $this->output->error($error);
            }

            return;
        }

        $this->output->success('file is valid');
    }
}
