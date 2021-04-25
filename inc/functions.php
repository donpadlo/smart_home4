<?php

# Исходный код Smart Home доступен по лицензии GPL3
# Используемые компоненты - по своим лицензиям
# Изначальный автор: Грибов Павел
# https://грибовы.рф

function HumanDate($dt){
    $dt=(new DateTime($dt))->format('d.m.Y h:i:s');
    return $dt;
}
/**
 * Возвращает значение $_GET[$name] или $def
 * @param string $name
 * @param string $def
 * @return string
 */
function GetDef($name, $def = '') {
	global $PARAMS;
	if (isset($_GET[$name])) {
		return $_GET[$name];
	} else if (isset($PARAMS[$name])) {
		return $PARAMS[$name];
	} else {
		return $def;
	}
}

/**
 * Возвращает значение $_POST[$name] или $def
 * @param string $name
 * @param string $def
 * @return string
 */
function PostDef($name, $def = '') {
	return (isset($_POST[$name])) ? $_POST[$name] : $def;
}

/** Проверка, а есть ли содержимое $_GET[] и присвоение пустого значения или содержимого
 * @param type $name
 * @return string
 */
function _GET($name) {
	return (isset($_GET[$name])) ? $_GET[$name] : '';
}

/** Проверка, а есть ли содержимое $_POST[] и присвоение пустого значения или содержимого
 * @param type $name
 * @return string
 */
function _POST($name) {
	return (isset($_POST[$name])) ? $_POST[$name] : '';
}

/** Получить случайный идентификатор длинной $n
 * @param type $n
 * @return string
 */
function GetRandomId($n) { // результат - случайная строка из цифр длинной n
	$id = '';
	for ($i = 1; $i <= $n; $i++) {
		$id .= chr(rand(48, 56));
	}
	return $id;
}

function ClearMySqlString($link, $text) { // чистим текст от мусора, козявок, иньекций и т.п.
	$text = trim($text);  // обрубаем пробелы слева и справа
	$text = preg_replace("/[^\x20-\xFF]/", '', @strval($text));
	$text = mysqli_real_escape_string($link, $text);
	//      $text=htmlspecialchars($text,ENT_QUOTES);
	return $text;
}
function generateSalt() {
	$salt = '';
	$length = rand(5, 10); // длина соли (от 5 до 10 сомволов)
	for ($i = 0; $i < $length; $i++) {
		$salt .= chr(rand(33, 126)); // символ из ASCII-table
	}
	return $salt;
}

function jsonExit($data) {
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($data);
	exit;
}
/**
 * Чистим ВООБЩЕ все кукисы установленные
 * @global type $_COOKIE
 */
function UnsetAllCookies(){
    global $_COOKIE;
    foreach ($_COOKIE as $key=>$value) {
    SetCookie("$key","",time()+3600000,'/'); // трем  кукисы..
    };
};

/**
 * Обновляем ВООБЩЕ все кукисы установленные
 * @global type $_COOKIE
 */
function UpdateAllCookies(){
    global $_COOKIE;
    foreach ($_COOKIE as $key=>$value) {
      SetCookie("$key","$value",strtotime('+30 days'),'/');       
    };
};
/*
 * 
 */
function ClearPath($path){
  $path= str_replace("", "", $path);    
  $path= str_replace("..", "", $path);
  $path=trim($path);
  if (strlen($path)>1){
      if ($path[0]=="/"):
        $path=mb_substr( $path, 1);  
      endif;
  };
  return $path;
};