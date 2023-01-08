<div class="row container-fluid mt-5 mb-5">
    <div class="col-3">
        <?php
             require_once("utilities/utility.php");
             $attSet= getGET('attSet');
             $option= array('attSet'=>$attSet);
             $option= http_build_query($option);
 
             $options = stream_context_create(array('http' => array(
                 'method' => "POST",
                 'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                 'content' => $option
             )));
             $json_r= file_get_contents('http://baohiem.test/api/product/attribute/showAttSet.php', true, $options);
             $r= json_decode($json_r, true);
        ?>
            <h2><?php echo $r['attName']; ?></h2>
    </div>
    <div class="col-8" id="product">
        <?php
            $json_res= file_get_contents('http://baohiem.test/api/product/readProductBySet.php', true, $options);
            $res= json_decode($json_res, true);
            if(!isset($res['status'])){
                foreach($res as $r){
        ?>
            <a href="index.php?route=productDetail&productID=<?php echo $r['ProductID']; ?>" class="card text-decoration-none text-reset mb-4">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="<?php echo $r['BannerLink']; ?>" alt="" class="img-fluid rounded-start">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $r['ProductName']; ?></h4>
                            <p class="card-text"><?php echo $r['ProductDescription']; ?></p>
                            <span class="h6">Xem thêm</span><i class="fa-solid fa-circle-arrow-right fa-xl px-2" style="color: red;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <p class="card-text text-end"><small class="text-muted"><?php echo $r['ProductCode']; ?></small></p> 
                </div>
            </a>
        <?php
                }
            } else{
        ?>
                <h2>Không có gói bảo hiểm nào</h2>
        <?php
            }
        ?>
    </div>
    <div class="col-1"></div>
</div>