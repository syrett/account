<?php
/**
 * Created by PhpStorm.
 * User: -
 * Date: 06/06/14
 * Time: 00:03
 */

$html2pdf = Yii::app()->ePdf->HTML2PDF();
$html2pdf->WriteHTML($this->renderPartial('index', array(), true));
$html2pdf->Output();