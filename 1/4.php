<?php

// 4. Дана функция поиска пользователей по email. Опишите, пожалуйста, какие вы
// видите потенциальные проблемы данной функции.

function searchUsersByEmail($email = '') {
//    Параметр $email не имеет описания типа, надо указать ?string и функция
//    должна иметь тип возвращаемого значения. В данном случае array.
    
//    The $email parameter has no type description, it has be specify ?string 
//    and the function must have a return type. In this case, array

    global $limit;
//    global недопустимо использовать. Изменение глобальной переменной в одной части программы, может
//    привести к краху в другой части кода.
    
//    global MUST NOT be used. Changing a global variable in one part of the program can lead 
//    to crash in another part of the code.
    
    $out = array();
//    слово array заменил бы на [], но это не обязательно
    
//    change array to short syntax []

    $query = 'SELECT * FROM users WHERE email LIKE ' . $email;
//    Добавление переменной $email, таким образом не безопасно.
//    Может быть SQL-инъекция. Нужно пользоваться pdo->bindParam
//    Выборка всех полей тоже не хорошо. Полей может быть очень много.
//    Нужно всегда перечислять те поля которые нужны.
    
//    Adding the $email variable is not safe this way. Maybe SQL injection.
//    Uses pdo->bindParam. 
//    Fetching all fields is also not good. There can be a lot of fields.
//    You should always list the fields you need.
    
    if ($res = @mysql_query($query)) {
//    Подавление ошибок через символ @ - это очень плохая практика.
//    Ошибки нужно выводить на дев окружение и логировать на прод окружении.
//    mysql_query устарел уже, надо забыть о нем и пользоваться PDO::query()
        
//    Disabling errors via the @ symbol is very bad practice.
//    Errors need to be displayed on the dev environment and logged on the production environment.    
//    mysql_query is deprecated already, you should forget about it and use PDO::query()   
        
        while ($arr = @mysql_fetch_array($res)) {
//    Подавление ошибок через символ @ - это очень плохая практика.
//    mysql_fetch_array устарел уже, надо забыть о нем и пользоваться PDOStatement::fetch()
            
//    Disabling errors via the @ symbol is very bad practice.        
//    mysql_fetch_array is deprecated already, you should forget about it and use PDOStatement::fetch()          
            $out[] = $arr;
            if (count($out) > $limit) {
                break;
            }
        }
    }
    return $out;
}

