Groovey Documentation
=====================

A php scaffolding tool to generate markdown documentation website. The generates a very cool looking website for your documentation needs.

## How Does It Look?

![alt tag](https://raw.githubusercontent.com/groovey/Documentation/master/groovey.png)

## Step 1 - Composer Installation

Install using composer. To learn more about composer, visit: https://getcomposer.org

```json
{
    "require": {
        "groovey/documentation": "~1.0"
    }
}
```


## Step 2 - The Groovey File

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

Good job! The hard part is done. Lets get started.


## Step 3 - Init

Initialize the `./docs` folder.

    $ groovey doc:init

A `config.yml` file is generated automatically.

`project_name` refers to your awesome documentation project.

`path_build` is where the destination folder will be.

Place your content files under `./docs/markdown`.

## Step 4 - Build

Compile all your markdown files to .html files.

    $ groovey doc:build


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





