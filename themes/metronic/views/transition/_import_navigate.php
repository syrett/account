<div class="col-xs-12">
    <div class="col-md-4 col-sm-12">
        <div class="form-group">
            <div class="input-group choose-btn-group">
                <div class="input-icon">
                    <i class="fa fa-file fa-fw"></i>
                    <input type="text" class="form-control btn-file" id="import_file_name" readonly="">
                </div>
					<span class="input-group-btn">
						<span class="btn btn-default btn-file">
							选择文件<input name="attachment" type="file" accept=".xls,.xlsx">
						</span>
					</span>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="btn-toolbar margin-bottom-10">
            <input type="hidden" id="submit_type" name="submit_type" value="import">
            <button onclick="javascript:$('#submit_type').val('import');$('#form').submit();" class="btn btn-default btn-file">导入</button>
            <a download="" href="/download/<?= Yii::t('import', strtoupper($type)) ?>.xlsx">
                <button class="btn btn-default btn-file" type="button">模板下载
                </button>
            </a>
            <?
            if ($type == 'salary') {
                echo "<button type='submit' class='btn btn-default btn-file' name='type' value='load'>提取工资数据</button>";
            }

            ?>
        </div>
    </div>
</div>