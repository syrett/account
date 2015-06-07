<?php

/**
 * Created by PhpStorm.
 * User: pdwjun
 * Date: 2015/5/13
 * Time: 10:25
 */
class ProgressBar
{
    private $key;

    private $running;
    private $total;
    private $done;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function start($total)
    {
        $this->running = 1;
        $this->done = 0;
        $this->total = $total;
        $this->put();
    }

    public function stop()
    {
        $this->running = 0;
        $this->put();
    }

    public function inc($step = 1)
    {
        $this->done += $step;
        $this->put();
    }

    public function put()
    {
        $ret = Yii::app()->cache->set($this->key, array('running' => $this->running, 'total' => $this->total, 'done' => $this->done));
    }

    public static function get($key, $date)
    {
        $test = 1;
        //$test = 0;
        if ($test) {
            $data = Yii::app()->cache->get($key);
            if ($data === false) {
                $data = array('running' => 1, 'total' => 100, 'done' => 0);
            }

//            $data['done'] = $data['done'] + 10;

            $data['done'] = self::onekey(!empty($date) ? $date : '', $data['done']);

            if ($data['done'] > 100) {
                $data['running'] = 0;
            }

            Yii::app()->cache->set($key, $data, 1 * 60);
            return $data;
        }

        $data = Yii::app()->cache->get($key);
        if ($data === false) {
            $data = array('running' => 1, 'total' => 100, 'done' => 0);
        }
        return $data;
    }

    public static function onekey($prefix = '', $done)
    {
        if ($prefix == '')
            $sql = 'select * from transition group by entry_num_prefix';
        else
            $sql = 'select * from transition where entry_num_prefix <=' . $prefix . ' group by entry_num_prefix';
        $data = Transition::model()->findAllBySql($sql);

        Yii::import('application.controllers.PostController');
        //这3个操作可以在一个循环里完成

        $allReviewed = true;
        switch ($done) {
            case 0:
                //整理凭证,
                foreach ($data as $item) {
                    $pre_fix = $item['entry_num_prefix'];
                    Transition::model()->reorganise($pre_fix);
                }
                $result = 10;break;
            case 10:
                //审核凭证
                $tran = new Transition();
                foreach ($data as $item) {
                    $pre_fix = $item['entry_num_prefix'];
                    Transition::setReviewedMul($pre_fix);
                    //检查凭证是否全部都审核了，
                    $reviewed = $tran->isAllReviewed($pre_fix);
                    $allReviewed = $allReviewed?$reviewed:false;
                }
                $result = 30;break;
            case 30:
                //凭证过账
                foreach ($data as $item) {
                    $pre_fix = $item['entry_num_prefix'];
                    $post = new Post();
                    $post->postTransition($pre_fix);
                }
                $result = 50;break;
            case 50:
                //凭证结账
                foreach ($data as $item) {
                    $pre_fix = $item['entry_num_prefix'];
                    Transition::model()->settlement($pre_fix);
                }
                $result = 70;break;
            case 70:
                //结转凭证 操作同上 审核凭证、凭证过账
                foreach ($data as $item) {
                    $pre_fix = $item['entry_num_prefix'];
                    Transition::setReviewedMul($pre_fix,2);
                    $post = new Post();
                    $post->postTransition($pre_fix);
                }
                $result = 101;break;
        }
//        $result = 101;
        if($allReviewed)
            return $result;
        else
            return 0;
    }

}