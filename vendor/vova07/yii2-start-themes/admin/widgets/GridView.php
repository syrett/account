<?php

namespace vova07\themes\admin\widgets;

use vova07\themes\admin\assets\DataTablesAsset;

/**
 * Class GridView
 * @package vova07\themes\admin\widgets
 * Theme GridView widget.
 */
class GridView extends \yii\grid\GridView
{
    /**
     * @inheritdoc
     */
    public $tableOptions = [
        'class' => 'table table-bordered table-hover dataTable'
    ];

    /**
     * @inheritdoc
     */
    public $options = [
        'class' => 'dataTables_wrapper form-inline',
        'role' => 'grid'
    ];

    /**
     * @inheritdoc
     */
    public $layout = "{items}\n<div class='row'><div class='col-xs-6'><div class='dataTables_info'>{summary}</div></div>\n<div class='col-xs-6'><div class='dataTables_paginate paging_bootstrap'>{pager}</div></div></div>";

    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run();

        DataTablesAsset::register($this->getView());
    }
}
