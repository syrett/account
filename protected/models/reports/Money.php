<?php

//现金流量表
class Money extends CModel
{

    public $date; //报表年月日 20140301
    public $is_closed = 0; //是否查询已经或未结账的

    public function attributeNames()
    {
        array();
    }

    public function genMoneyData($date='',$type='')
    {
        $date = $date==''?$this->date:$date;
        $key = 0;
        $data = [];

        $model = new Balance();
        $model->is_closed=1;
        $model->date = $date;
        $data_2 = $model->genBalanceData();
        $model = new Profit();
        $model->date = $date;
        $data_3 = $model->genProfitData();
        while($key++<83){
            $data[$key]["end"] = 0;
            switch($key){
                case 1: //出售商品、提供劳务收到的现金
                    $data = $this->normal($date,$data,$key,'销售收入',$type);
                    break;
                case 3:     //税费返还
                    $data = $this->normal($date,$data,$key,['税收返还','收入'],$type);
                    break;
                case 8:     //收到的其他与经营活动有关的现金
                    $data = $this->normal($date,$data,$key,['收到押金','收入'],$type);
                    $data = $this->normal($date,$data,$key,['材料销售','收入'],$type);
                    $data = $this->normal($date,$data,$key,['技术转让','收入'],$type);
                    $data = $this->normal($date,$data,$key,['资产租赁','收入'],$type);
                    $data = $this->normal($date,$data,$key,['利息收入','收入', '利息费用'],$type);
                    $data = $this->normal($date,$data,$key,['利息收入','收入', '手续费'],$type);
//                    $temp2 = $this->normal($date,$data,$key,'利息收入',$type);
                    $data = $this->normal($date,$data,$key,'收回借款',$type);
                    break;
                case 9:
                    $data[$key]["end"] = $data[1]["end"]+$data[3]["end"]+$data[8]["end"];
                    break;
                case 10:     //购买商品、接受劳务支付的现金
                    $array = $this->getArray('供应商采购',$date,$type);
                    if(!empty($array))
                        foreach ($array as $item) {
                            $path = explode('=>', $item['path']);
                            if($path['2']=='供应商采购'){
                                $end = 0;
                                $last_path = end($path);
                                if($last_path=='预付款'){
                                    $type = substr($item['order_no'],0,2)=='BA'?'bank':'cash';
                                    $porder = Preparation::model()->findByAttributes(['pid'=>$item['id'],'type'=>$type]);
                                    $orders = json_decode($porder['real_order']);
                                    if($orders)
                                        foreach ($orders as $order_no) {
                                            $order = Purchase::model()->findByAttributes(['order_no'=>$order_no]);
                                            //除去经营活动才算
                                            if(in_array(substr($order['subject'],0,4),['1403','1405']))
                                                $end += $item['amount'];
                                        }
                                    else
                                        $end += $item['amount'];
                                }else{
                                    $order = Purchase::model()->findByAttributes(['order_no'=>$last_path]);
                                    //除去经营活动才算
                                    if(in_array(substr($order['subject'],0,4),['1403','1405']))
                                        $end = $item['amount'];
                                }
                                $data[$key]["end"] += round2($end);
                            }
                        }
                    break;
                case 12:     //支付给职工以及为职工支付的现金
                    $data = $this->normal($date,$data,$key,'工资社保',$type);
                    break;
                case 13:
                    $data = $this->normal($date,$data,$key,['支出','支付税金']);
                    break;
                case 18:     //支付的其他与经营活动有关的现金
                    $array = $this->getArray('供应商采购',$date,$type);
                    if(!empty($array))
                        foreach ($array as $item) {
                            $path = explode('=>', $item['path']);
                            if($path['2']=='供应商采购'){
                                $end = 0;
                                //根据预收或单号，判断是否含税
                                $last_path = end($path);
                                if($last_path=='预付款'){
                                    $type = substr($item['order_no'],0,2)=='BA'?'bank':'cash';
                                    $porder = Preparation::model()->findByAttributes(['pid'=>$item['id'],'type'=>$type]);
                                    $orders = json_decode($porder['real_order']);
                                    if($orders)
                                        foreach ($orders as $order_no) {
                                            $order = Purchase::model()->findByAttributes(['order_no'=>$order_no]);
                                            //除去销售主营业务收入才算
                                            if(!in_array(substr($order['subject'],0,4),['1403','1405','1601','1604','1701','1801']))
                                                $end += $item['amount'];
                                        }
                                }else{
                                    $order = Purchase::model()->findByAttributes(['order_no'=>$last_path]);
                                    //除去销售主营业务收入才算
                                    if(!in_array(substr($order['subject'],0,4),['1403','1405','1601','1604','1701','1801']))
                                        $end = $item['amount'];
                                }
                                $data[$key]["end"] += round2($end);
                            }
                        }
                    $data = $this->normal($date,$data,$key,['支付押金']);
                    $data = $this->normal($date,$data,$key,['借出款项']);
                    $data = $this->normal($date,$data,$key,['员工报销']);
                    $data = $this->normal($date,$data,$key,['支出','材料销售']);
                    $data = $this->normal($date,$data,$key,['支出','技术转让']);
                    $data = $this->normal($date,$data,$key,['支出','资产租赁']);
                    break;
                case 20:
                    $data[$key]["end"] = $data[10]["end"]+$data[12]["end"]+$data[13]["end"]+$data[18]["end"];
                    break;
                case 21:
                    $data[$key]["end"] = $data[9]["end"]-$data[20]["end"];
                    break;
                case 22:     //收回投资所收到的现金
                    $array = $this->getArray('收回投资',$date,$type);
                        if(!empty($array))
                            foreach ($array as $item) {
                                $end = 0;
                                $path = explode('=>', $item['path']);
                                if($path['2']=='收到还款' && $path['3']=='收回投资'){
                                    $end = $item['amount'];
                                }
                                $data[$key]["end"] += round2($end);
                            }
                    break;
                case 23:     //取得投资收益所收到的现金
                    $array = $this->getArray('投资收益',$date,$type);
                        if(!empty($array))
                            foreach ($array as $item) {
                                $end = 0;
                                $path = explode('=>', $item['path']);
                                if($path['2']=='投资收益'){
                                    $end = $item['amount'];
                                }
                                $data[$key]["end"] += round2($end);
                            }
                    break;
                case 25:     //处置固定资产、无形资产和其他长期资产所收回的现金净额  todo::
                    $data[$key]["end"] = 0;
                    break;
                case 28:     //    收到的其他与投资活动有关的现金
                    $data[$key]["end"] = 0;
                    break;
                case 29:
                    $data[$key]["end"] = $data[22]["end"]+$data[23]["end"]+$data[25]["end"]+$data[28]["end"];
                    break;
                case 30:     //    购建固定资产、无形资产和其他长期资产所支付的现金
                    $array = $this->getArray('供应商采购',$date,$type);
                    if(!empty($array))
                        foreach ($array as $item) {
                            $path = explode('=>', $item['path']);
                            if($path['2']=='供应商采购'){
                                $end = 0;
                                //根据预收或单号，判断是否含税
                                $last_path = end($path);
                                if($last_path=='预付款'){
                                    $type = substr($item['order_no'],0,2)=='BA'?'bank':'cash';
                                    $porder = Preparation::model()->findByAttributes(['pid'=>$item['id'],'type'=>$type]);
                                    $orders = json_decode($porder['real_order']);
                                    if($orders)
                                        foreach ($orders as $order_no) {
                                            $order = Purchase::model()->findByAttributes(['order_no'=>$order_no]);
                                            //长期资产才算
                                            if(in_array(substr($order['subject'],0,4),['1403','1405','1601','1604','1701','1801']))
                                                $end += $item['amount'];
                                        }
                                }else{
                                    $order = Purchase::model()->findByAttributes(['order_no'=>$last_path]);
                                    //长期资产才算
                                    if(in_array(substr($order['subject'],0,4),['1403','1405','1601','1604','1701','1801']))
                                        $end = $item['amount'];
                                }
                                $data[$key]["end"] += round2($end);
                            }
                        }
                    break;
                case 31:     //投资所支付的现金
                    $data = $this->normal($date,$data,$key,'投资支出',$type);
                    break;
                case 35:     //支付的其他与投资活动有关的现金 todo
                    $data[$key]["end"] = 0;
                    break;
                case 36:
                    $data[$key]["end"] = $data[30]["end"]+$data[31]["end"]+$data[35]["end"];
                    break;
                case 37:
                    $data[$key]["end"] = $data[29]["end"]-$data[36]["end"];
                    break;
                case 38:     //吸收投资所收到的现金
                    $data = $this->normal($date,$data,$key,'股东投入',$type);
                    break;
                case 40:     //借款所收到的现金
                    $data = $this->normal($date,$data,$key,'收到借款',$type);
                    break;
                case 43:     //收到的其他与筹资活动有关的现金
                    break;
                case 44:
                    $data[$key]["end"] = $data[38]["end"]+$data[40]["end"]+$data[43]["end"];
                    break;
                case 45:     //偿还债务所支付的现金
                    $data = $this->normal($date,$data,$key,'归还借款',$type);
                    break;
                case 46:     //分配股利、利润或偿付利息所支付的现金
                    $data = $this->normal($date,$data,$key,'利息手续费',$type);
//                    $temp2 = $this->normal($date,$data,$key,'利息收入',$type);
//                    $data[$key]["end"] = $temp1[46]["end"]-$temp2[46]["end"];
                    break;
                case 52:     //支付的其他与筹资活动有关的现金
                    $data = $this->normal($date,$data,$key,'利息手续费',$type);
                    break;
                case 53:
                    $data[$key]["end"] = $data[45]["end"]+$data[46]["end"]+$data[52]["end"];
                    break;
                case 54:
                    $data[$key]["end"] = $data[44]["end"]-$data[53]["end"];
                    break;
                case 55:
                    $temp1 = $this->normal($date,$data,$key,'汇兑收益',$type);
                    $temp2 = $this->normal($date,$data,$key,'汇兑损益',$type);
                    $data[$key]["end"] = $temp1[55]["end"]-$temp2[55]["end"];
                    break;
                case 56:
                    $data[$key]["end"] = $data[21]["end"]+$data[37]["end"]+$data[54]["end"]+$data[55]["end"];
                    break;
                case 57:        //    净利润
                    $data = $this->normal2($data,$key, $data_2, 53);break;
                case 58:        //  todo  加：计提的资产减值准备
                $data[$key]["end"] = 0;
                    break;
                case 59:        //            固定资产折旧
                    $data = $this->normal2($data,$key, $data_2, 22, 1);
                    $data[$key]['end'] = -$data[$key]['end'];
                    break;
                case 60:        //            无形资产摊销
                    $data = $this->normal2($data,$key, $data_2, 71);
                    $data[$key]['end'] = -$data[$key]['end'];break;
                case 61:            //长期待摊费用摊销
                    $data[$key]["end"] = 0;
                    break;
                case 64:        //            待摊费用减少（减：增加）
                    $data = $this->normal2($data,$key, $data_2, 29);break;
                case 65:        //      todo      预提费用增加（减：减少）
                    $data[$key]["end"] = 0;
                    break;
                case 66:        //处置固定资产、无形资产和其他长期资产的损失（减：收益）
                    $data = $this->normal3($data,$key, $data_3, 67, $type);break;
                case 67:        //固定资产报废损失
                    $data[$key]["end"] = 0;
                    break;
                case 68:        //财务费用
                    $data = $this->normal3($data,$key, $data_3, 63, $type);break;
                case 69:        //投资损失（减：收益）
                    $data = $this->normal3($data,$key, $data_3, 58, $type);break;
                case 70:        //递延税款贷项（减：借项）
                    $temp1 = $this->normal2($data,$key, $data_2, 30);
                    $temp2 = $this->normal2($data,$key, $data_2, 48);
                    $data[$key]['end'] = $temp2[$key]['end'] - $temp1[$key]['end'];
                    break;
                case 71:        //存货的减少（减：增加）
                    $data = $this->normal2($data,$key, $data_2, 11);
                    $data[$key]['end'] = -$data[$key]['end'];
                    break;
                case 72:        //经营性应收项目的减少（减：增加）
                    $temp_arr = [2,3,4,5,6,7,8];
                    $start = 0;
                    $end = 0;
                    foreach ($temp_arr as $item) {
                        $start += $data_2[$item]['start'];
                        $end += $data_2[$item]['end'];
                    }
                    $data[$key]['end'] = $start - $end;
                    break;
                case 73:        //经营性应付项目的增加（减：减少）
                    $item = 31;
                    $start = 0;
                    $end = 0;
                    while($item++ < 41) {
                        $start += $data_2[$item]['start'];
                        $end += $data_2[$item]['end'];
                    }
                    $data[$key]['end'] = $end - $start;
                    break;
                case 74:        //其他
                    $start = $data[21]['end'];
                    $end = 0;
                    $item = 56;
                    while($item++ <= 73) {
                        $end += isset($data[$item])?$data[$item]['end']:0;
                    }
                    $data[$key]['end'] = $start - $end;
                    break;
                case 75:        //经营活动产生的现金流量净额
                    $end = 0;
                    $item = 56;
                    while($item++ <= 74) {
                        $end += $data[$item]['end'];
                    }
                    $data[$key]['end'] = $end;
                    break;
                case 76:        //   债务转为资本
                    $data[$key]["end"] = 0;
                    break;
                case 77:        //   一年内到期的可转换公司债券
                    $data[$key]["end"] = 0;
                    break;
                case 78:        //   融资租入固定资产
                    $data[$key]["end"] = 0;
                    break;
                case 79:        //   现金的期末余额
                    $data = $this->normal2($data,$key, $data_2, 1, 'end');break;
                case 80:        //   减：现金的期初余额
                    $data = $this->normal2($data,$key, $data_2, 1, 'start');break;
                case 81:        //   加：现金等价物的期末余额
                    $data[$key]["end"] = 0;
                    break;
                case 82:        //   减：现金等价物的期初余额
                    $data[$key]["end"] = 0;
                    break;
                case 83:        //   现金及现金等价物净增加额
                    $data[$key]["end"] = $data[79]["end"] + $data[81]["end"] - $data[80]["end"]- $data[82]["end"];
                    break;

            }

        }
        return $data;
    }

    public function getArray($key,$date,$type='month'){
        if($type=='month'){     //月
            $sdate = substr($date,0,6);
            $date01 = '01';
            $lastdate = date("Ymt", strtotime($date));
            $condition = "date >= '$sdate$date01' and date <=$lastdate";
        }else{      //年
            $sdate = substr($date,0,4);
            $date01 = '01';
            $lastdate = date("Y12t", strtotime($date));
            $condition = "date >= '$sdate$date01$date01' and date <=$lastdate";
        }
//        $condition = '1=1';
        if(!is_array($key))
            $condition .= " and path like '%$key%'";
        else{
            foreach ($key as $item) {
                $condition .= " and path like '%$item%'";
            }
        }
        if($date==''){
            $array = Bank::model()->findAllByAttributes([], $condition);
            $array += Cash::model()->findAllByAttributes([], $condition);
        }else {
            $array = Bank::model()->findAllByAttributes([], $condition);
            $array += Cash::model()->findAllByAttributes([], $condition);
        }
        return $array;
    }

    public function normal($date, $data, $key, $option, $type='month'){
        $array = $this->getArray($option,$date,$type);
        if(!empty($array))
            foreach ($array as $item) {
                $end = 0;
                $path = explode('=>', $item['path']);
                if(is_array($option) && in_array($path['2'],$option))
                    $end = $item['amount'];
                elseif($path['2']==$option)
                    $end = $item['amount'];
                $data[$key]["end"] += round2($end);
            }
        return $data;
    }

    public function normal2($data, $key1, $data_2, $key2, $type=1){
        $data[$key1]["end"] = isset($data[$key1]["end"])?$data[$key1]["end"]:0;
        if($type==1)    //期末-年初
            $data[$key1]["end"] += $data_2[$key2]["end"]-$data_2[$key2]["start"];
        else
            $data[$key1]["end"] += $data_2[$key2][$type];

        return $data;
    }
    public function normal3($data, $key1, $data_2, $key2, $type='month'){
        $data[$key1]["end"] = isset($data[$key1]["end"])?$data[$key1]["end"]:0;
        $data[$key1]["end"] += $type=='year'?$data_2[$key2]["sum_year"]:$data_2[$key2]["sum_month"];

        return $data;
    }
}

