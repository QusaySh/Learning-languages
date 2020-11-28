<?php

class Messages {    

    private static $Msg;    

    public static function setMsg( $title, $msg, $type){
        self::$Msg = 
                '<div class="card-panel ' . $type . ' white-text custom-font">
                    <b>' . $title . ': </b>' . $msg . '.
                </div>';
    }
    
    public static function setMsgError($msg, $type, $icon) {
        self::$Msg = "<p>$msg <i class='material-icons right red-text text-$type'>$icon</i></p>";
    }
    
    public static function setMsgSuccess($msg, $type, $icon) {
        self::$Msg = "<p>$msg <i class='material-icons right green-text text-$type'>$icon</i></p>";
    }

    public static function getMsg() {
        return self::$Msg;
    }
    
}
