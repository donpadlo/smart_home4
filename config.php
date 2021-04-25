<?php

# Исходный код Smart Home доступен по лицензии GPL3
# Используемые компоненты - по своим лицензиям
# Изначальный автор: Грибов Павел
# https://грибовы.рф

$debug=true;  // вывод на экран отладочной информации и информации об ошибках


$cfg_xml= simplexml_load_file(WUO_ROOT."/../config.xml");

$pdo_driver=$cfg_xml->pdo_driver;
$pdo_server=$cfg_xml->pdo_server;
$pdo_username=$cfg_xml->pdo_username;
$pdo_password=$cfg_xml->pdo_password;
$pdo_basename=$cfg_xml->pdo_basename;

// типы хранимых данных в storage по типам данных из data_types
$sensors_array=array(1,2);    // температура,влажность
$rele_array=array(3,4);       // реле с положением вкл/выкл
$refreshtime=5000;            // время обновления показаний на странице


date_default_timezone_set('Europe/Moscow'); // Временная зона по умолчанию

// Если активен режим отладки, то показываем все ошибки и предупреждения
if ($debug) {
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
}