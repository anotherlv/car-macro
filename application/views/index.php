<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <button type="button" name="insurance_btn" data-user_idx="2" data-type="directdb_gui" class="btn btn-primary mr15">계산하기</button>
            </div>
        </div>
    </div>
</section>
<div class="pop hide" id="log_popup">
    <input type="hidden" id="type" value="">
    <input type="hidden" id="user_idx" value="">
    <div class="tit tit_navy">보험료 계산 진행상황</div>
    <div class="pop_inner">
        <div class="table_wrap mt30">
            <div class="card-body">
                <div id="log_messages" style="height: 350px; overflow-y: scroll;"></div>
            </div>
            <div class="card-body" style="text-align: center;">
                <button type="button" class="btn btn-secondary b-close">취소</button>
                <button type="button" class="btn btn-primary register_btn" onclick="">등록하기</button>
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
</script>
