<?php

class InsertWords extends PDOConnect {
    
    private $key_hash, $wordEnglis, $wordArabic, $share, $userId, $messages;
    
    public function setInputs( $wordEnglis, $wordArabic ) {
        $this->wordEnglis = strip_tags(trim($wordEnglis));
        $this->wordArabic = filter_var(trim($wordArabic), FILTER_STR);
    }
    
    public function checkInputs($session, $key = null) {
        if ( empty($this->wordEnglis) ) {
            Messages::setMsgError("قم بكتابة الكلمة المراد حفظ ترجمتها", "darken-2", "close");
            $this->messages[] = Messages::getMsg();
        }
        if ( empty($this->wordEnglis) ) {
            Messages::setMsgError("قم بكتابة الترجمة الخاصة بالكلمة", "darken-2", "close");
            $this->messages[] = Messages::getMsg();
        }
        $this->select("word_english", "the_words", "where word_english = ? AND user_id = ? AND key_hash != ?");
        $this->execute(array($this->wordEnglis, $session->userInfo["id"], $key));
        if ( $this->rowCount() > 0 ) {
            Messages::setMsgError("هذه الكلمة مسجلة مسبقا", "darken-2", "close");
            $this->messages[] = Messages::getMsg();
        }
        
        return !empty($this->messages) ? true : false;
    }
    
    public function insertWord($session) {
        $this->key_hash = uniqid("word");
        $this->select("share_words, language", "users", "where key_hash = ?");
        $this->execute(array($session->userInfo["key"]));
        $share = $this->fetch();
        if ( $share["share_words"] == "on" ) {
            $this->share = 1;
        } else {
            $this->share = 0;
        }
        
        $this->insert("the_words", "key_hash, word_english, word_arabic, share, user_id, language", "?,?,?,?,?,?");
        $this->execute(array($this->key_hash, $this->wordEnglis, $this->wordArabic, $this->share, $session->userInfo["id"], $share["language"]));
        
    }
    
    public function updateWord($key){
        $this->update("the_words", "word_english = ?, word_arabic = ?", "where key_hash = ?");
        $this->execute(array($this->wordEnglis, $this->wordArabic, $key));
    }

    public function deleteWord($key) {
        $this->delete("the_words", "where key_hash = ?");
        if ( $this->execute(array($key)) ){
            return true;
        } else {
            return FALSE;
        }
    }

    public function displayMsg(){
        return $this->messages;
    }
    
}

