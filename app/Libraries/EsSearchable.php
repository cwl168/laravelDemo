<?php
/**
 * Created by PhpStorm.
 * User: caoweilin
 * Date: 2018/5/6
 * Time: 下午1:57
 */
namespace App\Libraries;

trait EsSearchable
{
    public $searchSettings = [
        'attributesToHighlight' => [
            '*'
        ]
    ];

    public $highlight = [];
}