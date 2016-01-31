<?php
return [
    [
        'pattern' => '',
        'action' => 'Index/index',
    ],
    [
        'pattern' => 'tree/add',
        'action' => 'Index/add',
    ],
    [
        'pattern' => 'tree/lists',
        'action' => 'Index/lists',
    ],
    [
        'pattern' => 'page/:page',
        'action' => 'Index/index',
    ],
    [
        'pattern' => 'sort/:field',
        'action' => 'Index/index',
    ],
];
