<div class="container-fluid">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
            <div class="card mt-3">
                <?php
                    $productID= $_GET['productID'];
                    $option= array('productID'=>$productID);
                    $option= http_build_query($option);
                    $op= stream_context_create(array('http' => array(
                            'method' => "POST",
                            'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                            'content' => $option
                        )));

                    $json= file_get_contents('http://baohiem.test/api/product/readProductById.php', false, $op);
                    $j_son= json_decode($json, true);
                ?>
                <img src="<?php echo $j_son['BannerLink']; ?>" class="card-img-top" alt="..." height="400">
                <div class="card-body mx-5">
                    <div class="card-header">
                        <h5 class="card-title text-center"><?php echo $j_son['ProductName'].' - '.$j_son['ProductCode']; ?></h5>
                    </div>
                    <p class="card-text text-center mt-3 h6"><?php echo $j_son['ProductDescription']; ?></p>
                    <div class="row">
                        <div class="col-6">
                            <p class="card-text"><span class="h6">Giá trị: </span><?php echo $j_son['ProductValue']; ?> VND</p>
                            <p class="card-text">
                                <?php 
                                    switch($j_son['PeroidicPaymentType']){
                                        case 1: 
                                            $type= 'tháng';
                                        break;

                                        case 2: 
                                            $type= 'năm';
                                        break;
                                    }
                                ?>
                                <span class="h6">Phí định kỳ: </span> <?php echo $j_son['PeroidicPaymentFee'].'/'.$type; ?>
                            </p>
                            <p class="card-text"><span class="h6">Giá trị hoàn trả: </span> <?php echo $j_son['RefundValue']; ?> VND</p>
                            <p class="card-text"><span class="h6">Thời hạn: </span><?php echo $j_son['EffectiveTime'];?></p>
                        </div>
                        <div class="col-6">
                            <?php
                                $k= array('attSet'=>$j_son['AttributeSetId']);
                                $k= http_build_query($k);
                                $kk= stream_context_create(array('http' => array(
                                  'method' => "POST",
                                  'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                                  'content' => $k
                                )));
                                $j_k= file_get_contents("http://baohiem.test/api/product/attribute/readAttDetail.php", false, $kk);
                                $kx= json_decode($j_k, true);
                                foreach($kx as $att){
                                    $attID= array('att' => $att['attID']);
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
                                            $d= array('productID'=>$productID, 'attID'=>$att['attID']);
                                            $d= http_build_query($d);
                                            $dd= stream_context_create(array('http' => array(
                                            'method' => "POST",
                                            'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                                            'content' => $d
                                            )));
                                            $j_d= file_get_contents("http://baohiem.test/api/product/attribute/readValue.php", false, $dd);
                                            $kd= json_decode($j_d, true);
                                            foreach($kd as $k){
                                                if(isset($k['Value'])){
                                                    echo $k['Value'];
                                                }
                                                break;
                                            }
                                        ?>
                                    </p>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                    
                </div>
                <div class="card-footer text-end">
                    <a href="index.php?route=inrq&productID=<?php echo $productID; ?>" class="btn btn-danger">Yêu cầu bảo hiểm</a>
                </div>
            </div>
        </div>
        <div class="col-1"></div>
    </div>
</div>
<?php
    
?>