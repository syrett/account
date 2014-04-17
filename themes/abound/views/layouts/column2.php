<?php /* @var $this Controller */ ?>
<?php
 $this->beginContent('//layouts/main'); ?>

  <div class="row">
	<div class="col-md-3">
		<div class="sidebar-nav">
        
		  <?php $this->widget('zii.widgets.CMenu', array(
			/*'type'=>'list',*/
			'encodeLabel'=>false,
			'items'=>array(
				array('label'=>'<span class="glyphicon glyphicon-home"></span>  Dashboard <span class="label label-info pull-right">BETA</span>', 'url'=>array('/site/index'),'itemOptions'=>array('class'=>'')),
				array('label'=>'<span class="glyphicon glyphicon-search"></span> About this theme <span class="label label-danger pull-right">HOT</span>', 'url'=>'http://www.webapplicationthemes.com/abound-yii-framework-theme/'),
				array('label'=>'<span class="glyphicon glyphicon-th-list"></span> Messages <span class="badge pull-right">12</span>', 'url'=>'#'),
				// Include the operations menu
				//array('label'=>'OPERATIONS','items'=>$this->menu),
			),
			));?>
		</div>
        <!--
        <table class="table table-striped table-bordered">
          <tbody>
            <tr>
              <td width="50%">Bandwith Usage</td>
              <td>
              	<div class="progress progress-danger">
                  <div class="bar" style="width: 80%"></div>
                </div>
              </td>
            </tr>
            <tr>
              <td>Disk Spage</td>
              <td>
             	<div class="progress progress-warning">
                  <div class="bar" style="width: 60%"></div>
                </div>
              </td>
            </tr>
            <tr>
              <td>Conversion Rate</td>
              <td>
             	<div class="progress progress-success">
                  <div class="bar" style="width: 40%"></div>
                </div>
              </td>
            </tr>
            <tr>
              <td>Closed Sales</td>
              <td>
              	<div class="progress progress-info">
                  <div class="bar" style="width: 20%"></div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        -->
		<!--div class="well">
        
            <dl class="dl-horizontal">
              <dt>Account status</dt>
              <dd>$1,234,002</dd>
              <dt>Open Invoices</dt>
              <dd>$245,000</dd>
              <dt>Overdue Invoices</dt>
              <dd>$20,023</dd>
              <dt>Converted Quotes</dt>
              <dd>$560,000</dd>
              
            </dl>
      </div -->
		
    </div><!--/span-->
    <div class="col-md-9"> 
    <!-- Include content pages -->
    <?php echo $content; ?>

	</div><!--/span-->
  </div><!--/row-->


<?php $this->endContent(); ?>
