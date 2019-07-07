<?php

namespace App\Commands;

use App\Api\Standalone\Lint;
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
     * @return void
     */
    public function handle()
    {
        $file = $this->argument('file');

        if (!$this->validate($file)) {
            return;
        }

        $contents = app(Lint::class)->execute(['content' => file_get_contents($file)])->getData();

        $this->checkLint($contents);
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
     * @param array $contents
     * @return void
     */
    protected function checkLint(array $contents)
    {
        if ($contents['status'] === 'invalid') {
            foreach ($contents['errors'] as $error) {
                $this->output->error($error);
            }

            return;
        }

        $this->output->success('file is valid');
    }
}
