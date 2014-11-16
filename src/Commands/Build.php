<?php namespace Groovey\Documentation\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Groovey\Documentation\Manager;

class Build extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('doc:build')
            ->setDescription('Builds the documentation.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {


        Manager::build();

        $text = 'Successfully build documention';


        $output->writeln($text);
    }
}
