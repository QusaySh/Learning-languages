<?php
ob_start();
require "../init.php";
//require "includeLib.php";
if ( isset($_POST["insert"]) ) {
    $obWords = new InsertWords();
    
    $obWords->setInputs($_POST["wordEnglish"], $_POST["wordArabic"]);
    if ( $obWords->checkInputs($session) ) {
        $msg["result"] = $obWords->displayMsg();
        $msg["msg"] = "Error";
    } else {
        $obWords->insertWord($session);
        Messages::setMsgSuccess("تم اضافة الكلمة بنجاح", "green", "done_all");
        $msg["result"] = Messages::getMsg();
        $msg["msg"] = "Success";
    }
    header("content-type: application/json");
    echo json_encode($msg);
}

if ( isset($_POST["getWord"]) ) {
    $obWords = new InsertWords();
    $obWords->select("word_english, word_arabic", "the_words", "where key_hash = ?");
    $obWords->execute(array($_POST["getWord"]));
    $data = $obWords->fetch();
    header("content-type: application/json");
    echo json_encode($data);
}

if ( isset($_POST["update"]) ) {
    $obWords = new InsertWords();
    
    $obWords->setInputs($_POST["wordEnglish"], $_POST["wordArabic"]);
    if ( $obWords->checkInputs($session, $_POST["update"]) ) {
        $msg["result"] = $obWords->displayMsg();
        $msg["msg"] = "Error";
    } else {
        $obWords->updateWord($_POST["update"]);
        Messages::setMsgSuccess("تم تعديل الكلمة بنجاح", "green", "done_all");
        $msg["result"] = Messages::getMsg();
        $msg["msg"] = "Success";
    }
    header("content-type: application/json");
    echo json_encode($msg);
}

if ( isset($_POST["delete"]) ) {
    $obWords = new InsertWords();
    if ( $obWords->deleteWord($_POST["delete"]) ) {
        Messages::setMsgSuccess("تم حذف الكلمة بنجاح", "green", "done_all");
        header("content-type: application/json");
        $msg["result"] = Messages::getMsg();
        echo json_encode($msg);
    }
}

?>

<?php
// نسيت كلمة المرور
if ( isset($_POST["username"]) && isset($_POST["friend"]) && isset($_POST["work"]) ) {
    $obForget = new Sign();
    if ( $obForget->checkForget($_POST["username"], $_POST["friend"], $_POST["work"]) ) {
        $msg["result"] = $obForget->displayMsg();
        $msg["msg"] = "Error";
        header("content-type: application/json");
        echo json_encode($msg);
    } else {
        $session->usernameForget = $_POST["username"];
        header("content-type: application/json");
        $msg["msg"] = "Success";
        echo json_encode($msg);
    }
}
if ( isset($_POST["changePassword"]) ) {
    $obnewPass = new Sign();
    if ( $obnewPass->newPassword($_POST["changePassword"], $session) ){
        $msg["result"] = $obnewPass->displayMsg();
        $msg["msg"] = "Error";
        header("content-type: application/json");
        echo json_encode($msg);
    } else {
        Messages::setMsgSuccess("تم تغيير كلمة المرور بنجاح", "green", "done_all");
        header("content-type: application/json");
        $msg["result"] = Messages::getMsg();
        $msg["msg"] = "success";
        echo json_encode($msg);
    }
}
?>
<?php
if ( isset($_POST["share"]) ) {
    $obWords = new InsertWords();
    $obWords->select("share", "the_words", "where key_hash = ?");
    $obWords->execute(array($_POST["share"]));
    $share = $obWords->fetch();
    if ( $share["share"] == "0" ) {
        $obWords->update("the_words", "share = '1'", "where key_hash = ?");
        $obWords->execute(array($_POST["share"]));
        Messages::setMsgSuccess("تم مشاركتها مع الآخرين", "green", "done_all");
        $msg["result"] = Messages::getMsg();
    } else {
        $obWords->update("the_words", "share = '0'", "where key_hash = ?");
        $obWords->execute(array($_POST["share"]));
        Messages::setMsgSuccess("تم الغاء مشاركتها مع الآخرين", "green", "done_all");
        $msg["result"] = Messages::getMsg();
    }
    header("content-type: appliction/json");
    echo json_encode($msg);
}

?>

<?php
if ( isset($_POST["selectMyWord"]) ) {
    $getData = new InsertWords();
    $getData->select("*", "the_words", "where user_id = ? ORDER BY id DESC");
    $getData->execute(array($session->userInfo["id"]));
    if ( $getData->rowCount() > 0 ) {
        $dataWord = $getData->fetchAll();
        header("content-type: application/json");
        echo json_encode($dataWord);
    } else {
        Messages::setMsg("تنبيه", "لايوجد لديك كلمات حاليا, قم باضافة كلمة جديدة", "orange accent-2");
        header("content-type: appliction/json");
        $msg["result"] = Messages::getMsg();
        $msg["status"] = "Not Found";
        echo json_encode($msg);
    }
}
?>
    
<?php
if ( isset($_POST["countWord"]) ) {
    $obCount = new InsertWords();
    $obCount->select("count(id) as countWord", "the_words", "where user_id = ?");
    $obCount->execute(array($session->userInfo["id"]));
    $count = $obCount->fetch();
    header("Content-type: application/json");
    echo json_encode($count);
}
?>

<?php
    if ( isset($_POST["editData"]) ) {
        $getData = new InsertWords();
        $getData->select("*", "users", "where key_hash = ?");
        $getData->execute(array($session->userInfo["key"]));
        $data["result"] = $getData->fetch();
        header("Content-type: application/json");
        echo json_encode($data);
    }
    
    if ( isset($_POST["updateData"]) ) {
        $dataUser = new Sign();
        $dataUser->setInput($_POST["editUsername"], $_POST["editPassword"], "",
                $_POST["editFriend"], $_POST["editWork"], $_POST["editShare"]);
        if ( $dataUser->checkUpdateData($session) ) {
            $msg["result"] = $dataUser->displayMsg();
            $msg["msg"] = "Error";
        } else {
            $dataUser->updateData($session);
            Messages::setMsgSuccess("تم تغيير بياناتك بنجاح", "green", "done_all");
            $msg["result"] = Messages::getMsg();
            $msg["msg"] = "Success";
        }
        header("Content-type: application/json");
        echo json_encode($msg);
    }
    
?>

<?php
    if ( isset($_POST["selectWordsPeople"]) ) {
        $getDataPeople = new InsertWords();
        $getDataPeople->select("word_english", "the_words", "where user_id = ? ORDER BY word_english ASC");
        $getDataPeople->execute(array($session->userInfo["id"]));
        $myWords = $getDataPeople->fetchAll();
        $last_word = [];
        foreach ( $myWords as $word ) {
            $last_word[] = $word["word_english"];
        }
        $getDataPeople->select("*", "the_words", "where user_id != ? AND share = '1' AND language = ? ORDER BY word_english ASC");
        $getDataPeople->execute(array($session->userInfo["id"], $session->userInfo["language"]));
        $array1["wordsPeople"] = $getDataPeople->fetchAll();
        if ( $getDataPeople->rowCount() > 0 ) {
            foreach ( $array1["wordsPeople"] as $arr ) {
                if ( in_array($arr["word_english"], $last_word) ) {
                    continue;
                } else {
                    $wordExists = true;
                    $dataP["wordsPeople"][] = $arr;
                    $dataP["msg"] = "Success";
                    $last_word[] = $arr["word_english"];
                }
            }
            if ( !isset($wordExists) ) {
                Messages::setMsg("تنبيه", "لم يتم النشر من قبل الآخرون لهذه اللغة او انه لم يقم أحد بمشاركة كلماته", "orange accent-2");
                $msg["result"] = Messages::getMsg();
                $msg["msg"] = "Error";
                header("content-type: application/json");
                echo json_encode($msg);
            } else {
                header("content-type: application/json");
                echo json_encode($dataP);
            }
        } else {
            Messages::setMsg("تنبيه", "لم يتم النشر من قبل الآخرون لهذه اللغة او انه لم يقم أحد بمشاركة كلماته", "orange accent-2");
            $msg["result"] = Messages::getMsg();
            $msg["msg"] = "Error";
            header("content-type: application/json");
            echo json_encode($msg);
        }
    }
?>

<?php
    if ( isset($_POST["sendReporting"]) ) {
        $report = new InsertWords();
        if ( empty($_POST["report"]) ) {
            Messages::setMsgError("قم بكتابة سبب الابلاغ", "darken-2", "close");
            $msg["result"] = Messages::getMsg();
        } else {
            $text = filter_var($_POST["report"], FILTER_STR);
            $key_hash = uniqid("report", true);
            $report->insert("reporting", "key_hash, report, id_word, user_id", "?,?,?,?");
            $report->execute(array($key_hash, $text, $_POST["sendReporting"], $session->userInfo["id"]));
            Messages::setMsgSuccess("تم ارسال ابلاغك, سيتم مراجعته من قبل الآدمن", "green", "done_all");
            $msg["result"] = Messages::getMsg();
        }
            header("content-type: application/json");
            echo json_encode($msg);
    }
?>

<?php
    if ( isset($_POST["save_word"]) ) {
        $save = new InsertWords();
        $save->select("word_english, word_arabic, language", "the_words", "where key_hash = ?");
        $save->execute(array($_POST["save_word"]));
        $data1 = $save->fetch();
        
        $save->select("share_words", "users", "where key_hash = ?");
        $save->execute(array($session->userInfo["key"]));
        $share = $save->fetch();
        if ( $share["share_words"] == "on" ) {
            $shareWord = 1;
        } else {
            $shareWord = 0;
        }
        
        $key_hash = uniqid("word");
        $save->insert("the_words", "key_hash, word_english, word_arabic, share, language, user_id", "?,?,?,?,?,?");
        $save->execute(array($key_hash, $data1["word_english"], $data1["word_arabic"], $shareWord, $data1["language"], $session->userInfo["id"]));
        Messages::setMsgSuccess("تم اضافتها الى قاموسك", "green", "done_all");
        header("content-type: application/json");
        $msg["result"] = Messages::getMsg();
        echo json_encode($msg);
    }
?>
<?php
if ( isset($_POST["search"]) ) {
    $getData = new InsertWords();
    $getData->select("*", "the_words", "where word_english LIKE '%{$_POST["search"]}%' AND user_id = ?");
    $getData->execute(array($session->userInfo["id"]));
    if ( $getData->rowCount() > 0 ) {
        $dataWord = $getData->fetchAll();
        $msg["msg"] = "Success";
        $msg["result"] = $dataWord;
    } else {
        Messages::setMsg("تنبيه", "الكلمة المراد البحث عتها غير موجودة", "orange accent-2");
        $msg["msg"] = "Error";
        $msg["result"] = Messages::getMsg();
    }
    header("content-type: application/json");
    echo json_encode($msg);
}
?>

<?php
//    if ( isset($_POST["countExam"]) ) {
//        $obCount = new InsertWords();
//        $obCount->select("count(id) as countWord", "the_words", "where user_id = ?");
//        $obCount->execute(array($session->userInfo["id"]));
//        $opt = '<option disabled selected>عدد الأسئلة التي ستعرض لك</option>';
//        $opt .= '<option value="10">10</option>';
//        $count = $obCount->fetch();
//        if ( $count["countWord"] >= 20 ) {
//            $opt .= '<option value="20">20</option>';
//        }
//        if ( $count["countWord"] >= 30 ) {
//            $opt .= '<option value="30">30</option>';
//        }
//        echo $opt;
//    }
?> 
       
<?php

    if ( isset($_POST["rand"]) ) {
        $obGetExam = new InsertWords();
        if ( $_POST["typeWord"] == "arabic" ) {
            $obGetExam->select("*", "the_words", "where user_id = ? AND word_english != ? ORDER BY RAND(), id LIMIT 3");
        } else {
            $obGetExam->select("*", "the_words", "where user_id = ? AND word_arabic != ? ORDER BY RAND(), id LIMIT 3");
        }
        $obGetExam->execute(array($session->userInfo["id"], $_POST["word"]));
        $allExam = $obGetExam->fetchAll();
        header("content-type: application/json");
        echo json_encode($allExam);
    }

    if ( isset($_POST["getExam"]) ) {
        $obGetExam = new InsertWords();
        $obGetExam->select("*", "the_words", "where user_id = ? ORDER BY RAND(), id");
        $obGetExam->execute(array($session->userInfo["id"]));
        $allExam = $obGetExam->fetchAll();
        header("content-type: application/json");
        echo json_encode($allExam);
    }

    if ( isset($_POST["valueInput"]) ) {
        if ( $_POST["valueInput"] == $session->success ) {
            Messages::setMsgSuccess("الاجابة صحيحة", "green", "done_all");
            echo Messages::getMsg();
        } else {
            Messages::setMsgError("الاجابة خاطئة", "darken-2", "close");
            header("HTTP/1.0 404 Not Found");
            echo Messages::getMsg();
        }
    }
?>

<?php
    ob_end_flush();
?>