<?php

class Sign Extends PDOConnect {
    
    private $key_hash, $username, $password, $passwordHash, $language, $shareWords, $friend, $work, $messages;
    
    private static $allowLanguages = array("English", "French", "German", "Turkish");
    
    public function setInput($username, $password, $language = null, $friend = null, $work = null, $shareWords = null) {
        $this->username = filter_var(mb_substr(trim($username), 0, 20), FILTER_STR);
        $this->password = $password;
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $this->language = $language;
        $this->friend = filter_var($friend, FILTER_STR);
        $this->work = filter_var($work, FILTER_STR);
        $this->shareWords = filter_var($shareWords, FILTER_STR);
    }
    
    public function checkSignUp() {
        if ( mb_strlen($this->username) <= 3 ) {
            Messages::setMsg("خطأ", "يجب ان يكون اسم المستخدم اكثر من ثلاث حروف", "red lighten-1");
            $this->messages[] = Messages::getMsg();
        }
        if ( mb_strlen($this->password) < 5 ) {
            Messages::setMsg("خطأ", "يجب ان تكون كلمة المرور اكثر من 5 حروف", "red lighten-1");
            $this->messages[] = Messages::getMsg();
        }
        $this->select("username", "users", "where username = ?");
        $this->execute(array($this->username));
        if ( $this->rowCount() > 0 ) {
            Messages::setMsg("خطأ", "هذا الاسم موجود مسبقا, قم بالتسجيل باسم مختلف", "red lighten-1");
            $this->messages[] = Messages::getMsg();
        }
        if ( empty($this->language ) || !in_array($this->language, self::$allowLanguages) ) {
            Messages::setMsg("خطأ", "يجب اختيار اللغة", "red lighten-1");
            $this->messages[] = Messages::getMsg();
        }
        if ( empty($this->friend) ) {
            Messages::setMsg("خطأ", "قم بكتابة اسم صديق لك لكتابتها في حال نسيت كلمة المرور", "red lighten-1");
            $this->messages[] = Messages::getMsg();
        }
        if ( empty($this->work) ) {
            Messages::setMsg("خطأ", "قم بكتابة دراستك او مهنتك لكتابتها في حال نسيت كلمة المرور", "red lighten-1");
            $this->messages[] = Messages::getMsg();
        }
        if ( !in_array($this->shareWords, array("on", "off")) ) {
            $this->shareWords = "off";
        }
        return !empty($this->messages) ? true : false;
    }
    
    public function  checkSignIn() {
        $this->select("password", "users", "where username = ?");
        $this->execute(array($this->username));
        $dataUser = $this->fetch();
        if ( $this->rowCount() > 0 ) {
            if ( !password_verify($this->password, $dataUser["password"]) ) {
                Messages::setMsg("خطأ", "كلمة المرور غير صحيحة", "red lighten-1");
                $this->messages[] = Messages::getMsg();
            }
        } else {
            Messages::setMsg("خطأ", "اسم المستخدم هذا غير موجود لدينا", "red lighten-1");
            $this->messages[] = Messages::getMsg();
        }
        
        return !empty($this->messages) ? true : false;
    }

        public function signUp($session) {
        $this->key_hash = uniqid("Learn");
        $this->insert("users", "key_hash, username, password, language, friend, work, share_words", "?,?,?,?,?,?,?");
        $this->execute(array($this->key_hash, $this->username, $this->passwordHash, $this->language, $this->friend, $this->work, $this->shareWords));
        
        $this->select("*", "users", "where key_hash = ?");
        $this->execute(array($this->key_hash));
        $dataUser = $this->fetch();
        $session->userInfo = array(
            "id" => $dataUser["id"],
            "key" => $dataUser["key_hash"],
            "username" => $dataUser["username"],
            "language" => $dataUser["language"],
            "share_words" => $dataUser["share_words"],
            "role" => $dataUser["role"]
        );
        Header::headerTo("home.php");
    }
    
    public function signIn($session) {
        $this->select("*", "users", "where username = ?");
        $this->execute(array($this->username));
        $dataUser = $this->fetch();
        
        $session->userInfo = array(
            "id" => $dataUser["id"],
            "key" => $dataUser["key_hash"],
            "username" => $dataUser["username"],
            "language" => $dataUser["language"],
            "share_words" => $dataUser["share_words"],
            "role" => $dataUser["role"]
        );
        Header::headerTo("home.php");
    }
    
    public function checkForget($username, $friend, $work) {
        $this->select("*", "users", "where username = ?");
        $this->execute(array($username));
        if ( $this->rowCount() > 0 ) {
            $data = $this->fetch();
            if ( $data["friend"] != $friend ) {
                Messages::setMsgError("اسم الصديق الذي ادخلته غير صحيح", "darken-2", "close");
                $this->messages[] = Messages::getMsg();
            }
            if ( $data["work"] != $work ) {
                Messages::setMsgError("المهنة او الدراسة التي ادخلتها غير صحيحة", "darken-2", "close");
                $this->messages[] = Messages::getMsg();
            }
        } else {
            Messages::setMsgError("اسم المستخدم غير موجود لدينا", "darken-2", "close");
            $this->messages[] = Messages::getMsg();
        }
        return !empty($this->messages) ? true : false;
    }
    
    public function newPassword($password, $session){
        if ( mb_strlen($password) < 5 ) {
            Messages::setMsgError("يجب ان تكون كلمة المرور اكثر من 5 حروف", "darken-2", "close");
            $this->messages[] = Messages::getMsg();
            return true;
        } else {
        
        $this->update("users", "password = ?", "where username = ?");
            if ( $this->execute(array(password_hash($password, PASSWORD_DEFAULT), $session->usernameForget)) ) {
                return false;
            }   
        }
    }
    
    public function checkUpdateData($session) {
        if ( mb_strlen($this->username) <= 3 ) {
            Messages::setMsgError("يجب ان يكون اسم المستخدم اكثر من ثلاث حروف", "darken-2", "close");
            $this->messages[] = Messages::getMsg();
        }
        $this->select("username", "users", "where username = ? AND id != ?");
        $this->execute(array($this->username, $session->userInfo["id"]));
        if ( $this->rowCount() > 0 ) {
            Messages::setMsgError("هذا الاسم موجود مسبقا, قم بالتسجيل باسم مختلف", "darken-2", "close");
            $this->messages[] = Messages::getMsg();
        }
        if ( empty($this->friend) ) {
            Messages::setMsgError("قم بكتابة اسم صديق لك لكتابتها في حال نسيت كلمة المرور", "darken-2", "close");
            $this->messages[] = Messages::getMsg();
        }
        if ( empty($this->work) ) {
            Messages::setMsgError("قم بكتابة دراستك او مهنتك لكتابتها في حال نسيت كلمة المرور", "darken-2", "close");
            $this->messages[] = Messages::getMsg();
        }
        if ( !in_array($this->shareWords, array("on", "off")) ) {
            $this->shareWords = "off";
        }
        return !empty($this->messages) ? true : false;
    }
    
    public function updateData($session){
        if ( empty($this->password) ) {
            $this->update("users", "username = ?, friend = ?, work = ?, share_words = ?", "where key_hash = ?");
            $this->execute(array($this->username, $this->friend, $this->work, $this->shareWords, $session->userInfo["key"]));   
        } else {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
            $this->update("users", "username = ?, password = ?, friend = ?, work = ?, share_words = ?", "where key_hash = ?");
            $this->execute(array($this->username, $this->password, $this->friend, $this->work, $this->shareWords, $session->userInfo["key"]));
        }
        $_SESSION["userInfo"]["username"] = $this->username;
        $_SESSION["userInfo"]["share_words"] = $this->shareWords;
    }

    public function selected($post, $value) {
        return $post == $value ? true : false;
    }
    
    public function displayMsg(){
        return $this->messages;
    }
    
}