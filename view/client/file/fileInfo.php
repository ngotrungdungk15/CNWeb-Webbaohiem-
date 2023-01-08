<div class="container-fluid">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
            <div class="card mt-3">
                <?php
                    $FileID= $_GET['fileID'];
                    $option= array('FileID'=>$FileID, 'token' => $_COOKIE['token']);
                    $option= http_build_query($option);
                    $op= stream_context_create(array('http' => array(
                            'method' => "POST",
                            'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                            'content' => $option
                        )));

                    $Cjson= file_get_contents('http://baohiem.test/api/file/readFileByFileID.php', false, $op);
                    $Cj_son= json_decode($Cjson, true);
                ?>

                    <section class="content mb-5 mt-5">
                        <div class="container-fluid">
                            <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Chi tiết hồ sơ</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <!-- thông tin chung -->
                                            <div class="row">
                                                <div class="col-6">
                                                    <p class="card-text"><span class="h6">Mã hồ sơ </span>
                                                        <?php echo $Cj_son['FileCode']; ?>
                                                    </p>
                                                    <p class="card-text"><span class="h6">Mã Khách hàng </span>
                                                        <?php echo $Cj_son['CustomerID']; ?>
                                                    </p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="card-text"><span class="h6">Tên hồ sơ </span>
                                                        <?php echo $Cj_son['FileName']; ?>
                                                    </p>
                                                    <p class="card-text"><span class="h6">Ngày tạo hồ sơ </span> 
                                                        <?php echo $Cj_son['CreateDate']; ?>
                                                    </p>
                                                </div>
                                            </div>  

                                        <!-- bảng theo dõi thanh toán -->
                                            <h3 class="card-title">Hợp đồng</h3>
                                            <?php 
                                                $contractJson= file_get_contents("http://baohiem.test/api/contract/readContract.php", false);
                                                //print_r($contractJson);
                                                $contract= json_decode($contractJson, true);
                                                if($contract!=null){
                                                    foreach($contract as $row){
                                                        if($row['Status']==1 && $row['FileID']==$FileID)
                                                        {
                                                            ?>
                                                            <a href="?route=contractDetail&id=<?php echo $row['ContractID']; ?>" class="btn btn-primary m-1">Mã hợp đồng: <?php echo $row['ContractCode']; ?></a>
                                                            <?php
                                                        }
                                                    }
                                                }
                                            ?>
                                    
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