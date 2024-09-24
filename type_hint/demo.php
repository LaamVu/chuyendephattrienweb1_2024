<?php
declare(strict_types=1);
class Demo {
    public function typeXReturnY($x, $y) {
        echo __FUNCTION__ . "<br>";
        return new $x();
    }
}

class A {
    public function __construct() {
        echo "Class A initialized<br>";
    }
}

class B {
    public function __construct() {
        echo "Class B initialized<br>";
    }
}

class C {
    public function __construct() {
        echo "Class C initialized<br>";
    }
}

class I {
    public function __construct() {
        echo "Class I initialized<br>";
    }
}

$demo = new Demo();

$xValues = ['A', 'B', 'C', 'I', 'Null'];
$yValues = ['A', 'B', 'C', 'I', 'Null'];

foreach ($xValues as $x) {
    foreach ($yValues as $y) {
        echo "Testing X = $x, Y = $y:<br>";
        if ($x !== 'Null') {
            $result = $demo->typeXReturnY($x, $y);
        } else {
            $result = null;
            echo "Returning Null<br>";
        }
        echo "<br>";
    }
}
