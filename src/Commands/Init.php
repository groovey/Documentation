<?php namespace Groovey\Documentation\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

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

        $fs     = new Filesystem();
        $folder = getcwd() . '/docs/markdown';
        $helper = $this->getHelper('question');

        if ($fs->exists($folder)) {

            $question = new ConfirmationQuestion(
                '<question>The doc folder already exist, are you sure you want to replace it? (Y/N):</question> ',
                 false);

            if (!$helper->ask($input, $output, $question)) {
                return;
            }
        }

        try {
            $fs->mkdir($folder, 755);
        } catch (IOExceptionInterface $e) {
            $output->writeln("<error>An error occurred while creating your directory at {$e->getPath()}</error>");

            return;
        }

        if (file_exists($folder) && is_dir($folder)) {
            $output->writeln("<comment>Place all your markdown files in ($folder)</comment>");
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

        file_put_contents($folder . '/../config.yml', $template);

        /*
        | -------------------------------------------------------------------
        | Create a sample readme file
        | -------------------------------------------------------------------
        */

        $contents = file_get_contents(__DIR__. '/../../README.md');
        file_put_contents($folder . '/01 - readme.yml', $contents);

        $text = '<info>Sucessfully created docs.</info>';

        $output->writeln($text);
    }
}
