<?php
    $ContractID= $_GET['id'];
    $contractID= array('ContractID'=>$ContractID);
    $contractID= http_build_query($contractID);
    $contractHeader= stream_context_create(array('http' => array(
            'method' => "POST",
            'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
            'content' => $contractID
        )));

    $contract= file_get_contents('http://baohiem.test/api/contract/readContractByID.php', false, $contractHeader);
    $contract_json= json_decode($contract, true);
?>
<form action="" method="post" class="mt-3">
    <div class="card text-center">
      <div class="card-header ">
        <h4 class="card-title">
            Yêu cầu thanh lý hợp đồng
        </h4>
      </div>
      <div class="card-body">
        <div class="form-group">
            <h6>Mã hợp đồng</h6>
            <input type="text" name="contractCode" id="contractCode" disabled value="<?php echo $contract_json['ContractCode']; ?>">
        </div>
        <div class="form-group mt-2">
            <h6>
                <label for="reason">
                    Lý do
                </label> 
            </h6>
            <textarea name="reason" id="reason" cols="30" rows="10" required></textarea>
        </div>
        <div class="form-group mt-2">
            <input type="submit" value="Gửi" name="btn" class="btn btn-success">
        </div>
      </div>
    </div>
</form>
<?php
    if(isset($_POST['btn'])){ 
        $info= array('contractID'=>$ContractID, 'reason'=>$_POST['reason']);
        $info= http_build_query($info);
        $infoHeader= stream_context_create(array('http' => array(
                'method' => "POST",
                'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                'content' => $info
            )));
        $rq= file_get_contents('http://baohiem.test/api/contract/cancelContractRq.php', false, $infoHeader);
        $rq_json= json_decode($rq, true);
        if($rq_json['status']==1){
?>
            <script>
                window.location.href= "index.php?route=contracts";
            </script>
<?php
        }
    }
?>