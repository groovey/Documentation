<?php namespace Groovey\Documentation;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Parser;

class Manager
{

    public function __construct()
    {
    }

    public static function getConfig()
    {
        $yaml = new Parser();

        return $yaml->parse(file_get_contents(self::getDirectory() . '/config.yml'));
    }

    public static function getDirectory($folder = '')
    {
        return getcwd().'/docs' . $folder;
    }

    public static function getAllFiles()
    {

        $finder    = new Finder();
        $markdowns = self::getDirectory('/markdown');
        $files     = $finder->in($markdowns)->sortByName();
        $data      = [];

        foreach ($files as $file) {

            $filename = $file->getRelativePathname();

            if (strpos($filename, '-')) {
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
                'title'             => $title,
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

        foreach ($files as $file) {

            $current = ($selected == $file['html_file']) ? 'current' : '';
            $link    = ($x == 1) ? 'index.html' : $file['html_file'];

            $html .=    '<li class="toctree-l1 '. $current .'">
                            <a class="reference internal" href="' . $link .'">' .$file['title']. '</a>
                        </li>';

            $x++;
        }

        return '<ul>' . $html . '</ul>';
    }

    public static function generateNavigation($current)
    {
        $files = self::getAllFiles();
        $html  = '';
        $x     = 1;
        $nav   = [];

        foreach ($files as $file) {
            $nav[] = ($x == 1) ? 'index.html' : $file['html_file'];
            $x++;
        }

        $key      = array_search($current, $nav);
        $previous = ($key == 0) ? null : $key - 1;
        $next     = ($key == count($nav) - 1 ) ? null :  $key + 1;

        if (isset($next)) {
            $html .= '<a href="' . $nav[$next] . '" class="btn btn-neutral float-right">Next &nbsp;
                      <span class="fa fa-arrow-circle-right"></span></a>';

        }

        if (isset($previous)) {
            $html .= '<a href="' . $nav[$previous] .'" class="btn btn-neutral">
                      <span class="fa fa-arrow-circle-left"></span>&nbsp; Previous</a>';
        }

        return $html;
    }

    public static function generateContent($file)
    {

        $parsedown = new \Parsedown();
        $contents  = file_get_contents($file['real_path']);

        return $parsedown->text($contents);
    }

}
