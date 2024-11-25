<?php
$directory = 'images/android-app/';

// Получаем список всех файлов и директорий в указанной директории
$contents = scandir($directory);

// Фильтруем только директории (исключая текущую и родительскую директории)
$directories = array_filter($contents, function ($item) use ($directory) {
    return is_dir($directory . '/' . $item) && !in_array($item, ['.', '..']);
});

$styles['styles'] = [];

// Выводим список директорий
foreach ($directories as $dir) {
  $styles['styles'][] = $dir;
}
echo json_encode($styles);
?>