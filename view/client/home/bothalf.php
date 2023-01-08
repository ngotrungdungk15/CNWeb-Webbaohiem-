<?php
    include_once("controller/product.php");
    $p= new ProductC();
?>
<div class="row mb-3 mt-3" id="bot-half">
    <div id="hot-product" class="row row-cols-1">
        <!--Product-->
        <?php
            $limit= 4;
            $s= $p->showProductListLimit($limit);
            if($s){
                if(mysqli_num_rows($s)>0){
                    while($cot=mysqli_fetch_assoc($s)){
        ?>
                <div class="col-3" id="product">
                    <a href="index.php?route=productDetail&productID=<?php echo $cot['ProductID']; ?>" class="text-reset text-decoration-none card">
                        <div class="card-header">
                            <div class="card-title">
                                <span class="fw-bold"><?php echo $cot['ProductName']; ?></span>
                                <i class="fa-solid fa-circle-arrow-right fa-xl" style="color: red;"></i>
                            </div>
                        </div>
                        <div class="card-body">
                            <img src="<?php echo $cot['BannerLink']; ?>" alt="" class="img-fluid" >
                            <p class="card-text"><?php echo $cot['ProductDescription']; ?></p>
                        </div>
                    </a>
                </div>
        <?php
                    }
                }
            }   
        ?>
        <!--    
        <div class="col-3" id="product">
            <a href="#" class="text-reset text-decoration-none card">
                <div class="card-header">
                    <div class="card-title">
                        <p>Bảo hiểm trọn đời</p>
                        <span class="fw-bold">Hành trình hạnh phúc</span>
                        <i class="fa-solid fa-circle-arrow-right fa-xl" style="color: red;"></i>
                    </div>
                </div>
                <div class="card-body">
                    <i class="fa-solid fa-shield-heart fa-5x p-3"></i>
                    <p class="card-text">Xây dựng kế hoạch tài chính trọn đời, linh hoạt bảo vệ trên mọi hành trình của cuộc sống</p>
                </div>
            </a>
        </div>
        <div class="col-3" id="product">
            <a href="#" class="text-reset text-decoration-none card">
                <div class="card-header">
                    <div class="card-title">
                        <p>Bảo hiểm trọn đời</p>
                        <span class="fw-bold">Hành trình hạnh phúc</span>
                        <i class="fa-solid fa-circle-arrow-right fa-xl" style="color: red;"></i>
                    </div>
                </div>
                <div class="card-body">
                    <i class="fa-solid fa-shield-heart fa-5x p-3"></i>
                    <p class="card-text">Xây dựng kế hoạch tài chính trọn đời, linh hoạt bảo vệ trên mọi hành trình của cuộc sống</p>
                </div>
            </a>
        </div>
    </div>   -->
</div>