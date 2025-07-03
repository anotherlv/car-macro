<style>
    #ai_popup .card-body .form-group {display: flex;}
    #ai_popup .card-body .form-group >  label {width: 140px; display: flex !important; margin-bottom: unset !important; align-items: center;}
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
                        <div class="row search_wrap" style="padding-bottom: unset;">
                            <div class="col-sm-12" style="text-align: right;">
                                <input style="display: none;" type="file" id="excel_file" />
                                <button onclick="openPop();" type="button" class="btn btn-success mr15">보험료 AI 계산</button>
                                <button onclick="excelAdd();" type="button" class="btn btn-primary mr15">AI데이터 Excel 업로드</button>
                            </div>
                        </div>
                        <?if( !empty($tot_row) ):?>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">총 학습 데이터: <?=number_format($tot_row)?>개</div>
                        </div>
                        <?endif;?>
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
                                        <th>No.</th>
                                        <th>연식</th>
                                        <th>차종</th>
                                        <th>보험가입경력</th>
                                        <th>운전자범위</th>
                                        <th>연령제한</th>
                                        <th>대인배상Ⅱ</th>
                                        <th>대물배상</th>
                                        <th>자기신체사고<br>자동차사고</th>
                                        <th>무보험차상해</th>
                                        <th>자기차량손해<br>(자기부담금)</th>
                                        <th>긴급출동서비스</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?foreach( $result as $rows ):?>
                                        <tr>
                                            <td><?=$cur_num--;?></td>
                                            <td><?=$rows["G"]?></td>
                                            <td><?=$rows["I"]?></td>
                                            <td><?=$rows["J"]?></td>
                                            <td><?=$rows["N"]?></td>
                                            <td><?=$rows["O"]?></td>
                                            <td><?=$rows["P"]?></td>
                                            <td><?=$rows["Q"]?></td>
                                            <td><?=$rows["R"]?></td>
                                            <td><?=$rows["S"]?></td>
                                            <td><?=$rows["T"]?></td>
                                            <td><?=$rows["U"]?></td>
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
<div class="pop hide" id="ai_result_popup">
    <input type="hidden" id="type" value="">
    <input type="hidden" id="user_idx" value="">
    <div class="tit tit_navy">보험료 AI 계산결과</div>
    <div class="pop_inner">
        <div class="table_wrap mt30">
            <div class="card-body">
                <div id="log_messages">
                    <p>DB 예상 보험료 : <span id="A_result"></span>원</p>
                    <p>KB 예상 보험료 : <span id="B_result"></span>원</p>
                    <p>삼성 예상 보험료 : <span id="C_result"></span>원</p>
                    <p>현대 예상 보험료 : <span id="D_result"></span>원</p>
                    <p>메리츠 예상 보험료 : <span id="E_result"></span>원</p>
                    <p>흥국 예상 보험료 : <span id="F_result"></span>원</p>
                    <p>한화 예상 보험료 : <span id="G_result"></span>원</p>
                </div>
            </div>
            <div class="card-body" style="text-align: center;">
                <button type="button" class="btn btn-primary b-close">확인</button>
            </div>
        </div>
    </div>
</div>

<div class="pop hide" id="ai_popup">
    <div class="tit tit_navy">보험료 AI 계산</div>
    <div class="pop_inner">
        <div class="table_wrap mt30">
            <div class="card-body">
                <div class="form-group">
                    <label for="G">연식</label>
                    <input type="text" class="form-control" id="G" oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="차량 연식을 입력해 주세요." value="" />
                </div>
                <div class="form-group">
                    <label for="J">보험가입경력</label>
                    <select class="form-control" id="J">
                        <option value="1년미만">1년미만</option>
                        <option value="2년미만">2년미만</option>
                        <option value="3년미만">3년미만</option>
                        <option value="4년미만">4년미만</option>
                        <option value="5년미만">5년미만</option>
                        <option value="6년미만">6년미만</option>
                        <option value="7년이상">7년이상</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="N">운전자범위</label>
                    <select class="form-control" id="N">
                        <option value="본인">본인</option>
                        <option value="1인한정">1인한정</option>
                        <option value="부부한정">부부한정</option>
                        <option value="가족한정">가족한정</option>
                        <option value="누구나">누구나</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="O">연령제한</label>
                    <select class="form-control" id="O">
                        <?for( $i = 20; $i <= 50; $i++):?>
                        <option value="만<?=$i?>세이상">만<?=$i?>세이상</option>
                        <?endfor;?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">대인배상Ⅱ</label>
                    <div class="radio_wrap" style="justify-content: start;">
                        <div class="radio_radius" style="margin-right: 10px;">
                            <input type="radio" id="P_Y" name="P" value="무한" checked />
                            <label for="P_Y">무한</label>
                        </div>
                        <div class="radio_radius">
                            <input type="radio" id="P_N" name="P" value="미가입" />
                            <label for="P_N">미가입</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="Q">대물배상</label>
                    <input type="text" class="form-control" id="Q" placeholder="금액을 입력해 주세요." value="" />
                </div>
                <div class="form-group">
                    <label for="R">자기신체사고</label>
                    <input type="text" class="form-control" id="R" placeholder="금액을 입력해 주세요." value="" />
                </div>
                <div class="form-group">
                    <label for="S">무보험차상해</label>
                    <input type="text" class="form-control" id="S" placeholder="금액을 입력해 주세요." value="" />
                </div>
                <div class="form-group">
                    <label>자기차량손해</label>
                    <div class="radio_wrap" style="justify-content: start;">
                        <div class="radio_radius" style="margin-right: 10px;">
                            <input type="radio" id="T_Y" name="T" value="가입" checked />
                            <label for="T_Y">가입</label>
                        </div>
                        <div class="radio_radius">
                            <input type="radio" id="T_N" name="T" value="미가입" />
                            <label for="T_N">미가입</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="U">긴급출동서비스</label>
                    <select class="form-control" id="U">
                        <option value="고급">고급</option>
                        <option value="기본">기본</option>
                    </select>
                </div>
            </div>
            <div class="card-body" style="text-align: center;">
                <button type="button" class="btn btn-secondary b-close">취소</button>
                <button type="button" class="btn btn-primary register_btn" onclick="resultProcess();">계산하기</button>
            </div>
        </div>
    </div>
</div>
<script>
    function openPop(){
        $("#ai_popup").bPopup({
            opacity : 0.8,
            speed   : 450,
            onClose : function(){
                console.log("팝업 닫음");
            }
        });
    }

    function excelAdd(){
        $("#excel_file").click();
        excelChange();
    }

    function excelChange(){
        $("#excel_file").change(function(){
            let ext = $("#excel_file").val().split(".").pop().toLowerCase();
            if(ext.length > 0){
                if($.inArray(ext, ["xls","xlsx"]) == -1) {
                    $("#excel_file").val("");
                    alert("엑셀 파일만 업로드 할수 있습니다.");
                    return;
                }else{
                    excelUpload();
                    $("#excel_file").val("");
                }
            }
        });
    }

    function excelUpload(){
        let data = new FormData();
        $.each($('#excel_file')[0].files, function (i, file) {
            data.append('file-' + i, file);
        });

        $.ajax({
            url         : "/upload/excelUpload",
            type        : "POST",
            processData : false,
            contentType : false,
            data        : data,
            dataType    : "JSON",
            beforeSend  : function(){
                processStart();
            },
            success     : function (result) {
                if( result.status == "success" ){
                    alert("학습 데이터가 등록되었습니다.");
                }else{
                    alert("오류가 발생 되었습니다.");
                }
                processEnd();
            },
            complete    : function(){
                processEnd();
            }
        });
    }

    function resultProcess(){
        let G           = $("#G").val();
        let J           = $("#J option:selected").val();
        if( G == "" ){
            alert("차량 연식을 입력해 주세요.");
            return;
        }
        let param       = {G, J};

        $.ajax({
            url             : "/ai/resultProcess",
            method          : "POST",
            dataType        : "JSON",
            data            : param,
            beforeSend      : function(){
                processStart();
            },
            success         : function(data){
                if(data){
                    $("#A_result").text(data.A_result);
                    $("#B_result").text(data.B_result);
                    $("#C_result").text(data.C_result);
                    $("#D_result").text(data.D_result);
                    $("#E_result").text(data.E_result);
                    $("#F_result").text(data.F_result);
                    $("#G_result").text(data.G_result);
                    $("#ai_result_popup").bPopup({
                        opacity : 0.8,
                        speed   : 450,
                        onClose : function(){

                        }
                    });
                }else{
                    alert("잠시 후 다시 시도해 주세요.");
                }
            },
            complete    : function(){
                processEnd();
            }

        });
    }
</script>