<?php namespace Groovey\Documentation;

use Symfony\Component\Finder\Finder;



use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;

class Manager
{

    public function __construct()
    {
    }

    public static function getDirectory($folder = '')
    {
        return getcwd().'/docs' . $folder;
    }

    public static function getAllFiles()
    {

        $finder    = new Finder();
        $markdowns = self::getDirectory('/markdown');

        $files = $finder->in($markdowns)->sortByName();

        $data = [];
        foreach ($files as $file) {

            $filename = $file->getRelativePathname();

            if (strpos($filename, '-')){
                list($prefix, $temp)     = explode('-', $filename);
                list($title, $extension) = explode('.', $temp);
                $prefix                  = trim($prefix);
                $title                   = trim($title);
                $extension               = trim($extension);
            } else {
                $prefix                  = '';
                list($title, $extension) = explode('.', $filename);
            }

            $data[] = [
                'filename'          => $filename,
                'prefix'            => $prefix,
                'title'              => $title,
                'extension'         => $extension,
                'html_file'         => strtolower(str_replace(' ', '-', $title) . '.html' ),
                'real_path'         => $file->getRealpath(),
                'relative_pathname' => $file->getRelativePathname()
            ];
        }

        return $data;
    }

    public static function generateMenu($selected)
    {

        $files = self::getAllFiles();
        $html  = '';
        $x     = 1;

        foreach ($files AS $file) {

            $current = ($selected == $file['html_file']) ? 'current' : '';
            $link    = ($x == 1) ? 'index.html' : $file['html_file'];

            $html .=    '<li class="toctree-l1 '. $current .'">
                            <a class="reference internal" href="' . $link .'">' .$file['title']. '</a>
                        </li>';


            $x++;
        }

        return '<ul>' . $html . '</ul>';
    }

    public static function build()
    {

        $loader = new \Twig_Loader_Filesystem(__DIR__. '/Template/');
        $twig   = new \Twig_Environment($loader);

        $files = self::getAllFiles();

        $x = 1;
        foreach ($files AS $file) {

            $MENU = self::generateMenu($file['html_file']);

            $saveFilename = ($x == 1) ? 'index.html' : $file['html_file'];

            $contents = $twig->render('template.html', [
                'MENU' => $MENU
            ]);

            file_put_contents(getcwd() . '/public/' . $saveFilename, $contents);

            $x++;
        }

    }

}
