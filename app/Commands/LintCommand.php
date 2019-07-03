<?php

namespace App\Commands;

use App\Apis\Client;
use App\Apis\Standalone\Lint;
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
    protected $description = 'Checks if your .gitlab-ci.yml file is valid';

    /**
     * @param \App\Apis\Client $client
     * @return void
     */
    public function handle(Client $client)
    {
        $file = $this->argument('file');

        if (!$this->validate($file)) {
            return;
        }

        $resource = (new Lint())->body(['content' => file_get_contents($file)]);

        $this->checkLint($client->request($resource));
    }

    /**
     * @param string $file
     * @return bool
     */
    protected function validate(string $file): bool
    {
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
