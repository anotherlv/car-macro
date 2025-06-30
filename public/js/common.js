$(document).ready(function(){
    /*$('#content').summernote({
        dialogsInBody: true,
        width : '100%',
        height : 500,
        lang: "ko-KR",              // 한글 설정
        disableResizeEditor: true,  // 리사이즈
        placeholder: '',            // placeholder 설정
        toolbar: [
            // [groupName, [list of button]]
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['style', ['bold', 'italic', 'underline','strikethrough', 'clear']],
            ['color', ['forecolor']],
            ['para', ['paragraph']],
            ['insert',['picture']]
        ],
        fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New','맑은 고딕','굴림체','굴림','바탕체'],
        fontSizes: ['8','9','10','11','12','14','16','18','20','22','24','28','30','36','50','72'],
        callbacks: {
            // 이미지를 업로드할 경우 이벤트를 발생
            onImageUpload: function(files, editor, welEditable) {
                sendFile(files[0], editor, welEditable, "content");
            }
        },
        focus : false
    });*/
});
// 페이지 뒤로가기
function back(){
    history.back();
}

// 이미지 추가
function imageAdd( img_id ){
    var agent = navigator.userAgent.toLowerCase();
    $("#"+img_id+"_file").click();
    if((navigator.appName == 'Netscape' && navigator.userAgent.search('Trident') != -1) || (agent.indexOf("msie") != -1) ) {
        document.getElementById(""+img_id+"_file").onchange = imageChangeIE(img_id);
    }else{
        imageChange( img_id );
    }
}

// 이미지 변경
function imageChange( img_id ){
    $("#"+img_id+"_file").change(function(){
        var ext = $("#"+img_id+"_file").val().split(".").pop().toLowerCase();
        if(ext.length > 0){
            if($.inArray(ext, ["gif","png","jpg","jpeg"]) == -1) {
                $("#"+img_id+"_file").val("");
                alert("gif, png, jpg 파일만 업로드 할수 있습니다.");
                return;
            }else{
                imageUpload( img_id );
                $("#"+img_id+"_file").val("");
            }
        }
    });
}

// 이미지 업로드
function imageUpload( img_id ){
    var data = new FormData();
    $.each($('#' + img_id + '_file')[0].files, function (i, file) {
        data.append('file-' + i, file);
    });

    $.ajax({
        url         : "/admin/upload/imageUpload",
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
                $('#'+img_id).empty();
                var html = '<li><div class="btn_delete"><a href="javascript:imageDelete('+"'"+  img_id +"'"+');"><img src="/public/admin/images/btn_delete_b.png"/></a></div><img src="'+result.img_path+'" class="margin" data-img="' + result.img_name +'"/></li>';
                $('#'+img_id).append(html);
                $('#'+img_id+'_path').val(result.img_path);
                $('#'+img_id+'_name').val(result.img_name);
                return;
            }else{
                alert('오류가 발생 되었습니다.');
                return;
            }

        },
        complete    : function(){
            processEnd();
        }
    });
}

// 이미지 삭제
function imageDelete( img_id ){
    if( confirm("삭제 하시겠습니까?") ){
        $("#"+img_id).find('li').remove();
        $("#"+img_id+"_path").val("");
        $("#"+img_id+"_name").val("");
    }
}

// 다중 이미지 추가
function imageMultiAdd( img_id, limit ){
    if( !limit ){
        limit   = 5;
    }
    $("#"+img_id+"_file").click();
    imageMultiChange( img_id, limit );
}

// 다중 이미지 변경
function imageMultiChange( img_id, limit ){
    $("#"+img_id+"_file").on("change", function(){
        var upload_file_len = $("#"+img_id+"_file")[0].files.length;
        var file_len        = $("#"+img_id+" li").length;
        if( (upload_file_len + file_len) > limit ){
            alert("최대 " + limit + "개 이미지만 등록 가능합니다.");
            return;
        }else{
            $.each($("#"+img_id+"_file")[0].files, function (i, file) {
                var ext = file.name.split(".").pop().toLowerCase();
                if(ext.length > 0){
                    if($.inArray(ext, ["gif","png","jpg","jpeg"]) == -1) {
                        alert("gif, png, jpg 파일만 업로드 할수 있습니다.");
                        $("#"+img_id+"_file").val("");
                        return;
                    }
                }
            });
        }

        $("#"+img_id+"_file").off("change");
        imageMultiUpload( img_id );
        $("#"+img_id+"_file").val("");
    });
}
// 다중 이미지 업로드
function imageMultiUpload( img_id ){

    var data = new FormData();
    $.each($("input[name='"+img_id+"_file']")[0].files, function (i, file) {
        data.append('file-' + i, file);
    });

    $.ajax({
        url         : "/admin/upload/imageMultiUpload",
        type        : "POST",
        processData : false,
        contentType : false,
        data        : data,
        dataType    : "JSON",
        success     : function (result) {
            if( result.status == "success" ){

                var html = '';
                var text = "삭제 하시겠습니까?";
                $.each(result.data, function (i, data) {
                    html += '<li>';
                    html += '   <div class="img">';
                    html += '       <div class="btn_delete">';
                    html += '           <a type="button" onclick=" if(confirm('+"'"+ text +"'"+')){$(this).parent().parent().parent().remove();}">';
                    html += '               <i class="fa-solid fa-circle-xmark"></i>';
                    html += '           </a>';
                    html += '       </div>';
                    html += '       <a href="'+result.img_path + data.file_name + '" target="_blank"><img class="'+img_id+'_info" src="'+result.img_path + data.file_name + '" data-path="'+result.img_path + data.file_name+'" data-name="' + data.orig_name +'"/></a>';
                    html += '   </div>';
                    html += '</li>';
                });
                $('#'+img_id).append(html);

                return;
            }else{
                alert('오류가 발생 되었습니다.');
                return;
            }

        }
    });

}

// 에디터 이미지 업로드
function sendFile(file, editor, welEditable, id) {

    data        = new FormData();
    data.append("file", file);

    $.ajax({
        data        : data,
        type        : "POST",
        url         : "/admin/upload/editorImageUpload",
        processData : false,
        contentType : false,
        dataType    : "JSON",
        beforeSend  : function(){
            processStart();
        },
        success: function(data) {
            if (data.status == "success"){
                $('#' + id).summernote('insertImage', data.img_src);
            }
        },
        complete    : function(){
            processEnd();
        }
    });
}

// 핸드폰 정규식
function phoneCheck( phone ){
    var result      = false;
    var pattern     = /^010[0-9]{8}$/;

    if( !pattern.test(phone) ){
        result      = true;
    }

    return result;
}

// 숫자 정규식
function numCheck( num ){
    var result      = false;
    var pattern     = /^[0-9]+$/;

    if( !pattern.test(num) ){
        result      = true;
    }

    return result;
}

// 프로세스 시작
function processStart() {
    $('.loading_wrap').show();
}

// 프로세스 끝
function processEnd(){
    $('.loading_wrap').hide();
}

// 파일 추가
function fileAdd( file_id ){
    var agent = navigator.userAgent.toLowerCase();
    $("#"+file_id).click();
    if((navigator.appName == 'Netscape' && navigator.userAgent.search('Trident') != -1) || (agent.indexOf("msie") != -1) ){
        document.getElementById(""+file_id).onchange = fileChangeIE(file_id);
    }else{
        fileChange( file_id );
    }
}

// IE파일 변경
function fileChangeIE( file_id ){
    var ext = $("#"+file_id).val().split(".").pop().toLowerCase();
    if(ext.length > 0){
        fileUpload( file_id );
        $("#"+file_id).val("");
    }
}

// 파일 변경
function fileChange( file_id ){
    $("#"+file_id).change(function(){
        var ext = $("#"+file_id).val().split(".").pop().toLowerCase();
        if(ext.length > 0){
            fileUpload( file_id );
            $("#"+file_id).val("");
        }
    });
}

// 파일 삭제
function fileDelete( file_id ){
    if( confirm("삭제 하시겠습니까?") ){
        $("#" + file_id + "_path").val("");
        $("#" + file_id + "_name").val("");
        $("#" + file_id + "_desc").val("");

    }
}

// 파일 업로드
function fileUpload( file_id ){
    var data = new FormData();
    $.each($('#' + file_id)[0].files, function (i, file) {
        data.append('file-' + i, file);
    });

    $.ajax({
        url         : "/admin/upload/fileUpload",
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
                $('#'+file_id+'_path').val(result.file_path);
                $('#'+file_id+'_name').val(result.file_name);
                $('#'+file_id+'_desc').val(result.file_name);
                return;
            }else{
                alert('오류가 발생 되었습니다.');
                return;
            }

        },
        complete    : function(){
            processEnd();
        }
    });
}

// 파일 폼 추가
function addFileForm( file_id ){
    var num         = parseInt($("#"+file_id+"_form_cnt").val()) + 1;
    var file_id_num = file_id + "_" + num;
    var html        = '';
    html            += '<div class="form-group row '+file_id+'_form '+file_id_num+'_form">';
    html            += '    <label class="col-sm-2 col-form-label"></label>';
    html            += '    <div class="col-sm-5">';
    html            += '        <div class="input-group-prepend">';
    html            += '            <input type="file" class="form-control" id="'+file_id_num+'" name="attached_file" />';
    html            += '            <input type="hidden" class="form-control" id="'+file_id_num+'_path" name="'+file_id+'_path" value="" />';
    html            += '            <input type="hidden" class="form-control" id="'+file_id_num+'_name" name="'+file_id+'_name" value="" />';
    html            += '            <input type="text" class="form-control" id="'+file_id_num+'_desc" value="" placeholder="파일을 선택해 주세요." disabled />';
    html            += '            <div class="input-group-append" style="width:200px;">';
    html            += '                <button type="button" class="btn btn-block btn-info" onclick="fileAdd('+"'"+file_id_num+"'"+');" >파일첨부</button>';
    html            += '            </div>';
    html            += '        </div>';
    html            += '    </div>';
    html            += '    <div style="float:left;">';
    html            += '        <button type="button" class="btn btn-danger" onclick="fileDelete('+"'"+file_id_num+"'"+');" style="width:90px;" >파일삭제</button>';
    html            += '        <button type="button" class="btn btn-danger" onclick="deleteFileForm('+"'"+file_id_num+"'"+');" style="width:50px; margin-left:30px;" >-</button>';
    html            += '    </div>';
    html            += '</div>';

    $("#"+file_id+"_form_cnt").val(num);
    $("."+file_id+"_form:last").after(html);

}

// 파일 폼 추가
function addFileFormCustom( file_id ){
    var num         = parseInt($("#"+file_id+"_form_cnt").val()) + 1;
    var file_id_num = file_id + "_" + num;
    var html        = '';
    html            += '<div class="file_wrap '+file_id+'_form '+file_id_num+'_form">';
    html            += '    <div class="filebox bs3-primary">';
    html            += '        <input type="text" class="upload-name" id="'+file_id_num+'_desc" value="파일선택"  disabled="disabled">';
    html            += '        <input type="hidden" class="form-control" id="'+file_id_num+'_path" name="'+file_id+'_path" />';
    html            += '        <input type="hidden" class="form-control" id="'+file_id_num+'_name" name="'+file_id+'_name" />';
    html            += '        <label for="'+file_id_num+'">찾아보기</label>';
    html            += '        <input type="file" id="'+file_id_num+'" name="attached_file" onclick="fileChange('+"'"+file_id_num+"'"+');" class="upload-hidden">';
    html            += '    </div>';
    html            += '    <div class="btn_wrap">';
    html            += '        <a href="javascript:;" onclick="deleteFileForm('+"'"+file_id_num+"'"+');"><img src="/public/images/tenant_company/btn_minus.png" alt=""></a>';
    html            += '    </div>';
    html            += '</div>';

    $("#"+file_id+"_form_cnt").val(num);
    $("."+file_id+"_form:last").after(html);
}

// 파일 폼 삭제
function deleteFileForm( file_id ){
    $("."+file_id+"_form").remove();
}

// 카테고리 유형추가
function addCategory(){
    var str_val     = $("#str_val").val();
    if( str_val == "" ){
        alert("유형을 입력해 주세요.");
        $("#str_val").focus();
        return;
    }
    var html        = '';
    html            += '<li class="category_list">';
    html            += '    <input style="float:left;" type="text" data-idx="" class="form-control category_str" value="'+str_val+'" />';
    html            += '    <div class="input-group-append category_colorpicker colorpicker_wrap" style="float:left;">';
    html            += '        <input name="category_color" type="text" class="form-control color_input category_color" value="#000000" />';
    html            += '        <div class="input-group-append color_div"></div>';
    html            += '    </div>';
    html            += '</li>';
    $("#category_list").append(html);
    $("#str_val").val("");
}

// 카테고리 저장
function categoryRegistProcess(entry){
    var status              = true;
    var category_data       = [];

    $(".category_list").each(function(){
        var category        = {};
        category.idx        = $(this).find(".category_str").attr("data-idx");
        category.str_val    = $(this).find(".category_str").val();
        category.color      = $(this).find(".category_color").val();
        if( category.str_val != "" ){
            category_data.push(category);
        }else{
            alert("유형명을 입력해 주세요.");
            $(this).focus();
            status  = false;
            return false;
        }
    });

    if(status === false){
        return;
    }

    $.ajax({
        url     : "/admin/category/registProcess",
        method  : "POST",
        dataType: "JSON",
        data    : {"entry" : entry, "category_data" : category_data},
        success : function(result){
            if(result.status == "success"){
                alert('저장 되었습니다');
                location.reload();
            }else{
                alert('다시 확인해 주세요');
            }
        }
    });
}

// 동영상 추가
function videoAdd( video_id ){
    $("#"+video_id).click();
    videoChange( video_id );
}

// 동영상 변경
function videoChange( video_id ){
    $("#"+video_id).change(function(){
        var ext = $("#"+video_id).val().split(".").pop().toLowerCase();

        if(ext.length > 0){
            if($.inArray(ext, ["mp4"]) == -1) {
                $("#"+video_id).val("");
                alert("mp4 파일만 업로드 할수 있습니다.");
                return;
            }else{
                videoUpload( video_id );
                $("#"+video_id).val("");
            }
        }
    });
}

// 동영상 삭제
function videoDelete( video_id ){
    if( confirm("삭제 하시겠습니까?") ){
        $("#" + video_id + "_path").val("");
        $("#" + video_id + "_name").val("");
        $("#" + video_id + "_desc").val("");

    }
}

// 동영상 업로드
function videoUpload( video_id ){

    var data = new FormData();
    $.each($('#' + video_id)[0].files, function (i, file) {
        data.append('file-' + i, file);
    });

    $.ajax({
        url         : "/admin/upload/videoUpload",
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
                $('#'+video_id+'_path').val(result.video_path);
                $('#'+video_id+'_name').val(result.video_name);
                $('#'+video_id+'_desc').val(result.video_name);
                $('#'+video_id+'_play_time').val(result.play_time);
                return;
            }else{
                alert('오류가 발생 되었습니다.');
                return;
            }

        },
        complete    : function(){
            processEnd();
        }
    });
}

// Online order 폼 추가
function addLectureOrderForm(){
    var num         = parseInt($("#order_form_cnt").val()) + 1;
    var html        = '';
    html            += '<div class="order_form order_form_'+num+'">';
    html            += '    <div class="form-group row">';
    html            += '        <label for="btn_thumb_img" class="col-sm-2 col-form-label">썸네일 이미지</label>';
    html            += '        <div class="col-sm-10">';
    html            += '            <div class="img_div_wrap">';
    html            += '                <span class="img_span_wrap">';
    html            += '                    <input type="file" id="thumb_img_'+num+'_file" name="thumb_img_file" class="img_file"/>';
    html            += '                    <input type="hidden" id="thumb_img_'+num+'_path" name="thumb_img_path" value="" />';
    html            += '                    <input type="hidden" id="thumb_img_'+num+'_name" name="thumb_img_name" value="" />';
    html            += '                    <a href="javascript:imageAdd('+"'thumb_img_"+num+"'"+')"><img src="/public/admin/images/add_photo.jpg" alt="" class="margin"></a>';
    html            += '                </span>';
    html            += '                <ul class="ul_img" id="thumb_img_'+num+'"></ul>';
    html            += '            </div>';
    html            += '        </div>';
    html            += '    </div>';
    html            += '    <div class="form-group row video_file_form">';
    html            += '        <label class="col-sm-2 col-form-label">동영상파일</label>';
    html            += '        <div class="col-sm-5">';
    html            += '            <div class="input-group-prepend">';
    html            += '                <input type="file" class="form-control" id="video_file_'+num+'" name="video_file" />';
    html            += '                <input type="hidden" class="form-control" id="video_file_'+num+'_path" name="video_file_path" value="" />';
    html            += '                <input type="hidden" class="form-control" id="video_file_'+num+'_name" name="video_file_name" value="" />';
    html            += '                <input type="hidden" class="form-control" id="video_file_'+num+'_play_time" name="video_file_play_time" value="" />';
    html            += '                <input type="text" class="form-control" id="video_file_'+num+'_desc" value="" placeholder="동영상을 선택해 주세요." disabled />';
    html            += '                <div class="input-group-append" style="width:200px;">';
    html            += '                    <button type="button" class="btn btn-block btn-info" onclick="videoAdd('+"'video_file_"+num+"'"+');" >동영상첨부</button>';
    html            += '                </div>';
    html            += '            </div>';
    html            += '        </div>';
    html            += '        <div style="float:left;">';
    html            += '            <button type="button" class="btn btn-danger" onclick="videoDelete('+"'video_file_"+num+"'"+');" style="width:110px;" >동영상삭제</button>';
    html            += '        </div>';
    html            += '    </div>';
    html            += '    <div class="form-group row">';
    html            += '        <label for="lecture_title_'+num+'" class="col-sm-2 col-form-label">강좌제목</label>';
    html            += '        <div class="col-sm-10">';
    html            += '            <input type="text" class="form-control" id="lecture_title_'+num+'" name="lecture_title" placeholder="제목" value="" />';
    html            += '        </div>';
    html            += '    </div>';
    html            += '    <div class="form-group row">';
    html            += '        <label for="lecture_content_'+num+'" class="col-sm-2 col-form-label">강좌내용</label>';
    html            += '        <div class="col-sm-10">';
    html            += '            <textarea id="lecture_content_'+num+'" name="lecture_content" class="text_area"></textarea>';
    html            += '        </div>';
    html            += '    </div>';
    html            += '</div>';
    $("#order_form_cnt").val(num);
    $(".order_form:last").after(html);

}

// Online order 폼 삭제
function deleteLectureOrderForm(){
    var form_cnt    = $(".order_form").length;

    if( form_cnt > 1 ){
        if( confirm("마지막 폼을 삭제 하시겠습니까?") ){
            $(".order_form:last").remove();
        }
    }else{
        alert("기본 폼은 삭제할 수 없습니다.");
    }

}

// 강좌 순서 변경
function lectureOrderChange(){

    var complete_btn    = '<button type="button" id="order_complete" class="btn btn-default" onclick="lectureOrderComplete()" style="width:100px;" >순서 적용</button>';
    $("#order_change").remove();
    $(".order_btn_wrap").append(complete_btn);


    $(".btn-primary").attr('disabled', true);
    $(".btn-danger").attr('disabled', true);
    $(".btn-info").attr('disabled', true);

    $(".order_form_wrap").sortable({
        disabled : false,
        helper  : fixWidthHelper,
        stop    : function(){

        }
    }).disableSelection();

    function fixWidthHelper(e, ui) {
        ui.children().each(function() {
            $(this).width($(this).width());
        });
        return ui;
    }

}

// 강좌 순서 적용
function lectureOrderComplete(){
    var change_btn      = '<button type="button" id="order_change" class="btn btn-default" onclick="lectureOrderChange()" style="width:100px;" >순서 변경</button>';
    $("#order_complete").remove();
    $(".order_btn_wrap").append(change_btn);
    $(".order_form_wrap").sortable('disable');
    $(".btn-primary").attr('disabled', false);
    $(".btn-danger").attr('disabled', false);
    $(".btn-info").attr('disabled', false);
}

function fileDownload(file_path, file_name){
    if( file_path != "" || file_name != "" ){
        location.href = '/admin/upload/fileDownload?file_path='+file_path+'&file_name='+file_name;
    }else{
        alert("다운로드 파일이 없습니다.");
    }
}

/*팝업 띄우기*/
function popOpen(pop_name) {
    $('.' + pop_name).bPopup({
        opacity:0.55,
        speed: 450,
    });
}

