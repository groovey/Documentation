<?php namespace Groovey\Documentation;

class Documentation
{

    public function getCommands()
    {
        return [
            new Commands\Init(),
            new Commands\Build(),
        ];
    }
}
