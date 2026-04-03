<?php

use Colibri\Exceptions\HttpException;
use Colibri\Storage\Data;
use Colibri\View\Lang;

$project = Data::get('projects/' . $params['slug']);

if (! $project) {
    throw new HttpException(404);
}

$locale = Lang::locale();

$page->title = $project['title'][$locale] ?? $project['title']['en'];
$page->description = $project['description'][$locale] ?? $project['description']['en'];
$page->og('title', $page->title);
$page->og('type', 'article');
