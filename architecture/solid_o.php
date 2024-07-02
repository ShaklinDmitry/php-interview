<?php

class SomeObject {
    protected $name;

    public function __construct(string $name) { }

    public function getObjectName() { }

    public function handle() { }
}

class SomeObjectsHandler {
    public function __construct() { }

    public function handleObjects(array $objects) {
        foreach ($objects as $object) {
            $object->handle();
        }
    }
}

$objects = [
    new SomeObject('object_1'),
    new SomeObject('object_2')
];

$soh = new SomeObjectsHandler();
$soh->handleObjects($objects);