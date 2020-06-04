# Localization Extension for JPHP

## Installation
```
jppm add localization@git+https://github.com/GIGNIGHT/jphp-localization-ext
```

## Documentation
* Read the [API Docs](http://github.com/GIGNIGHT/jphp-localization-ext/api-docs) guide

## How to usage?

```php

<?php
# Import classes
# Or using package "localization"
use bundle\gignight\Localization;
use bundle\gignight\exception\LocalizationException;
use bundle\gignight\exception\LocalizationFileNotFoundException;

try
{
    # Specify a short language code
    $languageCode = 'ru';
    
    # Creating a new localization file
    $lFile = new \bundle\gignight\LocalizationFile("lang/{$languageCode}");
    
    # Init localization
    $localization = new Localization($lFile); # Or $languageCode
    
    # Example write lines
    $localization->set('ThISiS.ExamPle.Key', 'Hello World') # The name of the key can be any register
                 ->set('account.user.welcome', "Hello, %s! You are %d years old?") # Supports string formatting
                 ->set('app.name', 'Test')
                 ->set('...', '☺')
                 ->save(); 
                 
    # Alternative
    $config = array
    (
      'key'      => '123',
      'app.name' => 'Test',
    );
    
    $localization->setAll($config);


    # Getting
    $localization->get('account.user.welcome', 'User', 20); # Return "Hello, User! You are 20 years old?"
    $localization->get('key'); # "123"
    $localization->get('app.name'); # "Test"
    
    # Or using Helper (Global Function)
    var_dump(__('app.name'));
}
catch (LocalizationException | LocalizationFileNotFoundException $e)
{
    Logger::error($e->getMessage());
}

```
