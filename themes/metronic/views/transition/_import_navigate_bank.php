
<?
$select = '<option value="target_name" >交易对方名称</option>
                <option value="name" >商品/服务</option>
                <option value="date" >日期</option>
                <option value="memo" >交易摘要</option>
                <option value="amount" >金额</option>
                <option value="none" >无效的列</option>';
?>

<div class="modal fade bs-modal-lg" id="large" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" id="form_wizard_1">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">导入交易</h4>
            </div>

            <?
            echo CHtml::beginForm('', 'post', ['enctype' => "multipart/form-data", 'id' => 'form-import', 'class' => 'form-horizontal']);
            ?>
            <div class="modal-body import-bank form-wizard">
                <div class="stepwizard">
                    <ul class=" stepwizard-row">
                        <li class="stepwizard-step col-md-1 active stepwizard-step-left">
                            <a href="#tab_step_1" data-toggle="tab" class="btn btn-default btn-circle step">
                                <span class="number">1</span>
                            </a>

                            <p>
                                选择银行
                            </p>
                        </li>
                        <li class="stepwizard-step col-md-10 stepwizard-step-center">
                            <a href="#tab_step_2" data-toggle="tab" class="btn btn-default btn-circle step">
                                <span class="number">2</span>
                            </a>

                            <p>
                                模板下载
                            </p>
                        </li>
                        <li class="stepwizard-step col-md-1 stepwizard-step-right" >
                            <a href="#tab_step_3" data-toggle="tab" class="btn btn-default btn-circle step">
                                <span class="number">3</span>
                            </a>

                            <p>
                                导入数据
                            </p>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_step_1">
                            <p><?
                                if ($type == 'bank')
                                    $sbj = 1002;
                                if ($type == 'cash')
                                    $sbj = 1001;
                                $banks = Subjects::model()->list_sub($sbj);
                                $data = [];
                                $class = 'form-control';
                                if (empty($banks)) {
                                    echo '<input type="hidden" name="subject_b" value="1001" />';
                                } else {
                                    foreach ($banks as $item) {
                                        $data[$item['sbj_number']] = $item['sbj_name'];
                                    }
                                    $user = User::model()->findByPk(Yii::app()->user->id);
                                    $this->widget('ESelect2', array(
                                        'name' => 'subject_b',
                                        'id' => 'subject_b',
                                        'value' => $user->bank,
                                        'htmlOptions' => ['class' => $class,],
                                        'data' => $data,
                                    ));
                                    ?>
                                <? } ?>

                            </p>

                        </div>
                        <div class="tab-pane stepwizard-step-center" id="tab_step_2">
                            <p>
                                <a download="" href="/download/银行交易.xlsx">
                                    <button class="btn btn-default btn-file" type="button">模板下载
                                    </button>
                                </a>
                            </p>

                        </div>
                        <div class="tab-pane" id="tab_step_3">
                            <p>

                            <div class="input-group choose-btn-group">
                                <div class="input-icon">
                                    <i class="fa fa-file fa-fw"></i>
                                    <input type="text" class="form-control btn-file" id="import_file_name" readonly="">
                                </div>
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        选择文件<input onchange="readURL(this);" name="attachment" type="file"
                                                   accept=".xls,.xlsx,.jpg">
                                    </span>
                                </span>
                            </div>
                            </p>
                            <div id="show_image" class="hidden">
                                <div class="show_image_option">
                                    <div class="show_image_option_conf">
                                        <input type="checkbox" checked name="image_row1_type"> <span>图片第一行无需导入</span>
                                    </div>
                                    <div class="show_image_option_rows">
                                        <a class="btn btn-default btn-xs" id="delCol" onclick="delCol()" title="删除列" href="#" id="yt0">
                                            <span class="">删除列<i class="fa fa-hand-o-up"></i></span></a>
                                        <a class="btn btn-default btn-xs" id="addCol" onclick="addCol()"  title="添加列" href="#" id="yt0">
                                            <span class="">添加列<i class="fa fa-hand-o-down"></i></span></a>

                                    </div>
                                </div>
                                <div class="clear">&nbsp;</div>
                                <div>
                                    <table id="head_image" class="head_image">
                                        <thead>
                                        <tr>
                                            <th><select id="selectItem1" name="selectItem[]"><?= $select ?></select>
                                                <input type="hidden" name="show_image_conf_w[]"></th>
                                            <th><select id="selectItem2" name="selectItem[]"><?= $select ?></select>
                                                <input type="hidden" name="show_image_conf_w[]"></th>
                                            <th><select id="selectItem3" name="selectItem[]"><?= $select ?></select>
                                                <input type="hidden" name="show_image_conf_w[]"></th>
                                            <th><select id="selectItem4" name="selectItem[]"><?= $select ?></select>
                                                <input type="hidden" name="show_image_conf_w[]"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="submit_type" name="submit_type">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">取消</button>
                <a href="javascript:;" class="btn default button-previous">
                    <i class="m-icon-swapleft"></i> 上一步 </a>
                <a href="javascript:;" class="btn blue button-next">
                    下一步 <i class="m-icon-swapright m-icon-white"></i>
                </a>
                <a href="javascript:;" class="btn blue button-submit">
                    导入 <i class="m-icon-swapright m-icon-white"></i>
                </a>

            </div>
            <?php echo CHtml::endForm(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>