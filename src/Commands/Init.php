<?php namespace Groovey\Documentation\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Init extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('doc:init')
            ->setDescription('Setup your directory and configuration files.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        /*
        | -------------------------------------------------------------------
        | Create the folders
        | -------------------------------------------------------------------
        */

        $folderDocs = getcwd() . '/docs';

        $error = "<info>Unable to create folder. Check file permissions.</info>";

        if (false === @mkdir($folderDocs, 0755, true) && !file_exists($folderDocs)) {
            $output->writeln($error);

            return;
        }

        $folderMarkdown = getcwd() . '/docs/markdown';

        if (false === @mkdir($folderMarkdown, 0755, true) && !file_exists($folderMarkdown)) {
            $output->writeln($error);

            return;
        }

        if (file_exists($folderMarkdown) && is_dir($folderMarkdown)) {
            $output->writeln("<error>Place all your markdown files in ({$folderMarkdown})</error>");
        }

        /*
        | -------------------------------------------------------------------
        | Create the config template
        | -------------------------------------------------------------------
        */

        $template = <<<TEMPLATE
project_name: Awesome
path_build: public

TEMPLATE;

        file_put_contents($folderDocs . '/config.yml', $template);

        $text = '<info>Sucessfully created docs.</info>';

        $output->writeln($text);
    }
}
