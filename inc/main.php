<?php

# Исходный код Smart Home доступен по лицензии GPL3
# Используемые компоненты - по своим лицензиям
# Изначальный автор: Грибов Павел
# https://грибовы.рф


//инициализируем соединение с БД
$sqln=new Tsql($pdo_driver,$pdo_basename,$pdo_server,$pdo_username,$pdo_password);

// получаем основные параметры движка
$cfg=New Tcfg($sqln);
$cfg->GetMainParam();

// пробуем авторизоваться
$user=New Tusers($sqln);

$user->LoginByCookies(); //сначала пробуем авторизоваться по кукисам
if ($user->id==0): $user->LoginByForm();endif; // проверяем, а вдруг авторизация по логину-паролю через форму авторизации?

$user->LogoutIf(); //если ссылка на выход - то выходим и удаляем кукисы