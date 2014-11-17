Groovey Documentation
=====================

A php scaffolding tool to generate markdown documentation website. The generates a very cool looking website for your documentation needs.

## How Does It Look?

Well, isn't that cool!

![alt tag](https://raw.githubusercontent.com/groovey/Documentation/master/groovey.png)

## Usage

    groovey doc:build

## Installation

Install using composer. To learn more about composer, visit: https://getcomposer.org

```json
{
    "require": {
        "groovey/documentation": "~1.0"
    }
}
```


## The Groovey File

On your project root folder. Create a file called `groovey`. Or this could be any project name like `awesome`. Then paste the code below.

```php
#!/usr/bin/env php
<?php

set_time_limit(0);

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Groovey\Documentation\Documentation;

$docs = new Documentation();
$app  = new Application();

$app->addCommands(
        $docs->getCommands()
    );

$app->run();
```

Good job! The hard part is done. Lets get started to create the documentation.


## Init

Setups the documentation folder and your markdown folder. These will create a folder called `markdown` and a `config.yml` file. All these files can be found under your root folder `./docs/*`

    $ groovey doc:init

## Build

Compile all your markdown files to .html files on the destination folder

    $ groovey doc:build

## Custom Site Configuration

After you have run `groovey doc:init`. `config.yml` file is generated automatically.

`project_name` refers to your awesome documentation.

`path_build` is where the destination folder will be.

## Custom Ordering

Under `markdown` folder. You can sort the file by having a prefix numeric format followed by a dash.

```directory
./01 - The first doc.md
./02 - The second doc.md
./10 - The last doc.md
./readme.md
```

## Like Us.

Give a `star` to show your support and love for the project.

## Contribution

Fork `Groovey Documentation` and send us some issues.





