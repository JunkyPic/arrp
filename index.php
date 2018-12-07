<?php

require 'vendor/autoload.php';

$ds = new \Arrp\Collection([
    1,
    'data' => [
        'inner_data' => 'value',
        'inner_value_value' => [
            'to_unset' => 'value',
            'to_unset2' => 'value',
            'to_unset1' => 'value',
        ],
        'inner_value_value2' => [
            'asdfa' => 'asdfasfadf',
            'to_unset2' => 'value',
            'to_unset1' => 'value',
            'inner_data' => 'value',
            'inner_value_value4' => [
                'to_unset' => 'value',
                'asdfa' => 'value2',
                'to_unset1' => 'value',
            ],
        ]
    ]
]);

echo '<pre>';
var_dump($ds->offsetGet('asdfa'));
