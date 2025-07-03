<style>
    .auth_number_wrap {display: flex; gap: 2%; align-items: center;}
    .auth_number_wrap label{width: 10%; display: unset !important; margin-bottom: unset !important;}
    .auth_number_wrap input{width: 40%;}
    .auth_number_wrap button{width: 10%;}
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!--<div class="card-header">
                        <h3 class="card-title">DataTable with minimal features &amp; hover style</h3>
                    </div>-->

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6"></span></div>
                        </div>
                        <div class="row search_wrap">
                            <div class="col-sm-12">
                                <table class="table table-bordered default_table">
                                    <colgroup>
                                        <col style="width:16%;">
                                        <col style="width:14%;">
                                        <col style="width:14%;">
                                        <col style="width:14%;">
                                        <col style="width:14%;">
                                        <col style="width:14%;">
                                        <col style="width:14%;">
                                    </colgroup>
                                    <tbody>
                                    <tr>
                                        <th>검색어 옵션</th>
                                        <td colspan="6" style="text-align: left;">
                                            <div class="mr30 icheck-primary d-inline">
                                                <input type="radio" id="option_all" name="option" value="" />
                                                <label for="option_all">전체</label>
                                            </div>
                                            <div class="mr30 icheck-primary d-inline">
                                                <input type="radio" id="option_1" name="option" value="" />
                                                <label for="option_1">옵션 1</label>
                                            </div>
                                            <div class="mr30 icheck-primary d-inline">
                                                <input type="radio" id="option_2" name="option" value="" />
                                                <label for="option_2">옵션 2</label>
                                            </div>
                                            <div class="mr30 icheck-primary d-inline">
                                                <input type="radio" id="option_3" name="option" value="" />
                                                <label for="option_3">옵션 3</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>검색어</th>
                                        <td>
                                            <select id="search_field" class="form-control">
                                                <option value="title" <?=$search_field == "name" ? "selected" : ""?>>이름</option>
                                            </select>
                                        </td>
                                        <td colspan="5">
                                            <input id="search_string" type="text" class="form-control" placeholder="검색어를 입력해 주세요." value="<?=$search_string?>">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-12" style="text-align: center;">
                                <button onclick="search();" type="button" class="btn btn-secondary mr15">검&nbsp;&nbsp;&nbsp;색</button>
                                <button onclick="reset()" type="button" class="btn btn-default mr15">초기화</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">총 : <?=$tot_row?>명</div>
<!--                                <div class="col-sm-12 col-md-6">-->
<!--                                    <button type="button" class="btn btn-danger mr15" style="float: right;" onclick="deletePlan();">선택삭제</button>-->
<!--                                </div>-->
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-hover dataTable default_table">
                                    <colgroup>
                                        <col style="width:5%;">
                                        <col style="width:5%;">
                                        <col style="width:8%;">
                                        <col style="width:8%;">
                                        <col style="width:8%;">
                                        <col style="width:8%;">
                                        <col style="width:8%;">
                                        <col style="width:8%;">
                                        <col style="width:8%;">
                                        <col style="width:8%;">
                                        <col style="width:8%;">
                                        <col style="width:8%;">
                                    </colgroup>
                                    <thead>
                                    <tr>
                                        <th rowspan="2">No.</th>
                                        <th rowspan="2">이름</th>
                                        <th colspan="2" style="border-bottom: 1px;">DB</th>
                                        <th colspan="2" style="border-bottom: 1px;">KB</th>
                                        <th colspan="2" style="border-bottom: 1px;">삼성</th>
                                        <th colspan="2" style="border-bottom: 1px;">현대</th>
                                        <th colspan="2" style="border-bottom: 1px;">메리츠</th>
                                    </tr>
                                    <tr>
                                        <th>계산</th>
                                        <th>보험료</th>
                                        <th>계산</th>
                                        <th>보험료</th>
                                        <th>계산</th>
                                        <th>보험료</th>
                                        <th>계산</th>
                                        <th>보험료</th>
                                        <th>계산</th>
                                        <th>보험료</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?foreach( $result as $rows ):?>
                                        <tr>
                                            <td><?=$cur_num--;?></td>
                                            <td><?=$rows["name"]?></td>
                                            <td>
                                                <button type="button" name="insurance_btn" data-user_idx="<?=$rows["idx"]?>" data-type="directdb" class="btn <?=!empty($rows["directdb_total_price"]) ? "btn-secondary" : "btn-primary"?> mr15">계산하기</button>
                                            </td>
                                            <td><?=!empty($rows["directdb_total_price"]) ? number_format($rows["directdb_total_price"]) : 0?></td>
                                            <td>
                                                <button type="button" name="insurance_btn" data-user_idx="<?=$rows["idx"]?>" data-type="kb" class="btn <?=!empty($rows["kb_total_price"]) ? "btn-secondary" : "btn-primary"?> mr15">계산하기</button>
                                            </td>
                                            <td><?=!empty($rows["kb_total_price"]) ? number_format($rows["kb_total_price"]) : 0?></td>
                                            <td>
                                                <button type="button" name="insurance_btn" data-user_idx="<?=$rows["idx"]?>" data-type="samsung" class="btn <?=!empty($rows["samsung_total_price"]) ? "btn-secondary" : "btn-primary"?> mr15">계산하기</button>
                                            </td>
                                            <td><?=!empty($rows["samsung_total_price"]) ? number_format($rows["samsung_total_price"]) : 0?></td>
                                            <td>
                                                <button type="button" name="insurance_btn" data-user_idx="<?=$rows["idx"]?>" data-type="hyundai" class="btn <?=!empty($rows["hyundai_total_price"]) ? "btn-secondary" : "btn-primary"?> mr15">계산하기</button>
                                            </td>
                                            <td><?=!empty($rows["hyundai_total_price"]) ? number_format($rows["hyundai_total_price"]) : 0?></td>
                                            <td>
                                                <button type="button" name="insurance_btn" data-user_idx="<?=$rows["idx"]?>" data-type="meritz" class="btn <?=!empty($rows["meritz_total_price"]) ? "btn-secondary" : "btn-primary"?> mr15">계산하기</button>
                                            </td>
                                            <td><?=!empty($rows["meritz_total_price"]) ? number_format($rows["meritz_total_price"]) : 0?></td>
                                        </tr>
                                    <?endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="paging_wrap">
                            <?=$paging?>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>

<div class="pop hide" id="log_popup">
    <input type="hidden" id="type" value="">
    <input type="hidden" id="user_idx" value="">
    <div class="tit tit_navy">보험료 계산 진행상황</div>
    <div class="pop_inner">
        <div class="table_wrap mt30">
            <div class="card-body">
                <div id="log_messages"></div>
                <div class="form-group auth_number_wrap" style="display: none;">
                    <label for="auth_number">인증번호</label>
                    <input type="text" class="form-control" id="auth_number" maxlength="6" placeholder="인증번호를 입력해 주세요." oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="" />
                    <button type="button" class="btn btn-primary" onclick="sendAuthNumber();">전송</button>
                </div>
            </div>
            <div class="card-body" style="text-align: center;">
                <button type="button" class="btn btn-secondary b-close">취소</button>
            </div>
        </div>
    </div>
</div>
<script>
    const socket        = new WebSocket("<?=$this->config->item("api_web_socket")?>");
    const log_messages  = document.getElementById("log_messages");

    socket.onopen = () => {
        console.log("WebSocket 연결 완료")
    };

    socket.onmessage = (event) => {
        let data = JSON.parse(event.data);
        console.log(data);
        if( data.status === "success" ){
            $.ajax({
                url             : "/users/updateInsurance",
                method          : "POST",
                dataType        : "JSON",
                data            : {"response_data" : data.message},
                success :        function(result){
                    if( result == "success" ){
                        location.reload();
                    }else{
                        alert("잠시 후 다시 시도하여 주세요.");
                    }
                }
            });
        }else if( data.status === "auth_number" ){
            $("#log_popup .auth_number_wrap").show();
            log_messages.innerHTML += `<p>📩 서버 응답: ${data.message}</p>`;
        }else{
            log_messages.innerHTML += `<p>📩 서버 응답: ${data.message}</p>`;
        }

    };

    $(document).ready(function() {
        $("#search_string").keydown(function(key) {
            if (key.keyCode == 13) {
                search();
            }
        });

        $("button[name='insurance_btn']").click(function(){
            if( $(this).hasClass("btn-secondary") ){
                if( !confirm("다시 계산하시겠습니까?") ){
                    return;
                }
            }
            let type        = $(this).data("type");
            let user_idx    = $(this).data("user_idx");

            if( type != "" && user_idx != "" ){
                $("#log_messages").empty();
                $("#log_popup").bPopup({
                    opacity : 0.8,
                    speed   : 450,
                    onClose : function(){
                        $("#log_messages").empty();
                        console.log("팝업 닫음");
                    }
                });

                socket.send(JSON.stringify({
                    type: type,
                    user_idx: user_idx
                }));
            }
        });
    });

    function sendAuthNumber(){
        let auth_number     = $("#auth_number").val();
        if( auth_number.length === 6 ){
            $("#log_popup .auth_number_wrap").hide();
            socket.send(JSON.stringify({
                auth_number: auth_number,
            }));
            $("#auth_number").val("");
        }else{
            alert("인증번호 6자리를 입력해 주세요.");
        }

    }

    function search(){
        let search_field    = $("#search_field option:selected").val();
        let search_string   = $("#search_string").val();
        location.href       = "/users?search_field="+search_field+"&search_string="+search_string;
    }

    function reset(){
        location.href       = "/users";
    }

</script>