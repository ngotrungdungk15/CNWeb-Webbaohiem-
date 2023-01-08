<div class="row border-bottom" id="top-half">
    <div class="col-8 pt-1" id="banner">
        <img src="<?php echo $banner ?>" alt="" width='100%' height='98%'>
    </div>
    <div class="col-4 border-start" id="left-top-content">
        <?php
            //if logged in call function if not call LogIn form
            include_once("view/client/home/top-right.php");
        ?>
        <!--LogIn Form
            <div class="m-5" id="login-form">
                <h3 class="m5 text-center">Đăng nhập</h3>
                <form action="http://baohiem.test/api/user/login.php" class="form-outline" method="POST">
                    <div class="form-outline mb-4 mt-5">
                        <label class="form-label h6" for="userID">Tài khoản</label>
                        <input type="text" id="userID" name="userAccount" class="form-control" />
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label h6" for="password">Mật khẩu</label>
                        <input type="password" id="password" name="password" class="form-control" />
                    </div>
                    <div class="form-outline mb-4">
                        <input class="form-check-input" type="checkbox" value="" id="remember-password" />
                        <label class="form-check-label" for="remember-password">Ghi nhớ mật khẩu</label>
                    </div>
                    <div class="form-outline mb-4 d-flex justify-content-end">
                        <button class="btn btn-primary btn-block btn-lg" type="submit">Đăng nhập</button>
                    </div>
                    <hr>
                    <div class="form-outline mb-4 text-center">
                        <a href="#" class="">Chưa có tài khoản?</a>
                    </div>     
                </form>
            </div>
        -->

        <!--Function
            <div class="m-4" id="claim">
                <a href="" class="text-decoration-none text-reset">
                    <i class="fa-solid fa-clipboard-check fa-5x mb-4"></i>
                </a>
                <p class="h5"><a href="#" class="text-decoration-none text-reset">Giải quyết quyền lợi</a></p>
                <a href="" class="text-decoration-none text-reset">
                    <p>Yêu cầu giải quyết bồi thường bảo hiểm theo quyền lợi</p>
                </a>
                <a href="#" class="d-flex justify-content-start text-decoration-none text-reset">
                    <i class="fa-solid fa-circle-arrow-right fa-xl pt-2" style="color: red;"></i>
                </a>
            </div>
            <div class="m-4 border-top" id="payment">
                <a href="#" class="d-flex justify-content-start text-decoration-none text-reset">
                    <i class="fa-solid fa-credit-card fa-5x mb-4 pt-5"></i>
                </a>
                <p class="h5"><a href="#" class="text-decoration-none text-reset">Thanh toán trực tuyến</a></p>
                <a href="" class="text-decoration-none text-reset">
                    <p>Yêu cầu giải quyết bồi thường bảo hiểm theo quyền lợi</p>
                </a>
                <a href="#" class="d-flex justify-content-start text-decoration-none text-reset">
                    <i class="fa-solid fa-circle-arrow-right fa-xl pt-2" style="color: red;"></i>
                </a>
            </div>
        -->
    </div>
</div>
<script