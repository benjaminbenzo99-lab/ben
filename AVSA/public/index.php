<?php
require_once dirname(__DIR__) . '/config/config.php';

$route = $_GET['page'] ?? 'home';
$validRoutes = ['home','about','what-we-do','impact','projects','stories','gallery','get-involved','contact','donate','login','admin','search','program','project','story','article','404'];

if (!in_array($route, $validRoutes, true)) {
    $route = '404';
}

$baseTemplate = __DIR__ . '/views/layout.php';

switch ($route) {
    case 'home':
        require __DIR__ . '/views/home.php';
        break;
    case 'about':
        require __DIR__ . '/views/about.php';
        break;
    case 'what-we-do':
        require __DIR__ . '/views/what-we-do.php';
        break;
    case 'impact':
        require __DIR__ . '/views/impact.php';
        break;
    case 'projects':
        require __DIR__ . '/views/projects.php';
        break;
    case 'stories':
        require __DIR__ . '/views/stories.php';
        break;
    case 'gallery':
        require __DIR__ . '/views/gallery.php';
        break;
    case 'get-involved':
        require __DIR__ . '/views/get-involved.php';
        break;
    case 'contact':
        require __DIR__ . '/views/contact.php';
        break;
    case 'donate':
        require __DIR__ . '/views/donate.php';
        break;
    case 'login':
        require __DIR__ . '/views/login.php';
        break;
    case 'admin':
        require __DIR__ . '/views/admin-login.php';
        break;
    case 'search':
        require __DIR__ . '/views/search.php';
        break;
    case 'program':
        require __DIR__ . '/views/program.php';
        break;
    case 'project':
        require __DIR__ . '/views/project.php';
        break;
    case 'story':
        require __DIR__ . '/views/story.php';
        break;
    case 'article':
        require __DIR__ . '/views/article.php';
        break;
    default:
        require __DIR__ . '/views/404.php';
}
