# Ride: Symfony Console Wrapper

This module integrates Symfony Console component into the Ride framework allowing you to execute
Symfony Commands inside Ride.

## Installation

    composer require ride/lib-cli-symfony:dev-master

## Usage

To use, extend AbstractSymfonyCommand:

    class SymfonyCommand extends AbstractSymfonyCommand {

        public function __construct() {
            parent::__construct(new SomeSymfonyCommand(), 'symfony command');
        }

    }
    
Add it to your dependencies.json

    #config/dependencies.json
    {
        "dependencies": [
            {
                {
                    "interfaces": "ride\\library\\cli\\command\\Command", 
                    "class": "ride\\cli\\command\\SymfonyCommand",
                    "id": "doctrine.command.symfony"
                }
            }
        ]
    }

You can now find your new command listed as a Ride command:

    php application/cli.php
