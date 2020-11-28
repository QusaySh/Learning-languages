<?php
require '../../init.php';
ob_start();

if ( isset($_POST["getReporting"]) ) { // جلب التقارير
    $obgetReport = new InsertWords();
    $obgetReport->select("r.*, u.username, w.word_english, w.word_arabic, w.user_id as UserId", "reporting as r, users as u, the_words as w", "where r.user_id = u.id AND r.id_word = w.id ORDER BY r.id DESC");
    $obgetReport->execute();
    if ( $obgetReport->rowCount() > 0 ) {
        $allReport["result"] = $obgetReport->fetchAll();
        $allReport["msg"] = "Success";
    } else {
        Messages::setMsg("تنبيه", "لايوجد ابلاغات", "orange accent-2");
        $allReport["result"] = Messages::getMsg();
        $allReport["msg"] = "Error";
    }
        header("content-type: applection/json");
        echo json_encode($allReport);
}
?>
    
<?php
    if ( isset($_POST["countReport"]) ) { // عدد التقارير
        $obCountReport = new InsertWords();
        $obCountReport->select("count(id) as countReport", "reporting");
        $obCountReport->execute();
        $count = $obCountReport->fetch();
        header("Content-type: applection/json");
        echo json_encode($count);
    }
    if ( isset($_POST["countWord"]) ) { // عدد الكلمات
        $obCountReport = new InsertWords();
        $obCountReport->select("count(id) as countWord", "the_words");
        $obCountReport->execute();
        $count = $obCountReport->fetch();
        header("content-type: applection/json");
        echo json_encode($count);
    }

    if ( isset($_POST["countUser"]) ) { // عدد المستخدمين
        $obCountReport = new InsertWords();
        $obCountReport->select("count(id) as countUser", "users");
        $obCountReport->execute();
        $count = $obCountReport->fetch();
        header("content-type: applection/json");
        echo json_encode($count);
    }
?>

<?php
    if ( isset($_POST["deleteReportOnly"]) ) { // حذف ابلاغ
        $deleteReport = new InsertWords();
        $deleteReport->delete("reporting", "WHERE key_hash = ?");
        if ( $deleteReport->execute(array($_POST["deleteReportOnly"])) ){
            Messages::setMsgSuccess("تم حذف الابلاغ بنجاح", "green", "done_all");
            $msg = Messages::getMsg();
        } else {
            Messages::setMsgError("فشل حذف الابلاغ", "darken-2", "close");
            $msg = Messages::getMsg();
        }
        header("content-type: applection/json");
        echo json_encode($msg);
    }
    
    if ( isset($_POST["deleteReport"]) && isset($_POST["deleteWord"]) ) { // حذف ابلاغ والكلمة
        $deleteReport = new InsertWords();
        $deleteReport->delete("reporting", "WHERE key_hash = ?");
        
        $deleteReportAndWord = new InsertWords();
        $deleteReportAndWord->delete("the_words", "Where id = ?");
        
        if ( $deleteReport->execute(array($_POST["deleteReport"])) && $deleteReportAndWord->execute(array($_POST["deleteWord"])) ){
            Messages::setMsgSuccess("تم حذف الابلاغ والكلمة بنجاح", "green", "done_all");
            $msg = Messages::getMsg();
        } else {
            Messages::setMsgError("فشل حذف الابلاغ", "darken-2", "close");
            $msg = Messages::getMsg();
        }
        header("content-type: applection/json");
        echo json_encode($msg);
    }
?>

<?php
//    if ( isset($_POST["idUser"]) && isset($_POST["idSendReport"]) ) { // جلب اسماء الذي ابلغ وصاحب الكلمة
//        $getName = new InsertWords();
//        $getName->select("username, id", "users", "where id in({$_POST["idUser"]},{$_POST["idSendReport"]})");
//        $getName->execute(array($_POST["idUser"]));
//        $ID = $getName->fetchAll();
//        header("Content-type: application/json");
//        echo json_encode($ID);
//    }
?>

<?php
//    if ( isset($_POST["message"]) && isset($_POST["sendTo"]) ) {
//        $addMessage = new InsertWords();
//        $key_hash = uniqid("message", true);
//        $addMessage->insert("messages", "key_hash, message, user_id", "?,?,?");
//        if ( $addMessage->execute(array($key_hash, $_POST["message"], $_POST["sendTo"])) ) {
//            $result["msg"] = "Success";
//            Messages::setMsgSuccess("تم ارسال الرسالة", "green", "done_all");
//            $result["result"] = Messages::getMsg();
//        } else {
//            $result["msg"] = "Error";
//            Messages::setMsgSuccess("فشل ارسال الرسالة", "red", "close");
//            $result["result"] = Messages::getMsg();
//        }
//        header("Content-type: application/json");
//        echo json_encode($result);
//    }
?>

<?php
    if ( isset($_POST["getUsers"]) ) {
        $getUsers = new Sign();
        $getUsers->select("*", "users", "ORDER BY role DESC, username ASC");
        $getUsers->execute();
        $users = $getUsers->fetchAll();
        if ( empty($users) ) {
            $result["msg"] = "Erorr";
            Messages::setMsg("تنبيه", "لايوجد مستخدمين", "orange accent-2");
            $result["result"] = Messages::getMsg();
        } else {
            $result["msg"] = "Success";
            $result["result"] = $users;
        }
        header("content-type: application/json");
        echo json_encode($result);
    }
?>

<?php
    if ( isset($_POST["deleteUser"]) ) { // حذف ابلاغ
        $deleteUser = new Sign();
        $deleteUser->delete("users", "WHERE key_hash = ?");
        if ( $deleteUser->execute(array($_POST["deleteUser"])) ){
            Messages::setMsgSuccess("تم حذف المستخدم بنجاح", "green", "done_all");
            $msg = Messages::getMsg();
        } else {
            Messages::setMsgError("فشل حذف المستخدم", "darken-2", "close");
            $msg = Messages::getMsg();
        }
        header("content-type: applection/json");
        echo json_encode($msg);
    }
?>

<?php
    if ( isset($_POST["role"]) ) {
        $role = new Sign();
        $role->select("role", "users", "where key_hash = ?");
        $role->execute(array($_POST["role"]));
        $theRole = $role->fetch();
        if ( $theRole["role"] == "0" ) {
            $role->update("users", "role = 1", "where key_hash = ?");
            $role->execute(array($_POST["role"]));
            Messages::setMsgSuccess("تم وضع المستخدم كــ ادمن", "green", "done_all");
            $msg = Messages::getMsg();
        } else {
            $role->update("users", "role = 0", "where key_hash = ?");
            $role->execute(array($_POST["role"]));
            Messages::setMsgSuccess("تم ازالة المستخدم من وضع الادمن", "green", "done_all");
            $msg = Messages::getMsg(); 
        }
        header("content-type: applection/json");
        echo json_encode($msg);
    }
?>

<?php
    if ( isset($_POST["getWordsOrderLang"]) ) { // جلب الكلمات حسب اللغة
        $getWord = new InsertWords();
        $getWord->select("w.*, u.username, u.language", "the_words as w, users as u", "WHERE w.user_id = u.id AND w.language = ? ORDER by w.id DESC");
        $getWord->execute(array($_POST["getWordsOrderLang"]));
        $words = $getWord->fetchAll();
        if ( empty($words) ) {
            $result["msg"] = "Erorr";
            Messages::setMsg("تنبيه", "لايوجد كلمات", "orange accent-2");
            $result["result"] = Messages::getMsg();
        } else {
            $result["msg"] = "Success";
            $result["result"] = $words;
        }
        header("content-type: application/json");
        echo json_encode($result);
    }
?>

<?php
    if ( isset($_POST["getWordsOrderName"]) ) { // جللب الكلمات حسب الاسم
        $getWord = new InsertWords();
        $getWord->select("w.*, u.username, u.language", "the_words as w, users as u", "WHERE w.user_id = u.id AND w.user_id = ? ORDER by w.id DESC");
        $getWord->execute(array($_POST["getWordsOrderName"]));
        $words = $getWord->fetchAll();
        if ( empty($words) ) {
            $result["msg"] = "Erorr";
            Messages::setMsg("تنبيه", "لايوجد كلمات", "orange accent-2");
            $result["result"] = Messages::getMsg();
        } else {
            $result["msg"] = "Success";
            $result["result"] = $words;
        }
        header("content-type: application/json");
        echo json_encode($result);
    }
?>

<?php
    if ( isset($_POST["getWords"]) ) {
        $getWord = new InsertWords();
        $getWord->select("w.*, u.username, u.language", "the_words as w, users as u", "WHERE w.user_id = u.id ORDER by w.id DESC");
        $getWord->execute();
        $words = $getWord->fetchAll();
        if ( empty($words) ) {
            $result["msg"] = "Erorr";
            Messages::setMsg("تنبيه", "لايوجد كلمات", "orange accent-2");
            $result["result"] = Messages::getMsg();
        } else {
            $result["msg"] = "Success";
            $result["result"] = $words;
        }
        header("content-type: application/json");
        echo json_encode($result);
    }
?>

<?php
    if ( isset($_POST["deleteWord"]) ) { // حذف كلمة
        $deleteWord = new Sign();
        $deleteWord->delete("the_words", "WHERE key_hash = ?");
        if ( $deleteWord->execute(array($_POST["deleteWord"])) ){
            Messages::setMsgSuccess("تم حذف الكلمة بنجاح", "green", "done_all");
            $msg = Messages::getMsg();
        } else {
            Messages::setMsgError("فشل حذف الكلمة", "darken-2", "close");
            $msg = Messages::getMsg();
        }
        header("content-type: applection/json");
        echo json_encode($msg);
    }
?>

<?php
ob_end_flush();
?>