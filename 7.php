<?php

// 7. Предложите способ упаковки следующих данных о пользователе с самым
// компактным результатом (бинарный результат допускается):

$isAdmin = false;
$isModerator = true;
$isApproved = false;
$gender = 1; // возможные значения: 0, 1, 2
$showAdultContent = false;

// Для этих данных хватит одного байта.
// 0000 0000
// два младших бита(0, 1) используются для переменной $gender
// следующий бит (2) используется для переменной $showAdultContent
// следующий бит (3) используется для переменной $isApproved
// следующий бит (4) используется для переменной $isModerator
// следующий бит (5) используется для переменной $isAdmin

define('GENDER_MASK', 3);                 // 0000 0011
define('GENDER_VALUE_0', 0);              // 0000 0000
define('GENDER_VALUE_1', 1);              // 0000 0001
define('GENDER_VALUE_2', 2);              // 0000 0010

define('BIT_SHOW_ADULT_CONTENT', 4);      // 0000 0100
define('BIT_APPROVED', 8);                // 0000 1000
define('BIT_MODERATOR', 16);              // 0001 0000
define('BIT_ADMIN', 32);                  // 0010 0000


function echo_console(string $data)
{
    echo $data . PHP_EOL;
}

$dataUser = 50; // 0011 0011
// Для получения переменной $gender нужно использовать маску
$result = $dataUser & GENDER_MASK;
switch ($result) {
    case GENDER_VALUE_0:
        $output = 'gender_value_0';
        break;
    case GENDER_VALUE_1:
        $output = 'gender_value_1';
        break;
    case GENDER_VALUE_2:
        $output = 'gender_value_2';
        break;
    default: $output = 'unknow value';
}
echo_console($output);

// пользователь админ?
if ($dataUser & BIT_ADMIN) {
    echo_console('User is admin');
}

// пользователь модератор?
if ($dataUser & BIT_MODERATOR) {
    echo_console('User is moderator');
}

$dataUser = 56; // 0011 1000
// пользователь подтвердил учетную запись?
if ($dataUser & BIT_APPROVED) {
    echo_console('User is approved');
}

$dataUser = 63; // 0011 1111
// разрешено ли пользователю показывать взрослый контент?
if ($dataUser & BIT_SHOW_ADULT_CONTENT) {
    echo_console('User can see adult content');
}

// Пользователь админ, модератор и он подтвердил учетную запись?
if ($dataUser & (BIT_ADMIN | BIT_MODERATOR | BIT_APPROVED)) {
    echo_console('User is admin, moderator and proved');
}

// Ну и дальнее любые сочетания констант.
