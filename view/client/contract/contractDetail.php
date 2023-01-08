<div class="container-fluid">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
            <div class="card mt-3">
                <?php
                    $ContractID= $_GET['id'];
                    $option= array('ContractID'=>$ContractID);
                    $option= http_build_query($option);
                    $op= stream_context_create(array('http' => array(
                            'method' => "POST",
                            'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                            'content' => $option
                        )));

                    $Cjson= file_get_contents('http://baohiem.test/api/contract/readContractByID.php', false, $op);
                    $Cj_son= json_decode($Cjson, true);
                ?>

                <?php
                    $option= array('productID'=>$Cj_son['ProductID']);
                    $option= http_build_query($option);
                    $op= stream_context_create(array('http' => array(
                            'method' => "POST",
                            'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                            'content' => $option
                        )));

                    $Pjson= file_get_contents('http://baohiem.test/api/product/readProductById.php', false, $op);
                    $Pj_son= json_decode($Pjson, true);
                ?>
                    <section class="content mb-5 mt-5">
                        <div class="container-fluid">
                            <div class="row">
                            <div class="col-12">
                                <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Chi tiết hợp đồng</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <!-- thông tin chung -->
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="card-text"><span class="h6">Mã hợp đồng </span>
                                                    <?php echo $Cj_son['ContractCode']; ?>
                                                </p>
                                                <p class="card-text"><span class="h6">Tên hợp đồng </span>
                                                    <?php echo $Pj_son['ProductName'].' - '.$Pj_son['ProductCode']; ?>
                                                </p>
                                                <p class="card-text"><span class="h6">Ngày hiệu lực </span> 
                                                    <?php echo $Cj_son['EffectiveDate']; ?>
                                                </p>
                                                <p class="card-text"><span class="h6">Ngày hết hạn</span>
                                                    <?php echo $Cj_son['ExpireDate']; ?>
                                                </p>
                                                <p class="card-text"><span class="h6">Giá trị hợp đồng</span>
                                                    <?php echo $Cj_son['ContractValue'].' VND'; ?>
                                                </p>
                                                <p class="card-text"><span class="h6">Giá trị hoàn trả</span>
                                                    <?php echo $Cj_son['RefundValue'].' VND'; ?>
                                                </p>
                                                <p class="card-text"><span class="h6">Loại thanh toán</span>
                                                    <?php echo $Cj_son['PeroidicPaymentType']; ?>
                                                </p>
                                                <p class="card-text"><span class="h6">Phí thanh toán</span>
                                                    <?php echo $Cj_son['PeroidicPaymentFee'].' VND'; ?>
                                                </p>
                                                <p class="card-text"><span class="h6">Ngày hủy hợp đồng</span>
                                                    <?php echo $Cj_son['CancelDate']; ?>
                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <p class="card-text"><span class="h6">Các điều khoản</span>
                                                    <br>
                                                    <?php 
                                                        $term= unserialize($Cj_son['Term']);
                                                        //print_r($term);
                                                        foreach($term as $r){
                                                                $attID= array('att' => $r['attID']);
                                                                $attID= http_build_query($attID);
                                                                $attIDPost = stream_context_create(array('http' => array(
                                                                    'method' => "POST",
                                                                    'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                                                                    'content' => $attID
                                                                )));
                                                                $attJson = 'http://baohiem.test/api/product/attribute/showAtt.php';
                                                                $attX = file_get_contents($attJson, false, $attIDPost);
                                                                $res= json_decode($attX, true);
                                                            ?>    
                                                                <span class="h5"><?php echo $res['attName']; ?></span>
                                                                <p>
                                                                    <?php
                                                                        $d= array('productID'=>$Cj_son['ProductID'], 'attID'=>$r['attID']);
                                                                        $d= http_build_query($d);
                                                                        $dd= stream_context_create(array('http' => array(
                                                                        'method' => "POST",
                                                                        'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                                                                        'content' => $d
                                                                        )));
                                                                        $j_d= file_get_contents("http://baohiem.test/api/product/attribute/readValue.php", false, $dd);
                                                                        //print_r($j_d);
                                                                        $kd= json_decode($j_d, true);
                                                                        foreach($kd as $k){
                                                                            if(isset($k['Value'])){
                                                                                echo $k['Value'];
                                                                            } else{
                                                                                echo '';
                                                                            }
                                                                            break;
                                                                        }
                                                                    ?>
                                                                </p>
                                                        <?php
                                                            }
                                                        ?>
                                                </p>
                                                <a href="?route=cancelContract&id=<?php echo $ContractID;?>" class="btn btn-danger">Hủy hợp đồng</a>
                                            </div>
                                        </div>  

                        <!-- bảng theo dõi thanh toán -->
                                <h3 class="card-title">Các kỳ thanh toán</h3>
                                <table id="list" class="table table-bordered table-hover">
                                    <thead class="text-center">
                                        <tr>
                                            <th>Mã định kỳ</th>
                                            <th>Mã hợp đồng</th>
                                            <th>Kỳ thứ</th>
                                            <th>Hạn thanh toán</th>
                                            <th>Số tiền cần thanh toán (VNĐ)</th>
                                            <th>Thanh toán</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php
                                            $PPjson= file_get_contents('http://baohiem.test/api/peroidicPayment/readPeroidicPayment.php');
                                            $PPj_son= json_decode($PPjson, true);
                                            //print_r($PPj_son);
                                            //echo $PPj_son['PerodicPaymentID'];

                                            // print_r ($contractArray);

                                            if($PPj_son!=null){
                                                    foreach($PPj_son as $ro){
                                                        //echo $ro['ContractID'];
                                                    if($ro['ContractID']== $Cj_son['ContractID'] ){
                                                        ?>
                                                        <tr>
                                                            <form action="" method="POST">
                                                                <td>
                                                                    <?php echo $ro['PerodicPaymentID']; ?>
                                                                    <input type="hidden" name="PerodicPaymentID" value="<?php echo $ro['PerodicPaymentID']; ?>">
                                                                </td>
                                                                <td>
                                                                    <?php echo $Cj_son['ContractCode']?>
                                                                </td>
                                                                <td>
                                                                    <?php 
                                                                        echo $ro['Stage']; 
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $ro['NextStageDate'] ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $ro['Fee']; ?>
                                                                    <input type="hidden" name="Fee" value="<?php echo $ro['Fee']; ?>">
                                                                </td>
                                                                <td>
                                                                    <?php if($ro['Status']==0){
                                                                        echo 'Chưa thanh toán';
                                                                    }
                                                                    elseif($ro['Status']==1) {
                                                                        echo 'Đã thanh toán';
                                                                    } else{
                                                                        echo 'Đã hủy';
                                                                    }
                                                                      ?>
                                                                    <input type="hidden" name="Fee" value="<?php echo $ro['Fee']; ?>">
                                                                </td>
                                                            </form>
                                                        </tr>
                                            <?php
                                                    }
                                                }

                                                }
                                            
                                        
                                            
                                            ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            </div>
                        </div>
                        </div>
                    </div>
                    </section>
            </div>
        </div>
        <div class="col-1"></div>
    </div>
</div>
<?php
    
?>