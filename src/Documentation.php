<?php namespace Groovey\Documentation;

use Groovey\Documentation\Commands;

class Documentation
{

    public function getCommands()
    {
        return [
            new Commands\Init,
            new Commands\Generate,
            new Commands\Build,
        ];
    }
}
