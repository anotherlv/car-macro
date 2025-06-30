
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>중고차 보험 매크로 관리자</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/public/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/public/dist/css/adminlte.min.css">
    <!-- jQuery -->
    <script src="/public/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/public/dist/js/adminlte.min.js"></script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <b>매크로 </b>관리자
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="user_id" placeholder="ID">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="password" class="form-control" id="user_password" placeholder="Password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- /.col -->
                <div class="col-12">
                    <button type="button" class="btn btn-primary btn-block" onclick="loginCheck()">로그인</button>
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->
<script>
    $(document).ready(function() {
        $("#user_id, #user_password").keydown(function(key) {
            if (key.keyCode == 13) {
                loginCheck();
            }
        });
    });

    function loginCheck(){
        var id          = $("#user_id").val();
        var password    = $("#user_password").val();

        if (id == ""){
            alert("아이디를 입력해 주세요.");
            return;
        }

        if (password == ""){
            alert("비밀번호를 입력해 주세요.");
            return;
        }

        $.ajax({
            url         : "/login/loginProcess",
            type        : "POST",
            dataType    : "JSON",
            data        : {"id" : id , "password" : password},
            success     : function(result) {
                if( result.status == "success" ){
                    location.href = "/";
                }else if( result.status == "use_fail" ){
                    alert("비활성화 아이디입니다.\r\n최고관리자에게 문의하여 주세요.");
                    return;
                }else{
                    alert("아이디 또는 비밀번호가 일치하지 않습니다.");
                    return;
                }
            }
        });

    }
</script>

</body>
</html>
