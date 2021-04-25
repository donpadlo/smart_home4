<?php

# Исходный код Smart Home доступен по лицензии GPL3
# Используемые компоненты - по своим лицензиям
# Изначальный автор: Грибов Павел
# https://грибовы.рф
class TDevices {
    public static function GetDeviceInfo($sqln,$device) {            
        $device_info["name"]="";
        $device_info["comment"]="";
        $sql="select * from devices where id=$device";        
        $stmt3=$sqln->dbh->prepare($sql);
        $stmt3->execute();
        $data = $stmt3->fetchAll(PDO::FETCH_ASSOC);           
        foreach ($data as $dev){
            $device_info["name"]=$dev["name"];
            $device_info["comment"]=$dev["name"];
        }; 
        // расширенная информация
        $sql="SELECT * FROM devices_info inner join devices_info_groups on devices_info_groups.id=devices_info.deviceinfogroup WHERE devices_info.device=$device";
        $stmt3=$sqln->dbh->prepare($sql);
        $stmt3->execute();
        $data = $stmt3->fetchAll(PDO::FETCH_ASSOC);           
        foreach ($data as $dev){
          $device_info[$dev["name"]]=$dev["value"];
        };
        return $device_info;
    }
    public static function GetLastStorageValue($sqln,$device,$datatype) {            
        $st["value"]=0;
        $st["dname"]="Non";
        $st["dt"]="2000-01-01 00:00:00";
        $st["timeout"]=1000;
        $sql="select (UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(storage.dt)) as timeout,storage.dt,storage.value,data_types.id as dtype,data_types.name as dname,data_types.comment as dcomment from storage inner join data_types on data_types.id=storage.datatype where storage.device=$device and data_types.id=".$datatype." order by storage.id desc limit 1";        
        //echo "$sql</br>";
        $stmt3=$sqln->dbh->prepare($sql);
        $stmt3->execute();
        $data = $stmt3->fetchAll(PDO::FETCH_ASSOC);           
        foreach ($data as $dev){
            $st["dname"]=$dev["dname"];
            $st["value"]=$dev["value"];
            $st["dt"]=$dev["dt"];
            $st["timeout"]=$dev["timeout"];
        }; 
        return $st;
        
    }
} 