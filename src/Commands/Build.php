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
            ->setDescription('Builds the documentation like magic.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $config = Manager::getConfig();

        $loader = new \Twig_Loader_Filesystem(__DIR__. '/../Template/');
        $twig   = new \Twig_Environment($loader);

        $x = 1;
        foreach (Manager::getAllFiles() AS $file) {

            $saveFilename = ($x == 1) ? 'index.html' : $file['html_file'];

            $contents = $twig->render('template.html', [
                'project_name' => $config['project_name'],
                'title'        => $file['title'],
                'menu'         => Manager::generateMenu($file['html_file']),
                'navigation'   => Manager::generateNavigation($file['html_file'])
            ]);

            file_put_contents(getcwd() . '/' . $config['path_build'] .'/' . $saveFilename, $contents);

            $x++;
        }

        $text = 'Successfully build documention';
        $output->writeln($text);
    }
}
