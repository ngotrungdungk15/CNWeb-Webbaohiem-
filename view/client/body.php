<?php
    $banner= "./img/bannertest.png";
    require_once("utilities/utility.php");
    include_once("controller/attSet.php");
    $attSet= new attSetC();
?>
<div class='container-fluid' id='body'>
    <div class='row'>
        <div class='col-sm-1 bg-light sticky-top border-end' id= "sidebar">
            <div class='sidebar-menu'>
                <ul class='nav nav-pills nav-flush flex-sm-column flex-row flex-nowrap mb-auto mx-auto text-center align-items-center'>
                    <li class='h6 dropend'>
                        <a href='' class='d-block pt-5 pb-2 link-dark text-decoration-none' data-bs-toggle='dropdown' aria-expanded='false'>
                            <i class='fa-solid fa-box-open'></i>
                            <span>Sản phẩm</span>
                        </a>
                        <ul class= 'dropdown-menu'>
                            <?php
                                $a= $attSet->showAttSet();
                                if($a){
                                    if(mysqli_num_rows($a)>0){
                                        while($r= mysqli_fetch_assoc($a)){
                            ?>  
                                            <li class='dropdown-item'><a class='text-decoration-none text-reset' href='index.php?route=category&attSet=<?php echo $r['AttributeSetId']; ?>'><?php echo $r['AttributeSetName']; ?></a></li>
                            <?php
                                        }
                                    }
                                }
                            ?>                          
                        </ul>
                    </li>
                    <li class='h6'>
                        <a href='#servicelist' class='d-block pt-5 pb-2 link-dark text-decoration-none' data-bs-toggle='collapse' aria-expanded='false' aria-controls='servicelist'>
                            <i class='fa-solid fa-file-circle-question'></i>
                            <span>Dịch vụ</span>
                        </a>
                        <div class='collapse' id='servicelist'>
                            <ul class= 'list-group'>
                                <li class='list-group-item'><a class='text-decoration-none text-reset' href='?route=BenefitSolve'>Giải quyết quyền lợi</a></li>
                                <li class='list-group-item'><a class='text-decoration-none text-reset' href='#'>Điều chỉnh hồ sơ</a></li>
                                <li class='list-group-item'><a class='text-decoration-none text-reset' href='?route=contracts'>Thanh lý hợp đồng</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class='h6'>
                        <a href='#filelist' class='d-block pt-5 pb-2 link-dark text-decoration-none' data-bs-toggle='collapse' aria-expanded='false' aria-controls='filelist'>
                            <i class='fa-solid fa-folder-open'></i>
                            <span>Hồ sơ</span>
                        </a>
                        <div class='collapse' id='filelist'>
                            <ul class= 'list-group'>
                                <li class='list-group-item'><a class='text-decoration-none text-reset' href='?route=file'>Danh sách hồ sơ</a></li>
                                <li class='list-group-item'><a class='text-decoration-none text-reset' href='#'>Điều chỉnh hồ sơ</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class='h6'>
                        <a href='?route=contracts' class='d-block pt-5 pb-2 link-dark text-decoration-none'>
                            <i class='fa-solid fa-file-contract'></i>
                            <span>Hợp đồng</span>
                        </a>
                    </li>
                    <li class='h6'>
                        <a href='index.php?route=payment' class='nav-link pt-5 pb-2 link-dark'>
                            <i class='fa-brands fa-cc-visa'></i>
                            <span>Thanh toán online</span>
                        </a>
                    </li>
                    <li class='h6'>
                        <a href='index.php?route=peroidPayment' class='nav-link pt-5 pb-2 link-dark'>
                            <i class='fa-brands fa-cc-visa'></i>
                            <span>Lich Thanh toán</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class='col-lg-11' id="content">
            <?php
                $route= getGET('route');
                switch ($route) {
                    case "login":
                        include_once("./view/client/authen/login.php");
                    break;

                    case "register":
                        include_once("./view/client/authen/register.php");
                    break;

                    case "profile":
                        include_once("./view/client/authen/accountDetail.php");
                    break;

                    case "insuranceRq":
                        include_once("./view/client/service/insurancerequest.php");
                    break;

                    case "category":
                        include_once("./view/client/product/productSet.php");
                    break;

                    case "productDetail":
                        include_once("./view/client/product/productDetail.php");
                    break;

                    case "inrq":
                        include_once("./view/client/service/insurancerequest.php");
                    break;

                    case "payment":
                        include_once("./view/client/payment/paymentList.php");
                    break;

                    case "file":
                        include_once("./view/client/file/fileList.php");
                    break;

                    case "contracts":
                        include_once("./view/client/contract/contractList.php");
                    break;

                    case "peroidPayment":
                        include_once("./view/client/payment/peroidPayment.php");
                    break;

                    case "contractDetail":
                        include_once("./view/client/contract/contractDetail.php");
                    break;

                    case "changePassword":
                        include_once("./view/client/authen/changePass.php");
                    break;

                    case "thanku":
                        include_once("./view/client/other/thanku.php");
                    break;

                    case "thanku2":
                        include_once("./view/client/other/thanku2.php");
                    break;

                    case "fileInfo":
                        include_once("./view/client/file/fileInfo.php");
                    break;

                    case "BenefitSolve":
                        include_once("./view/client/service/SolveBenefitRequest.php");
                    break;

                    case "BenefitRequest":
                        include_once("./view/client/service/CreateBenefitRequest.php");
                    break;

                    case "cancelContract":
                        include_once("./view/client/contract/cancelContract.php");
                    break; 
                    
                    default:
                        include_once("./view/client/home/tophalf.php");
                        echo '<hr>';
                        include_once("./view/client/home/bothalf.php");
                }
            ?>
        </div>
    </div>
</div>