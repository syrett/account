
<div class="modal fade bs-modal-lg" id="large" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" id="form_wizard_1">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">导入<?= Yii::t('import', strtoupper($type)) ?></h4>
            </div>

            <?
            echo CHtml::beginForm('', 'post', ['enctype' => "multipart/form-data", 'id' => 'form-import', 'class' => 'form-horizontal']);
            ?>
            <div class="modal-body import-bank form-wizard">
                <div class="stepwizard">
                    <ul class=" stepwizard-row">
                        <li class="stepwizard-step col-md-1 stepwizard-step-left  active">
                            <a href="#tab_step_1" data-toggle="tab" class="btn btn-default btn-circle step">
                                <span class="number">1</span>
                            </a>
                            <p>
                                模板下载
                            </p>
                        </li>
                        <li class="stepwizard-step col-md-11 stepwizard-step-right">
                            <a href="#tab_step_2" data-toggle="tab" class="btn btn-default btn-circle step">
                                <span class="number">2</span>
                            </a>
                            <p>
                                导入数据
                            </p>
                        </li>
                    </ul>
                    <div id="bar" class="progress progress-striped" role="progressbar">
                        <div class="progress-bar progress-bar-success">
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_step_1">
                            <p>
                                <a download="" href="/download/<?= Yii::t('import', strtoupper($type)) ?>.xlsx">
                                    <button class="btn btn-default btn-file" type="button">模板下载
                                    </button>
                                </a>

                                <?
                                if ($type == 'salary') {
                                    echo "<button type='submit' class='btn btn-default btn-file' name='type' value='load'>提取工资数据</button>";
                                }

                                ?>
                            </p>

                        </div>
                        <div class="tab-pane" id="tab_step_2">
                            <p>
                            <div class="input-group choose-btn-group">
                                <div class="input-icon">
                                    <i class="fa fa-file fa-fw"></i>
                                    <input type="text" class="form-control btn-file" id="import_file_name" readonly="">
                                </div>
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        选择文件<input name="attachment" type="file" accept=".xls,.xlsx,.jpg">
                                    </span>
                                </span>
                            </div>
                            </p>
                        </div>
                    </div>
                    <input type="hidden" id="submit_type" name="submit_type" >
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