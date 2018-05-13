<?php

function readFiles($directory) {
    $excludedFiles = ['.', '..', '.gitkeep'];

    $files = [];
    foreach ( scandir($directory) as $file) {
        if (in_array($file, $excludedFiles) || is_dir($directory . $file)) {
            continue;
        }

        $files[] = $file;
    }

    return $files;
}

function insertAfterContent ($content, $searchString, $addContent) {
    $position = strpos($content, $searchString);

    if ($position === false) {
        return $content;
    }

    $position += strlen($searchString);

    return substr($content, 0, $position) . $addContent . substr($content, $position);
}

function hasContent ($content, $searchString) {
    $position = strpos($content, $searchString);

    if ($position === false) {
        return false;
    }

    return true;
}

function replaceContent ($content, $searchString, $replaceString) {
    $position = strpos($content, $searchString);

    if ($position === false) {
        return $content;
    }

    return str_replace($searchString, $replaceString, $content);
}

$blogPath = __DIR__ . "/../source/_reiseblog/";

$searchString = 'overview:';

$addContent = 'headline:
  image:
    url: /assets/img/blog/2017-asia-oz/train-banner.jpg
    alt: "Der Zug der Kuranda Scenic Railway"

overview:';

$fromDate = strtotime('2017-01-01');

foreach(readFiles($blogPath) as $fileName) {
    $date = strtotime(substr($fileName, 0, 10));
    if ($date < $fromDate) {
        continue;
    }

	$content = file_get_contents($blogPath . $fileName);
    if (hasContent($content, 'headline:')) {
        continue;
    }

	$content = replaceContent($content, $searchString, $addContent);

	file_put_contents($blogPath . $fileName, $content);
}
