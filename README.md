This module integrates Symfony Console component into the Ride framework allowing you to execute
Symfony Commands inside Ride.

To use, simply extend AbstractSymfonyCommand:

```
class SymfonyCommand extends AbstractSymfonyCommand {

    public function __construct() {
        parent::__construct(new SomeSymfonyCommand(), 'symfony command');
    }

}
```

You can now find your new command listed as a Ride command:

    php application/cli.php