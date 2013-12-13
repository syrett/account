<?php
/**
 * Created by PhpStorm.
 * User: jason.wang
 * Date: 13-12-13
 * Time: 下午6:01
 * url: http://www.yiiframework.com/wiki/454/limit-a-cgridview-field-to-some-preset-length/
 */

class YFormatter extends CFormatter{

    public $shortTextLimit= 10;
    /**
     *
     * Text formatter shortening long texts and displaying the full text
     * as the span title.
     *
     * To be used in GridViews for instance.
     * @param string $value
     * @return string  Encoded and possibly html formatted string ('span' if the text is long).
     */
    public function formatShortText($value) {
        if(strlen($value)>$this->shortTextLimit) {
            $retval=CHtml::tag('span',array('title'=>$value),CHtml::encode(mb_substr($value,0,$this->shortTextLimit-3,Yii::app()->charset).'...'));
        } else {
            $retval=CHtml::encode($value);
        }
        return $retval;
    }
}