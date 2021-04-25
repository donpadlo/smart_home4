<?php

# Исходный код Smart Home доступен по лицензии GPL3
# Используемые компоненты - по своим лицензиям
# Изначальный автор: Грибов Павел
# https://грибовы.рф

class Tusers {
    public $id=0;
    public $login="";
    public $pass="";
    public $md5hash="";
    public $role=0; // 1 - администратор,2 - пользователь, 0 - не авторизирован
    public $dbh;
    public function __construct($sqln) {
        $this->dbh=$sqln->dbh;        
    }   
    public function LoginByCookies(){
      if (isset($_COOKIE["md5hash"])):          
           $sql="select * from users where md5hash=?";
           $stmt = $this->dbh->prepare($sql);
           $stmt->execute([$_COOKIE["md5hash"]]);
           $data = $stmt->fetchAll(PDO::FETCH_ASSOC);           
           foreach ($data as $users){
             $this->id=$users["id"];
             $this->login=$users["login"];
             $this->role=$users["role"];
             $this->pass=$users["pass"];
           };
      endif;
    }
    public function LoginByForm(){        
        if ((_POST("defaultFormLogin")!="") and (_POST("defaultFormPassword")!="")):
           $sql="select * from users where login=? and pass=?";
           $stmt = $this->dbh->prepare($sql);
           $stmt->execute([_POST("defaultFormLogin"),_POST("defaultFormPassword")]);
           $data = $stmt->fetchAll(PDO::FETCH_ASSOC);           
           foreach ($data as $users){
             $this->id=$users["id"];
             $this->login=$users["login"];
             $this->role=$users["role"];
             $this->pass=$users["pass"];             
             $this->md5hash=$users["md5hash"];             
             setcookie("login", $this->login, time()+36000);
             setcookie("md5hash", $this->md5hash, time()+36000);
           };            
        endif;
    }
    public function LogoutIf(){
        if ((_GET("defaultFormLogout")=="true")):        
            $this->id=0;
            $this->role=0;
             setcookie("login", "", time()+36000);
             setcookie("md5hash", "", time()+36000);
        endif;
    }
}   