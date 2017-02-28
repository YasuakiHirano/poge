window.onload = function(){
    $(".message-box").hide();
    $(".message-open").show();
}

function closeMessageBox(){
    $(".message-box").hide("slow");
    $(".message-open").show("slow");
}

function openMessageBox(){
    $(".message-open").hide("slow");
    $(".message-box").show("slow");
}

function iconSelect(){
    var iconImgTag = '<img src="'+$("#imageDir").val()+'icon'+$("#selIcon").val()+'.png" height="60"/>'; 
    $("#icon-preview").html(iconImgTag);
}

// 掲示板作成時バリデーション
function submitBoard(){
    var errorMsg = ''; 
    var afterMsg = '値を入力してください。\n';
    if($("#user_name").val() == ''){
        errorMsg += '名前が空です。' + afterMsg;
    }

    if($("#board_title").val() == ''){
        errorMsg += 'タイトルが空です。' + afterMsg;
    }

    if($("#about_text").val() == ''){
        errorMsg += '説明文が空です。' + afterMsg;
    }

    if($("#password").val() == ''){
        errorMsg += 'パスワードが空です。' + afterMsg;
    } 

    if(errorMsg == ''){
        $('#formMakeBoard').submit();
    } else {
        alert(errorMsg);
    }
}

// メッセージ作成時バリデーション
function submitMessage(){
    var errorMsg = ''; 
    var afterMsg = '値を入力してください。\n';
    if($("#user_name").val() == ''){
        errorMsg += '名前が空です。' + afterMsg;
    }

    if($("#message").val() == ''){
        errorMsg += '内容が空です。' + afterMsg;
    } 

    if(errorMsg == ''){
        $('#formInsertMessage').submit();
    } else {
        alert(errorMsg);
    }
}

function delButton(){
    $('#delButtonArea').hide('slow');
    $('#delArea').show('slow');
}

function deleteSubmit(){
    var errorMsg = ''; 
    var afterMsg = '値を入力してください。\n';
    if($("#delPassword").val() == ''){
        errorMsg += 'パスワードが空です。' + afterMsg;
    }

    if(errorMsg == ''){
        $('#formDeleteBoard').submit();
    } else {
        alert(errorMsg);
    }
}
