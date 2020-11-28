$(document).ready(function () {
    /* START Page SignIn */
        // نسيت كلمة المرور
        $("body").on("click", ".forget [name='forget']", function () {
            username = $(".forget #forget_username").val();
            friend = $(".forget #forget_friend").val();
            work = $(".forget #forget_work").val();
            btn = $(this);
            $.ajax({
               url: "Ajax/allProcc.php",
               method: "POST",
               data: {username: username, friend: friend, work: work},
               beforeSend: function () {
                   $(".forget .preloader-wrapper").toggleClass("active");
                   btn.attr("disabled", "disabled");
               },
               success: function (data) {
                   if ( data.msg == "Error" ) {
                    for ( i=0;i<data.result.length;i++ ) {
                        M.toast({html: data.result[i]});
                    }   
                   } else {
                        $(".forget").addClass("hide");
                        $(".changePassword").removeClass("hide");   
                   }
                    btn.removeAttr("disabled", "disabled");
                    $(".forget .preloader-wrapper").toggleClass("active");
               },
               error: function () {
                   var toastHTML = '<span>حدث خطأ غير متوقع<i class="material-icons right red-text text-lighten-2">close</i></span>';
                   M.toast({html: toastHTML});
                   $(".forget .preloader-wrapper").toggleClass("active");
                   btn.removeAttr("disabled");
               }
            });
        });
        
        // تغيير الرمز

        $("body").on("click", ".changePassword [name='change']", function () {
            newPassword = $(".changePassword #new_password").val();
            
            $.ajax({
               url: "Ajax/allProcc.php",
               method: "POST",
               data: {changePassword: newPassword},
               beforeSend: function () {
                   $(".changePassword .preloader-wrapper").toggleClass("active");
                   btn.attr("disabled", "disabled");
               },
               success: function (data) {
                   if ( data.msg == "Error" ) {
                         for ( i=0;i<data.result.length;i++ ) {
                            M.toast({html: data.result[i]});
                        }
                        btn.removeAttr("disabled");
                        $(".changePassword .preloader-wrapper").toggleClass("active");
                   } else {
                        $(".forget").removeClass("hide");
                        $(".changePassword").addClass("hide");
                        $('.modal').modal('close');
                        M.toast({html: data.result});
                        // تصفير القيم
                        $(".forget #forget_username").val("");
                        $(".forget #forget_friend").val("");
                        $(".forget #forget_work").val("");
                        btn.removeAttr("disabled", "disabled");
                        $(".changePassword .preloader-wrapper").toggleClass("active");
                   }
               },
               error: function () {
                    var toastHTML = '<span>حدث خطأ غير متوقع<i class="material-icons right red-text text-lighten-2">close</i></span>';
                    M.toast({html: toastHTML});
                   $(".forget .preloader-wrapper").toggleClass("active");
                   btn.removeAttr("disabled");
               }
            });
        });
        

    /* END Page SignIn */
   
   /* START Page Home */
    // اضافة كلمة
    $("body").on("click", "#add_word button", function (e) {
        e.preventDefault();
        wordEnglish = $("#add_word #wordEnglish").val();
        wordArabic = $("#add_word #wordArabic").val();
        
        if ( $("#add_word #wordEnglish").val() && $("#add_word #wordArabic").val() ) {
            
            if ( wordEnglish.charCodeAt(0) < 200 && wordArabic.charCodeAt(0) > 1500 ) {
                $.ajax({
                    url: "Ajax/allProcc.php",
                    method: "POST",
                    data: {insert: "true", wordEnglish: wordEnglish , wordArabic: wordArabic},
                    beforeSend: function () {
                        $(".backLoading").toggleClass("hide");
                    },
                    success: function (data) {
                        $(".backLoading").toggleClass("hide");
                        if ( data.msg == "Error" ) {
                            for( i=0;i<data.result.length;i++ ){
                                M.toast({html: data.result[i]});
                            }
                        } else {
                            selectMyWords();
                            M.toast({html: data.result});
                            $("#add_word #wordEnglish").val("");$("#add_word #wordArabic").val("");
                        }
                    },
                    error: function () {
                        var toastHTML = '<span>حدث خطأ غير متوقع<i class="material-icons right red-text text-lighten-2">close</i></span>';
                        M.toast({html: toastHTML});
                        $(".backLoading").toggleClass("hide");
                    }
                });
            } else {
                var toastHTML = '<span>تاكد من ان كل كلمة في حقلها الصحيح<i class="material-icons right red-text text-lighten-2">close</i></span>';
                M.toast({html: toastHTML, displayLength: 5000}); 
            }
            
        } else {
            var toastHTML = '<span>قم بملئ الحقلين بالقيم المطلوبة<i class="material-icons right red-text text-lighten-2">close</i></span>';
            M.toast({html: toastHTML, displayLength: 4500});
        }
    });
    
    
    // اعديل كلمة
    $("body").on("click", ".collapsible [href='#edit']", function () {
        $("#edit").data("key", $(this).data("key"));
        btnEdit = $(this);
        key =  $("#edit").data("key");
        $.ajax({
            url: "Ajax/allProcc.php",
            method: "POST",
            data: {getWord: key},
            beforeSend: function () {
                $(".backLoading").toggleClass("hide");
            },
            success: function (data) {
                $(".backLoading").toggleClass("hide");
                $("#edit #editWordEnglish").val(data.word_english);
                $("#edit #editWordArabic").val(data.word_arabic);
            },
            error: function () {
                var toastHTML = '<span>حدث خطأ غير متوقع<i class="material-icons right red-text text-lighten-2">close</i></span>';
                M.toast({html: toastHTML});
                $(".backLoading").toggleClass("hide");
            }
        });
    });
    
    $("body").on("click", "#edit button", function (e) {
        e.preventDefault();
        wordEnglish = $("#edit #editWordEnglish").val();
        wordArabic = $("#edit #editWordArabic").val();
        key = $(this).parents("#edit").data("key");
        
        if ( $("#edit #editWordEnglish").val() && $("#edit #editWordArabic").val() ) {
            
            if ( wordEnglish.charCodeAt(0) < 200 && wordArabic.charCodeAt(0) > 1500 ) {
                $.ajax({
                    url: "Ajax/allProcc.php",
                    method: "POST",
                    data: {update: key, wordEnglish: wordEnglish, wordArabic: wordArabic},
                    beforeSend: function () {
                        $(".backLoading").toggleClass("hide");
                    },
                    success: function (data) {
                        $(".backLoading").toggleClass("hide");
                        if ( data.msg == "Error" ) {
                            for(i=0; i < data.result.length; i++){
                                M.toast({html: data.result[i]});
                            }
                        } else {
                            M.toast({html: data.result});
                            if ( btnEdit.hasClass("pageMyWord") ) {
                                selectMyWords();
                            } else {
                                selectWordsSearch();
                            }
                            $('.modal').modal('close');
                        }
                    },
                    error: function () {
                        var toastHTML = '<span>حدث خطأ غير متوقع<i class="material-icons right red-text text-lighten-2">close</i></span>';
                        M.toast({html: toastHTML});
                        $(".backLoading").toggleClass("hide");
                    }
                });
            } else {
                var toastHTML = '<span>تاكد من ان كل كلمة في حقلها الصحيح<i class="material-icons right red-text text-lighten-2">close</i></span>';
                M.toast({html: toastHTML, displayLength: 5000}); 
            }
            
        } else {
            var toastHTML = '<span>قم بملئ الحقلين بالقيم المطلوبة<i class="material-icons right red-text text-lighten-2">close</i></span>';
            M.toast({html: toastHTML, displayLength: 5000});
        }
    });
    
    // حذف كلمة
    $("body").on("click", ".collapsible [href='#delete']", function () {
        btn = $(this);
        $("#delete .yes-delete").data("key", $(this).data("key"));
    });
    $("body").on("click", "#delete .yes-delete", function () {
        key = $(this).data("key");
        $.ajax({
            url: "Ajax/allProcc.php",
            method: "POST",
            data: {delete: key},
            beforeSend: function () {
                $(".backLoading").toggleClass("hide");
            },
            success: function (data) {
                $(".backLoading").toggleClass("hide");
                M.toast({html: data.result});
                if ( btn.hasClass("pageMyWord") ) {
                    selectMyWords();
                } else {
                    selectWordsSearch();
                }
            },
            error: function () {
                var toastHTML = '<span>حدث خطأ غير متوقع<i class="material-icons right red-text text-lighten-2">close</i></span>';
                M.toast({html: toastHTML});
                $(".backLoading").toggleClass("hide");
            }
        });
    });
    
    
   $("body").on("click", ".card-tabs [href='#add_word']", function () {
        selectMyWords();
    });
    
    // جلب كلماتي
    selectMyWords();
    function selectMyWords() {
        $.ajax({
            url: "Ajax/allProcc.php",
            method: "POST",
            data: {selectMyWord: "true"},
            beforeSend: function () {
                $(".loadingAfterSelect").toggleClass("hide");
            },
            success: function (data) {
                if ( data.status != "Not Found" ) {
                    $("#my_words .collapsible").html("");
                    $(".loadingAfterSelect").toggleClass("hide");
                    exeLib = true;
                    for ( i=0;i<data.length;i++ ) {
                        wordEnglish = $("<div class='collapsible-header' dir='ltr'></div>").html(data[i].word_english);
                        icon = $("<i class='material-icons left dropdown-trigger' style='position: absolute;right: 10px;top: 15px;' data-target='actionsMyWord"+i+"'></i>").text("more_vert");
                        if ( data[i].share == 0 ) {
                            share = $("<li></li>").html("<a href='#!' class='pageMyWord' id='share' data-key='"+data[i].key_hash+"'><i class='material-icons indigo-text'>share</i>مشاركتها مع الاخرين</a>");
                        } else {
                            share = $("<li></li>").html("<a href='#!' class='pageMyWord' id='share' data-key='"+data[i].key_hash+"'><i class='material-icons indigo-text'>share</i>إلغاء المشاركة</a>");
                        }
                        liEdit = $("<li></li>").html("<a class='modal-trigger pageMyWord' data-key='"+data[i].key_hash+"' href='#edit'><i class='material-icons teal-text'>create</i>تعديل</a>");
                        liDelete = $("<li></li>").html("<a class='modal-trigger pageMyWord' data-key='"+data[i].key_hash+"' href='#delete'><i class='material-icons red-text'>delete</i>حذف</a>");
                        ul = $("<ul id='actionsMyWord"+i+"' class='dropdown-content'></ul>").append(share, liEdit, liDelete);
                        wordArabic = $("<div class='collapsible-body'><span></span></div>").html(data[i].word_arabic);
                        liParent = $("<li style='position: relative'></li>")
                                .append(wordEnglish, icon, ul, wordArabic);
                        $("#my_words .collapsible").append(liParent);
                        $('.dropdown-trigger').dropdown({constrainWidth: false});
                    }
                } else {
                    $("#my_words .collapsible").html(data.result);
                    $(".loadingAfterSelect").toggleClass("hide");
                }
                countWord(); // لعرض عدد الكلمات
            },
            error: function () {
                var toastHTML = '<span>حدث خطأ غير متوقع<i class="material-icons right red-text text-lighten-2">close</i></span>';
                M.toast({html: toastHTML});
                $(".loadingAfterSelect").toggleClass("hide");
            }
        });
    }
    
    function countWord(){
        $.ajax({
            url: "Ajax/allProcc.php",
            method: "POST",
            data: {countWord: "true"},
            success: function (data) {
                $("#add_word h5 span").text("[" + data.countWord + "]");
                if ( data.countWord >= 10 ) {
                    $(".card-tabs .exam").removeClass("disabled");
                } else {
                    $(".card-tabs .exam").addClass("disabled");
                }
            }
        });
    }
    
    // المشاركة مع الاخرين
    $("body").on("click", "#my_words #share, #search_word #share", function () {
        btnShare = $(this);
        key = $(this).data("key");
        $.ajax({
            url: "Ajax/allProcc.php",
            method: "POST",
            data: {share: key},
            beforeSend: function () {
                $(".loadingSearch").toggleClass("hide");
            },
            success: function (data) {
                $(".loadingSearch").toggleClass("hide");
                if ( btnShare.hasClass("pageMyWord") ) {
                    selectMyWords();
                } else {
                    selectWordsSearch();
                }
                M.toast({html: data.result});
            },
            error: function () {
                var toastHTML = '<span>حدث خطأ غير متوقع<i class="material-icons right red-text text-lighten-2">close</i></span>';
                M.toast({html: toastHTML});
                $(".loadingSearch").toggleClass("hide");
            }
        });
    });
    
    // تعديل بياناتي
    $("body").on("click", "nav [href='#editMyData'], .sidenav [href='#editMyData']", function () {
        $.ajax({
            url: "Ajax/allProcc.php",
            method: "POST",
            data: {editData: "true"},
            beforeSend: function () {
                $(".loadingAfterSelect").toggleClass("hide");
            },
            success: function (data) {
                $(".loadingAfterSelect").toggleClass("hide");
                $("#editMyData #username").val(data.result.username);
                $("#editMyData #password").val("");
                $("#editMyData #friend").val(data.result.friend);
                $("#editMyData #work").val(data.result.work);
                if ( data.result.share_words == "on" ) {
                    $("#editMyData .switch input").attr("checked", "checked");
                }
            },
            error: function () {
                var toastHTML = '<span>حدث خطأ غير متوقع<i class="material-icons right red-text text-lighten-2">close</i></span>';
                M.toast({html: toastHTML});
                $(".loadingAfterSelect").toggleClass("hide");
            }
        });
    });

    $("body").on("click", "#editMyData .save-data", function () {
        username = $("#editMyData #username").val();
        password = $("#editMyData #password").val();
        friend = $("#editMyData #friend").val();
        work = $("#editMyData #work").val();
        if ($("#editMyData #share").is(":checked"))
        {
            share = "on";
        } else {
            share = "off";
        }
        $.ajax({
            url: "Ajax/allProcc.php",
            method: "POST",
            data: {updateData: "true", editUsername: username, editPassword: password, editFriend: friend, editWork: work, editShare: share},
            beforeSend: function () {
                $(".backLoading").toggleClass("hide");
            },
            success: function (data) {
                $(".backLoading").toggleClass("hide");
                if ( data.msg == "Error" ) {
                    for ( i=0; i<data.result.length; i++ ) {
                        M.toast({html: data.result[i]});
                    }
                } else {
                    $("nav [href='#editMyData']").text(username);
                    $('.modal').modal('close');
                    M.toast({html: data.result});
                }
            },
            error: function () {
                var toastHTML = '<span>حدث خطأ غير متوقع<i class="material-icons right red-text text-lighten-2">close</i></span>';
                M.toast({html: toastHTML});
                $(".backLoading").toggleClass("hide");
            }
        });
    });
    // جلب كلمات الأخرين
    function selectWordsPeople() {
        $.ajax({
            url: "Ajax/allProcc.php",
            method: "POST",
            data: {selectWordsPeople: "true"},
            beforeSend: function () {
                $(".loadinggetWords").toggleClass("hide");
            },
            success: function (data) {
                $("#show_words_people .collapsible").html("");
                if ( data.msg == "Error" ) {
                    $("#show_words_people .collapsible").html(data.result);
                    $(".loadinggetWords").toggleClass("hide");
                } else {
                    $(".loadinggetWords").toggleClass("hide");
                    for ( i=0; i < data.wordsPeople.length; i++ ) {
                        word_english = $("<div class='collapsible-header' dir='ltr'></div>").html(data.wordsPeople[i].word_english);
                        icon = $("<i class='material-icons left dropdown-trigger' style='position: absolute;right: 10px;\n\
                        top: 15px' data-target='actionsMyWordInPagePeople"+i+"'></i>").text("more_vert");
                        liAdd = $("<li></li>").html("<a id='save_word' href='#!' data-key='"+data.wordsPeople[i].key_hash+"'>\n\
                        <i class='material-icons brown-text'>save</i>اضافة الى قاموسي</a>");
                        liReport = $("<li></li>").html("<a class='modal-trigger' href='#reporting' data-key='"+data.wordsPeople[i].id+"'>\n\
                        <i class='material-icons red-text'>warning</i>ابلاغ</a>");
                        menu = $("<ul id='actionsMyWordInPagePeople"+i+"' class='dropdown-content'></ul>").append(liAdd, liReport);
                        word_arabic = $("<div class='collapsible-body'></div>").html("<span>"+data.wordsPeople[i].word_arabic+"</span>");
                        liParent = $("<li style='position: relative'></li>").append(word_english, icon, menu, word_arabic);
                        $("#show_words_people .collapsible").append(liParent);
                        $('.dropdown-trigger').dropdown({constrainWidth: false});
                    }
                }
            },
            error: function () {
                var toastHTML = '<span>حدث خطأ غير متوقع<i class="material-icons right red-text text-lighten-2">close</i></span>';
                M.toast({html: toastHTML});
                $(".loadinggetWords").toggleClass("hide");
            }
        });
    }
    
    $("body").on("click", ".card-tabs [href='#show_words_people']", function () {
        selectWordsPeople();
    });
    
    
    // ابلاغ
    $("body").on("click", "#words_people .collapsible [href='#reporting']", function () {
        $("#reporting .report").data("key", $(this).data("key"));
    });
    $("#reporting .report").click(function () {
        key = $(this).data("key");
        $.ajax({
            url: "Ajax/allProcc.php",
            method: "POST",
            data: {sendReporting: key, report: $("#reporting textarea").val()},
            beforeSend: function () {
                $(".backLoading").toggleClass("hide");
            },
            success: function (data) {
                $(".backLoading").toggleClass("hide");
                M.toast({html: data.result});
            },
            error: function () {
                var toastHTML = '<span>حدث خطأ غير متوقع<i class="material-icons right red-text text-lighten-2">close</i></span>';
                M.toast({html: toastHTML});
                $(".backLoading").toggleClass("hide");
            }
        });
    });
    
    // اضافة الى قاموسي
    $("body").on("click", "#words_people .collapsible #save_word", function () {
        key = $(this).data("key");
        $.ajax({
            url: "Ajax/allProcc.php",
            method: "POST",
            data: {save_word: key},
            beforeSend: function () {
                $(".loadinggetWords").toggleClass("hide");
            },
            success: function (data) {
                $(".loadinggetWords").toggleClass("hide");
                selectWordsPeople();
                M.toast({html: data.result});
            },
            error: function () {
                var toastHTML = '<span>حدث خطأ غير متوقع<i class="material-icons right red-text text-lighten-2">close</i></span>';
                M.toast({html: toastHTML});
                $(".loadinggetWords").toggleClass("hide");
            }
        });
    });
    
    function selectWordsSearch() {
        $.ajax({
            url: "Ajax/allProcc.php",
            method: "POST",
            data: {search: $("#search_word input").val()},
            beforeSend: function () {
                $(".loadingSearch").toggleClass("hide");
            },
            success: function (data) {
                $(".loadingSearch").toggleClass("hide");
                $("#search_word .collapsible").html("");
                if ( data.msg == "Error" ) {
                     $("#search_word .collapsible").html(data.result);
                } else {
                    $("#search_word .collapsible").html("");
                    exeLib = true;
                    for ( i=0;i<data.result.length;i++ ) {
                        wordEnglish = $("<div class='collapsible-header' dir='ltr'></div>").html(data.result[i].word_english);
                        icon = $("<i class='material-icons left dropdown-trigger' style='position: absolute;right: 10px;top: 15px;' data-target='actionsSearchWord"+i+"'></i>").text("more_vert");
                        if ( data.result[i].share == 0 ) {
                            share = $("<li></li>").html("<a href='#!' id='share' data-key='"+data.result[i].key_hash+"'><i class='material-icons indigo-text'>share</i>مشاركتها مع الاخرين</a>");
                        } else {
                            share = $("<li></li>").html("<a href='#!' id='share' data-key='"+data.result[i].key_hash+"'><i class='material-icons indigo-text'>share</i>إلغاء المشاركة</a>");
                        }
                        liEdit = $("<li></li>").html("<a class='modal-trigger' data-key='"+data.result[i].key_hash+"' href='#edit'><i class='material-icons teal-text'>create</i>تعديل</a>");
                        liDelete = $("<li></li>").html("<a class='modal-trigger' data-key='"+data.result[i].key_hash+"' href='#delete'><i class='material-icons red-text'>delete</i>حذف</a>");
                        ul = $("<ul id='actionsSearchWord"+i+"' class='dropdown-content'></ul>").append(share, liEdit, liDelete);
                        wordArabic = $("<div class='collapsible-body'><span></span></div>").html(data.result[i].word_arabic);
                        liParent = $("<li style='position: relative'></li>")
                                .append(wordEnglish, icon, ul, wordArabic);
                        $("#search_word .collapsible").append(liParent);
                        $('.dropdown-trigger').dropdown({constrainWidth: false});
                    }
                }
            },
            error: function () {
                var toastHTML = '<span>حدث خطأ غير متوقع<i class="material-icons right red-text text-lighten-2">close</i></span>';
                M.toast({html: toastHTML});
                $(".loadingSearch").toggleClass("hide");
            }
        });
    }
    
    // البحث
   $("body").on("keyup", "#search_word input", function () {
       $("#search_word #show_search h4").text("[ " + $(this).val() + " ]");
        selectWordsSearch();
    });
    
//    function countExam(){
//        $.ajax({
//            url: "Ajax/allProcc.php",
//            method: "POST",
//            data: {countExam: "true"},
//            beforeSend: function () {
//                $(".backLoading").toggleClass("hide");
//            },
//            success: function (data) {
//                $(".backLoading").toggleClass("hide");
//                $("#exam #page1 #countExam").html(data);
//            }
//        });
//    }
    
    allExam = [];
    chooseLang = "";
    $("body").on("click", "#exam #page1 button", function () {
        if ( $("#exam #page1 #chooseExam").val() != null ) {
            chooseLang = $("#exam #page1 #chooseExam").val();
            $(".card-tabs li").addClass("disabled").removeClass("exam"); // الغاء تفعيل القوائم
            $("#exam #page1").addClass("hide");
            
            $.ajax({
                url: "Ajax/allProcc.php",
                method: "POST",
                data: {getExam: $("#exam #page1 #chooseExam").val()},
                beforeSend: function () {
                    $(".backLoading").toggleClass("hide");
                },
                success: function (data) {
                    allExam = data;
                    newQustions();
                    $(".backLoading").toggleClass("hide");
                },
                error: function () {
                    var toastHTML = '<span>حدث خطأ غير متوقع<i class="material-icons right red-text text-lighten-2">close</i></span>';
                    M.toast({html: toastHTML});
                    $(".backLoading").toggleClass("hide");
                }
            });
            
            $("#exam #page2").removeClass("hide");
            
        } else {
            M.toast({html: "قم بتحديد طريقة الامتحان"});
        }
    });
    
    function shuffle(arr) {
        for(var j, x, i = arr.length; i; j = parseInt(Math.random() * i), x = arr[--i], arr[i] = arr[j], arr[j] = x);
        return arr;
    }
    
    function newQustions() { // اضافة سؤوال جديد
        if ( chooseLang == "arabic" ) { // لعدم جلب هذه الكلمة مع الكلمات الخاطئة
            randVal = allExam[0].word_english;
        } else {
            randVal = allExam[0].word_arabic;
        }
        $.ajax({
            url: "Ajax/allProcc.php",
            method: "POST",
            data: {rand: "true", word: randVal, typeWord: chooseLang},
            beforeSend: function () {
                  $(".backLoading").toggleClass("hide");
            },
            success: function (data) {
                  $(".backLoading").toggleClass("hide");
                  $("#exam #page2 ul").html("");
                  ol = $("<ul></ul>");
                  if ( chooseLang == "arabic" ) {
                      qustion = $("<h5 data-success='"+allExam[0].word_english+"'></h5>").text("مامعنى كلمة [" + allExam[0].word_arabic + "].");
                      data.push(allExam[0]);
                      shuffle(data);
                      for ( i=0; i<data.length; i++ ) {
                          ol.append($("<li></li>").html("<p><label><input class='with-gap' name='group' value='"+data[i].word_english+"' type='radio' /><span>"+data[i].word_english+"</span></label></p>"));
                      }
                  } else {
                      qustion = $("<h5 data-success='"+allExam[0].word_arabic+"'></h5>").text("مامعنى كلمة [" + allExam[0].word_english + "].");
                      data.push(allExam[0]);
                      shuffle(data);
                      for ( i=0; i<data.length; i++ ) {
                          ol.append($("<li></li>").html("<p><label><input class='with-gap' name='group' value='"+data[i].word_arabic+"' type='radio' /><span>"+data[i].word_arabic+"</span></label></p>"));
                      }
                  }
                  liParent = $("<li></li>").append(qustion, ol);
                  $("#exam #page2 ul").html(liParent);
            },
            error: function () {
                var toastHTML = '<span>حدث خطأ غير متوقع<i class="material-icons right red-text text-lighten-2">close</i></span>';
                M.toast({html: toastHTML});
                $(".backLoading").toggleClass("hide");
                $(".card-tabs li").removeClass("disabled").addClass("exam"); // الغاء تفعيل القوائم
                $("#exam #page1").removeClass("hide");
                $("#exam #page2").addClass("hide");
            }
          });
    }

    $("body").on("click", "#exam #page2 [name='check']", function () {
        if ( $("#exam #page2 ul input").is(":checked") ) {
            if ( $("#exam #page2 h5").data("success") == $("#exam #page2 ul input:checked").val() ) {
                msg = "<p>الاجابة صحيحة <i class='material-icons right green-text text-green'>done_all</i></p>";
                M.toast({html: msg, displayLength: 1500});
                if ( allExam.length == 1 ) {
                    $(".card-tabs li").removeClass("disabled").addClass("exam"); // الغاء تفعيل القوائم
                    $("#exam #page1").removeClass("hide");
                    $("#exam #page2").addClass("hide");
                    $('#endExam').modal('open');
                } else {
                    allExam.shift();
                    newQustions();
                }
            } else {
                msg = "<p>الاجابة خاطئة <i class='material-icons right red-text text-green'>close</i></p>";
                M.toast({html: msg, displayLength: 1500});
            }
        } else {
            msg = "<p>قم بالاختيار اولا <i class='material-icons right red-text text-green'>close</i></p>";
            M.toast({html: msg, displayLength: 1500});
        }
    });
    
    // زر خروج
    $("body").on("click", "#exam #page2 [name='exit']", function () {
            $(".card-tabs li").removeClass("disabled").addClass("exam"); // الغاء تفعيل القوائم
            $("#exam #page1").removeClass("hide");
            $("#exam #page2").addClass("hide");
    });
    
    /* END Page Home */
});