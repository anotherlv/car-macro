<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-body">
                        <div>
                            <div class="row flex_end">
                                <button type="button" class="btn btn-secondary mr15" onclick="history.back();">취소</button>
                                <button type="button" class="btn btn-primary mr15" onclick="updateProcess();">수정</button>
                            </div>
                        </div>
                        <input type="hidden" id="idx" value="<?=$idx?>" />
                        <div class="form-group row">
                            <label for="title" class="col-sm-2 col-form-label">인증번호</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="auth_number" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="<?=$result["auth_number"]?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="btn_support_img" class="col-sm-2 col-form-label">차량 앞 이미지</label>
                            <div class="col-sm-10">
                                <div class="img_div_wrap">
                                    <span class="img_span_wrap">
                                        <input type="file" id="car_img_1_file" name="car_img_1_file" class="img_file" />
                                        <a href="javascript:imageAdd('car_img_1');"><img src="/public/images/add_photo.jpg" alt="" class="margin"></a>
                                    </span>
                                    <ul class="ul_img" id="car_img_1">
                                        <?if( !empty($result["car_img_1_path"]) ):?>
                                            <li>
                                                <div class="img">
                                                    <div class="btn_delete">
                                                        <a onclick="if(confirm('삭제 하시겠습니까?')){$(this).parent().parent().parent().remove();}">
                                                            <i class="fa-solid fa-circle-xmark"></i>
                                                        </a>
                                                    </div>
                                                    <a href="<?=$result["car_img_1_path"]?>" target="_blank"><img class="car_img_1_info" src="<?=$result["car_img_1_path"]?>" data-path="<?=$result["car_img_1_path"]?>" data-name="<?=$result["car_img_1_name"]?>"/></a>
                                                </div>
                                            </li>
                                        <?endif;?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="btn_support_img" class="col-sm-2 col-form-label">차량 뒤 이미지</label>
                            <div class="col-sm-10">
                                <div class="img_div_wrap">
                                    <span class="img_span_wrap">
                                        <input type="file" id="car_img_2_file" name="car_img_2_file" class="img_file" />
                                        <a href="javascript:imageAdd('car_img_2');"><img src="/public/images/add_photo.jpg" alt="" class="margin"></a>
                                    </span>
                                    <ul class="ul_img" id="car_img_2">
                                        <?if( !empty($result["car_img_2_path"]) ):?>
                                            <li>
                                                <div class="img">
                                                    <div class="btn_delete">
                                                        <a onclick="if(confirm('삭제 하시겠습니까?')){$(this).parent().parent().parent().remove();}">
                                                            <i class="fa-solid fa-circle-xmark"></i>
                                                        </a>
                                                    </div>
                                                    <a href="<?=$result["car_img_2_path"]?>" target="_blank"><img class="car_img_2_info" src="<?=$result["car_img_2_path"]?>" data-path="<?=$result["car_img_2_path"]?>" data-name="<?=$result["car_img_2_name"]?>"/></a>
                                                </div>
                                            </li>
                                        <?endif;?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="btn_support_img" class="col-sm-2 col-form-label">차량 옆(왼쪽) 이미지</label>
                            <div class="col-sm-10">
                                <div class="img_div_wrap">
                                    <span class="img_span_wrap">
                                        <input type="file" id="car_img_3_file" name="car_img_3_file" class="img_file" />
                                        <a href="javascript:imageAdd('car_img_3');"><img src="/public/images/add_photo.jpg" alt="" class="margin"></a>
                                    </span>
                                    <ul class="ul_img" id="car_img_3">
                                        <?if( !empty($result["car_img_3_path"]) ):?>
                                            <li>
                                                <div class="img">
                                                    <div class="btn_delete">
                                                        <a onclick="if(confirm('삭제 하시겠습니까?')){$(this).parent().parent().parent().remove();}">
                                                            <i class="fa-solid fa-circle-xmark"></i>
                                                        </a>
                                                    </div>
                                                    <a href="<?=$result["car_img_3_path"]?>" target="_blank"><img class="car_img_3_info" src="<?=$result["car_img_3_path"]?>" data-path="<?=$result["car_img_3_path"]?>" data-name="<?=$result["car_img_3_name"]?>"/></a>
                                                </div>
                                            </li>
                                        <?endif;?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="btn_support_img" class="col-sm-2 col-form-label">차량 옆(오른쪽) 이미지</label>
                            <div class="col-sm-10">
                                <div class="img_div_wrap">
                                    <span class="img_span_wrap">
                                        <input type="file" id="car_img_4_file" name="car_img_4_file" class="img_file" />
                                        <a href="javascript:imageAdd('car_img_4');"><img src="/public/images/add_photo.jpg" alt="" class="margin"></a>
                                    </span>
                                    <ul class="ul_img" id="car_img_4">
                                        <?if( !empty($result["car_img_4_path"]) ):?>
                                            <li>
                                                <div class="img">
                                                    <div class="btn_delete">
                                                        <a onclick="if(confirm('삭제 하시겠습니까?')){$(this).parent().parent().parent().remove();}">
                                                            <i class="fa-solid fa-circle-xmark"></i>
                                                        </a>
                                                    </div>
                                                    <a href="<?=$result["car_img_4_path"]?>" target="_blank"><img class="car_img_4_info" src="<?=$result["car_img_4_path"]?>" data-path="<?=$result["car_img_4_path"]?>" data-name="<?=$result["car_img_4_name"]?>"/></a>
                                                </div>
                                            </li>
                                        <?endif;?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="btn_support_img" class="col-sm-2 col-form-label">차량 계기판 이미지</label>
                            <div class="col-sm-10">
                                <div class="img_div_wrap">
                                    <span class="img_span_wrap">
                                        <input type="file" id="car_img_5_file" name="car_img_5_file" class="img_file" />
                                        <a href="javascript:imageAdd('car_img_5');"><img src="/public/images/add_photo.jpg" alt="" class="margin"></a>
                                    </span>
                                    <ul class="ul_img" id="car_img_5">
                                        <?if( !empty($result["car_img_5_path"]) ):?>
                                            <li>
                                                <div class="img">
                                                    <div class="btn_delete">
                                                        <a onclick="if(confirm('삭제 하시겠습니까?')){$(this).parent().parent().parent().remove();}">
                                                            <i class="fa-solid fa-circle-xmark"></i>
                                                        </a>
                                                    </div>
                                                    <a href="<?=$result["car_img_5_path"]?>" target="_blank"><img class="car_img_5_info" src="<?=$result["car_img_5_path"]?>" data-path="<?=$result["car_img_5_path"]?>" data-name="<?=$result["car_img_5_name"]?>"/></a>
                                                </div>
                                            </li>
                                        <?endif;?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<script>
    function updateProcess(){
        let param               = {};
        let idx                 = $("#idx").val();
        let auth_number         = $("#auth_number").val();
        let car_img_1_path      = $(".car_img_1_info").data("path");
        let car_img_1_name      = $(".car_img_1_info").data("name");
        let car_img_2_path      = $(".car_img_2_info").data("path");
        let car_img_2_name      = $(".car_img_2_info").data("name");
        let car_img_3_path      = $(".car_img_3_info").data("path");
        let car_img_3_name      = $(".car_img_3_info").data("name");
        let car_img_4_path      = $(".car_img_4_info").data("path");
        let car_img_4_name      = $(".car_img_4_info").data("name");
        let car_img_5_path      = $(".car_img_5_info").data("path");
        let car_img_5_name      = $(".car_img_5_info").data("name");

        param.idx               = idx;
        param.auth_number       = auth_number;
        param.car_img_1_path    = car_img_1_path;
        param.car_img_1_name    = car_img_1_name;
        param.car_img_2_path    = car_img_2_path;
        param.car_img_2_name    = car_img_2_name;
        param.car_img_3_path    = car_img_3_path;
        param.car_img_3_name    = car_img_3_name;
        param.car_img_4_path    = car_img_4_path;
        param.car_img_4_name    = car_img_4_name;
        param.car_img_5_path    = car_img_5_path;
        param.car_img_5_name    = car_img_5_name;

        $.ajax({
            url             : "/users/updateProcess",
            method          : "POST",
            dataType        : "JSON",
            data            : param,
            beforeSend      : function(){
                processStart();
            },
            success         : function(result){
                if(result == "success"){
                    alert("저장 되었습니다.");
                    location.reload();
                }else{
                    alert("잠시 후 다시 시도하여 주세요.");
                }
            },
            complete    : function(){
                processEnd();
            }

        });
    }
</script>
