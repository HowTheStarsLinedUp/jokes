<?php

require 'vendor/autoload.php';

use App\App;

App::$cfg = require 'cfg.php';
App::run();
