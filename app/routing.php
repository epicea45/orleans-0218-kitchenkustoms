<?php
/**
 * This file hold all routes definitions.
 *
 * PHP version 7
 *
 * @author   WCS <contact@wildcodeschool.fr>
 *
 * @link     https://github.com/WildCodeSchool/simple-mvc
 */

$routes = [
    'Home' => [ // Controller
        ['index', '/', 'GET'], // action, url, method
        ['catering', '/restauration', 'GET'],
        ['workshop', '/atelier', 'GET'],
        ['kustoms', '/kustoms', 'GET'],
        ['shop', '/boutique', 'GET'],
    ],
];