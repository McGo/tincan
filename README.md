xAPI (TinCan) PHP library from [Aduro](http://adurolms.com)

This library assists a [LMS](http://en.wikipedia.org/wiki/Learning_management_system) 
working with TinCan package file (.zip) and external [LRS](http://tincanapi.com/learning-record-store/)

======


``` php
<?php

use GO1\LMS\TinCan\TinCanManager;
use GO1\LMS\TinCan\LRS\LRS;

$manager = new TinCanManager(new LRS('http://lrs.example.com/data/xAPI/', 'user', 'password'));
$zip = 'path/to/file.zip';

// validate the tincan.xml in the zip file without extracting, return boolean
$manager->validateSchema($zip);

//continue...
```