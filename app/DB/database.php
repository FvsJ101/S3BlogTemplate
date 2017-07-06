<?php

use Illuminate\Database\Capsule\Manager AS Capsule;

$capsule = New Capsule();

$capsule->addConnection($container['config']->get('db'));

$capsule->setAsGlobal();

$capsule->bootEloquent();

