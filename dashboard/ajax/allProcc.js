$(document).ready(function () {
    
    // جلب التقارير
    getReporting();
    
    function getCountReport(){
        $.ajax({
            url: "ajax/allProcc.php",
            method: "POST",
            data: {countReport: "true"},
            success: function (data) {
                $(".statistics .countReport").text("[ " + data[0] + " ]");
            }
        });
    }
    
    getCountWord();
    function getCountWord(){
        $.ajax({
            url: "ajax/allProcc.php",
            method: "POST",
            data: {countWord: "true"},
            success: function (data) {
                $(".statistics .countWord").text("[ " + data[0] + " ]");
            }
        });
    }
    getCountUser();
    function getCountUser(){
        $.ajax({
            url: "ajax/allProcc.php",
            method: "POST",
            data: {countUser: "true"},
            success: function (data) {
                $(".statistics .countUser").text("[ " + data[0] + " ]");
            }
        });
    }
    
    function getReporting() {
        $.ajax({
            url: "ajax/allProcc.php",
            method: "POST",
            data: {getReporting: "true"},
            beforeSend: function () {
                $(".table-reporting .loadingReporting").toggleClass("hide");
            },
            success: function (data) {
                $(".table-reporting table tbody").html("");
                if ( data.msg == "Success" ) {
                    for ( i=0; i < data.result.length;i++ ) {
                        report = $("<td></td>").html(data.result[i].report);
                        sendReport = $("<td></td>").text(data.result[i].username);
                        word_english = $("<td></td>").html(data.result[i].word_english);
                        word_arabic = $("<td></td>").html(data.result[i].word_arabic);
                        action = $("<td></td>")
                                .html("<a class='waves-effect waves-light btn small red modal-trigger' href='#deleteReport' data-key='" + data.result[i].key_hash + "' data-idword='"+data.result[i].id_word+"'><i class='material-icons'>delete</i></a>");
                        tr = $("<tr></tr>").append(report, sendReport, word_english, word_arabic, action);
                        $(".table-reporting table tbody").append(tr);
                    }
                } else {
                    td = $("<td colspan='5'></td>").html(data.result);
                    tr = $("<tr></tr>").html(td);
                    $(".table-reporting table tbody").append(tr);
                }
                $(".table-reporting .loadingReporting").toggleClass("hide");
                getCountReport();
                getCountWord();
            }
        });
    }
    
    // حذف الابلاغ
    $("body").on("click", ".table-reporting table [href='#deleteReport']", function () {
        $("#deleteReport .no-delete-report").data("key", $(this).data("key"));
        $("#deleteReport .yes-delete-report").data("idword", $(this).data("idword"));
        $("#deleteReport .yes-delete-report").data("key", $(this).data("key"));
    });
    $("body").on("click", "#deleteReport .no-delete-report", function () { // حذف الابلاغ فقط
        $.ajax({
            url: "ajax/allProcc.php",
            method: "POST",
            data: {deleteReportOnly: $(this).data("key")},
            beforeSend: function () {
                $(".backLoading").toggleClass("hide");
            },
            success: function (data) {
                $(".backLoading").toggleClass("hide");
                M.toast({html: data});
                getReporting();
            }
        });
    });
    $("body").on("click", "#deleteReport .yes-delete-report", function () { // حذف الابلاغ والكلمة
        $.ajax({
            url: "ajax/allProcc.php",
            method: "POST",
            data: {deleteReport: $(this).data("key"), deleteWord: $(this).data("idword")},
            beforeSend: function () {
                $(".backLoading").toggleClass("hide");
            },
            success: function (data) {
                $(".backLoading").toggleClass("hide");
                M.toast({html: data});
                getReporting();
            }
        });
    });
//    // ارسال رسالة
//    $("body").on("click", ".table-reporting table .sendMsg", function () {
//        $.ajax({
//            url: "ajax/allProcc.php",
//            method: "POST",
//            data: {idUser: $(this).data("iduser"), idSendReport: $(this).data("idsendreport")},
//            beforeSend: function () {
//                $(".backLoading").toggleClass("hide");
//            },
//            success: function (data) {
//                $("#sendMsgForUser form textarea").val("");
//                $("#sendMsgForUser form select").html("");
//                first = $("<option value='' disabled selected></option>").text("الشخص المراد الارسال الرسالة له");
//                user_1 = $("<option value='"+data[0].id+"'></option>").text(" الى مرسل الابلاغ: " + data[0].username);
//                user_2 = $("<option value='"+data[1].id+"'></option>").text("الى صاحب الكلمة: " + data[1].username);
//                $(".backLoading").toggleClass("hide");
//                $("#sendMsgForUser form select").append(first, user_1, user_2);
//                $('select').formSelect();
//            }
//        });
//    });
//    $("body").on("click", "#sendMsgForUser form button", function (e) {
//        e.preventDefault();
//        message = $("#sendMsgForUser form textarea").val();
//        sendTo = $("#sendMsgForUser form select").val();
//        
//        if ( message != "" && sendTo != "" ) {
//            $.ajax({
//                url: "ajax/allProcc.php",
//                method: "POST",
//                data: {message: message, sendTo: sendTo},
//                beforeSend: function () {
//                    $(".backLoading").toggleClass("hide");
//                },
//                success: function (data) {
//                    $(".backLoading").toggleClass("hide");
//                    M.toast({html: data.result});
//                    $(".modal").modal("close");
//                }
//            });  
//        } else {
//            msg = "<p>قم بكتابة رسالة واختيار المرسل اليه <i class='material-icons right red-text text-green'>close</i></p>";
//            M.toast({html: msg});
//        }
//    });
    
    // جلب اسماء المستخدمين
    pageUsers = window.location.href;
    pageUsers = pageUsers.split("/");
    pageUsers = pageUsers[pageUsers.length - 1];
    pageUsers = pageUsers.split(".");
    if ( pageUsers[0] == "admins" ) {
        getUsers();
    }
    function getUsers() {
        $.ajax({
            url: "ajax/allProcc.php",
            method: "POST",
            data: {getUsers: "true"},
            beforeSend: function () {
                $(".backLoading").toggleClass("hide");
            },
            success: function (data) {
                $(".backLoading").toggleClass("hide");
                $(".table-admin table tbody").html("");
                for ( i=0; i<data.result.length; i++ ) {
                    nameUser = $("<td></td>").text(data.result[i].username);
                    if ( data.result[i].role > 0 ) {
                        roleUser = $("<td></td>").html("<i class='material-icons'>security</i>");
                    } else {
                        roleUser = $("<td></td>").html("<i class='material-icons'>person</i>");
                    }
                    langUser = $("<td></td>").text(data.result[i].language);
                    Delete = $("<a class='waves-effect waves-light red btn modal-trigger' href='#deleteUser' data-key='"+data.result[i].key_hash+"'></a>").html("<i class='material-icons'>delete</i>");
                    if ( data.result[i].role > 0 ) {
                        Role = $("<a class='waves-effect waves-light role btn' data-key='"+data.result[i].key_hash+"'></a>").html("<i class='material-icons'>person</i>");
                    } else {
                        Role = $("<a class='waves-effect waves-light role btn' data-key='"+data.result[i].key_hash+"'></a>").html("<i class='material-icons'>security</i>");
                    }
                    action   = $("<td></td>").append(Delete, Role);
                    tr   = $("<tr></tr>").append(nameUser, roleUser, langUser, action);
                    $(".table-admin table tbody").append(tr);
                }
            }
        });
    }
    // حذف مستحدم
    $("body").on("click", ".table-admin table [href='#deleteUser']", function () {
        $("#deleteUser .yes-delete-user").data("key", $(this).data("key"));
    });
    $("body").on("click", "#deleteUser .yes-delete-user", function () {
        $.ajax({
            url: "ajax/allProcc.php",
            method: "POST",
            data: {deleteUser: $(this).data("key")},
            beforeSend: function () {
                $(".backLoading").toggleClass("hide");
            },
            success: function (data) {
                $(".backLoading").toggleClass("hide");
                M.toast({html: data});
                getUsers();
            }
        });
    });
    // اضافة صلاحية او حذفها
    $("body").on("click", ".table-admin table .role", function () {
        $.ajax({
            url: "ajax/allProcc.php",
            method: "POST",
            data: {role: $(this).data("key")},
            beforeSend: function () {
                $(".backLoading").toggleClass("hide");
            },
            success: function (data) {
                $(".backLoading").toggleClass("hide");
                M.toast({html: data});
                getUsers();
            }
        });
    });
    
    getUsersByWord();
    function getUsersByWord() { // جلب 
        $.ajax({
            url: "ajax/allProcc.php",
            method: "POST",
            data: {getUsers: "true"},
            beforeSend: function () {
                //$(".backLoading").toggleClass("hide");
            },
            success: function (data) {
                $(".table-words #nameUsers").html("");
                $(".table-words #nameUsers").append('<option value="" disabled selected>جلب الكلمات حسب الاسم</option>');
                if ( data.msg == "Success" ) {
                    for ( i=0; i<data.result.length; i++ ) {
                        opt = $("<option value='"+data.result[i].id+"'></option>").text(data.result[i].username);
                        $(".table-words #nameUsers").append(opt);
                    }
                }
                $('select').formSelect();
            }
        });
    }
    
    $(".table-words #lang").change(function () { // جلب الكلمات حسب اللغة
        $.ajax({
            url: "ajax/allProcc.php",
            method: "POST",
            data: {getWordsOrderLang: $(this).val()},
            beforeSend: function () {
                $(".backLoading").toggleClass("hide");
            },
            success: function (data) {
                $(".backLoading").toggleClass("hide");
                $(".table-words table tbody").html("");
                if ( data.msg == "Success" ) {
                    for ( i=0; i<data.result.length; i++ ) {
                        nameUser = $("<td></td>").text(data.result[i].username);
                        lang = $("<td></td>").text(data.result[i].language);
                        word_english = $("<td></td>").text(data.result[i].word_english);
                        word_arabic = $("<td></td>").text(data.result[i].word_arabic);
                        Delete = $("<a class='waves-effect waves-light red btn modal-trigger' href='#deleteWord' data-key='"+data.result[i].key_hash+"'></a>").html("<i class='material-icons'>delete</i>");
                        action   = $("<td></td>").append(Delete);
                        tr   = $("<tr></tr>").append(nameUser, lang, word_english, word_arabic, action);
                        $(".table-words table tbody").append(tr);
                    }
                } else {
                    $(".table-words table tbody").html("<tr></tr>").html("<td colspan='5'>"+data.result+"</td>");
                }
            }
        });
    });
    $(".table-words #nameUsers").change(function () { // جلب الكلمات حسب اسم الشخص
        $.ajax({
            url: "ajax/allProcc.php",
            method: "POST",
            data: {getWordsOrderName: $(this).val()},
            beforeSend: function () {
                $(".backLoading").toggleClass("hide");
            },
            success: function (data) {
                $(".backLoading").toggleClass("hide");
                $(".table-words table tbody").html("");
                if ( data.msg == "Success" ) {
                    for ( i=0; i<data.result.length; i++ ) {
                        nameUser = $("<td></td>").text(data.result[i].username);
                        lang = $("<td></td>").text(data.result[i].language);
                        word_english = $("<td></td>").text(data.result[i].word_english);
                        word_arabic = $("<td></td>").text(data.result[i].word_arabic);
                        Delete = $("<a class='waves-effect waves-light red btn modal-trigger' href='#deleteWord' data-key='"+data.result[i].key_hash+"'></a>").html("<i class='material-icons'>delete</i>");
                        action   = $("<td></td>").append(Delete);
                        tr   = $("<tr></tr>").append(nameUser, lang, word_english, word_arabic, action);
                        $(".table-words table tbody").append(tr);
                    }
                } else {
                    $(".table-words table tbody").html("<tr></tr>").html("<td colspan='5'>"+data.result+"</td>");
                }
            }
        });
    });
    
    getWords();
    function getWords() {
        $.ajax({
            url: "ajax/allProcc.php",
            method: "POST",
            data: {getWords: "true"},
            beforeSend: function () {
                $(".backLoading").toggleClass("hide");
            },
            success: function (data) {
                $(".backLoading").toggleClass("hide");
                $(".table-words table tbody").html("");
                if ( data.msg == "Success" ) {
                    for ( i=0; i<data.result.length; i++ ) {
                        nameUser = $("<td></td>").text(data.result[i].username);
                        lang = $("<td></td>").text(data.result[i].language);
                        word_english = $("<td></td>").text(data.result[i].word_english);
                        word_arabic = $("<td></td>").text(data.result[i].word_arabic);
                        Delete = $("<a class='waves-effect waves-light red btn modal-trigger' href='#deleteWord' data-key='"+data.result[i].key_hash+"'></a>").html("<i class='material-icons'>delete</i>");
                        action   = $("<td></td>").append(Delete);
                        tr   = $("<tr></tr>").append(nameUser, lang, word_english, word_arabic, action);
                        $(".table-words table tbody").append(tr);
                    }
                } else {
                    $(".table-words table tbody").html("<tr></tr>").html("<td colspan='5'>"+data.result+"</td>");
                }
            }
        });
    }
    // حذف كلمة
    $("body").on("click", ".table-words table [href='#deleteWord']", function () {
        $("#deleteWord .yes-delete-word").data("key", $(this).data("key"));
    });
    $("body").on("click", "#deleteWord .yes-delete-word", function () {
        $.ajax({
            url: "ajax/allProcc.php",
            method: "POST",
            data: {deleteWord: $(this).data("key")},
            beforeSend: function () {
                $(".backLoading").toggleClass("hide");
            },
            success: function (data) {
                $(".backLoading").toggleClass("hide");
                M.toast({html: data});
                getWords();
            }
        });
    });
    
});
