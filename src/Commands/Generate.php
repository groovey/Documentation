<?php namespace Groovey\Documentation\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Groovey\Documentation\Manager;

class Generate extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('doc:generate')
            ->setDescription('Auto generate content data.')
            ->addOption(
               'menu',
               null,
               InputOption::VALUE_NONE,
               'If set, this will build the menu'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $text = '';



        switch ($options = $input->getOptions()) {
            case $options['menu']:

                Manager::generateMenus();


                break;

            default:
                $text = 'Nothing to generate, Please pass a parameter.';
                break;
        }

       // print_r($a['menu']);




        $output->writeln($text);
    }
}
