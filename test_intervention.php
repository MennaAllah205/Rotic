<?php

require_once 'vendor/autoload.php';

echo 'Testing Intervention Image:' . PHP_EOL;
echo 'Class exists: ' . (class_exists('Intervention\Image\Facades\Image') ? 'Yes' : 'No') . PHP_EOL;
echo 'Facade exists: ' . (class_exists('Intervention\Image\Image') ? 'Yes' : 'No') . PHP_EOL;
echo 'Manager exists: ' . (class_exists('Intervention\Image\ImageManager') ? 'Yes' : 'No') . PHP_EOL;

echo 'Available classes in Intervention namespace:' . PHP_EOL;
$classes = get_declared_classes();
foreach ($classes as $class) {
    if (strpos($class, 'Intervention\\') === 0) {
        echo '- ' . $class . PHP_EOL;
    }
}

if (class_exists('Intervention\Image\Facades\Image')) {
    echo 'Creating test image...' . PHP_EOL;
    try {
        $img = \Intervention\Image\Facades\Image::make('public/temp/test.jpg')->resize(100, 100);
        echo 'Test image created successfully' . PHP_EOL;
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage() . PHP_EOL;
    }
} else {
    echo 'Intervention Image Facade not available' . PHP_EOL;
}
