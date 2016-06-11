<?php

namespace Groovey\Documentation\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
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

        /*
        | -------------------------------------------------------------------
        | Parse to .html
        | -------------------------------------------------------------------
        */

        $loader      = new \Twig_Loader_Filesystem(__DIR__.'/../Template/');
        $twig        = new \Twig_Environment($loader);
        $config      = Manager::getConfig();
        $fs          = new Filesystem();
        $destination = getcwd().'/'.$config['path_build'];

        if (!$fs->exists($destination)) {
            $output->writeln("<error>The destination directory does not exist ($destination).</error>");

            return;
        }

        $x = 1;
        foreach (Manager::getAllFiles() as $file) {
            $saveFilename = ($x == 1) ? 'index.html' : $file['html_file'];

            $contents = $twig->render('template.html', [
                'project_name' => $config['project_name'],
                'title'        => $file['title'],
                'menu'         => Manager::generateMenu($file['html_file']),
                'navigation'   => Manager::generateNavigation($file['html_file']),
                'content'      => Manager::generateContent($file),
            ]);

            $path = getcwd().'/'.$config['path_build'].'/'.$saveFilename;

            file_put_contents($path, $contents);

            $output->writeln("<comment>Parsing ($saveFilename).</comment>");

            ++$x;
        }

        /*
        | -------------------------------------------------------------------
        | Mirror to destination folder
        | -------------------------------------------------------------------
        */
        $fromPath = __DIR__.'/../Template/';
        $toPath   = getcwd().'/'.$config['path_build'].'/';

        $fs->mkdir($toPath.'css', 0700);
        $fs->mkdir($toPath.'fonts', 0700);
        $fs->mkdir($toPath.'js', 0700);

        $fs->mirror($fromPath, $toPath);
        $fs->remove($toPath.'template.html');

        $output->writeln('<info>Successfully build documention</info>');
    }
}
