<?php

function load_users_data($user_ids) {
    $user_ids = explode(',', $user_ids);
    foreach ($user_ids as $user_id) {
        // Надо сделать одну точку подсоединения к БД, вынести за пределы этой функции, а тем более за пределы цикла.
        // mysqli_connect - замениь на PDO. PDO - уже стандарт, позволяет работать с разными СУБД
        $db = mysqli_connect("localhost", "root", "123123", "database");
        // Запрос в цикле, недопустим! Будет все очень медленно.
        // Данный запрос подвержен SQL инъекции. $user_ids - может содержать вложенный
        // SQL-запрос на удаление/редактирование и т.д. Вообщем будет взломан!
        $sql = mysqli_query($db, "SELECT * FROM users WHERE id=$user_id");
        while($obj = $sql->fetch_object()){
            $data[$user_id] = $obj->name;
        }
        // Писал выше, вынести за пределы, цикла, и функции.
        mysqli_close($db);
    }
    // если запрос ничего не найтдет, PHP уведомит что переменная $data необъявлена
    return $data;
}

// Как правило, в $_GET['user_ids'] должна приходить строка
// с номерами пользователей через запятую, например: 1,2,17,48

// Есть PSR-7, не надо работать напрямую с переменными $_GET, $_POST.
$data = load_users_data($_GET['user_ids']);
foreach ($data as $user_id=>$name) {
    // XSS-уязвимость
    // Принцип такой, сохраняем все в БД как есть, выводить через фильтр.
    // Например htmlspecialchars($user_id)

    echo "<a href=\"/show_user.php?id=$user_id\">$name</a>";
}



/**
 * Не соответствует PSR-2/PSR-12
 *
 * вынести подключение к БД, чтобы можно было легче тестировать функцию,
 * и функция не будет зависть от определенного подключения к БД.
 *
 * @param string $userIds
 */
function loadUsers(string $userIds, PDO $db): ?array
{
    $userIds = explode(',', $userIds);
    if (empty($userIds)) {
        return null;
    }

    /**
     * В цикле недопустимо делать запросы к БД. а тем устанавливать и разывать соединение, это вообще оченть плохо.
     *
     * Нужно использовать все возможности(команды) SQL, для того чтобы писать быстрый код.
     */
    $sqlParam = str_repeat('?,', count($userIds) - 1) . '?';
    $stmt = $db->prepare(
        "select id, name from users where id IN ( $sqlParam )"
    );
    $stmt->setFetchMode(\PDO::FETCH_ASSOC);
    $stmt->execute($userIds);
    return $stmt->fetchAll();
}

/**
 * Да как правило лежит в $_GET, но про глобальные переменные надо забыть, есть PSR-7.
 */
$query = $request->getQueryParams();
$data = loadUsers($query['user_ids']);
foreach ($data as $userId => $name) {
    // сохранять в БД можно все, выводить нужно через фильтр
    $query = http_build_query(['id' => htmlspecialchars($userId)]);
    echo "<a href=\"/show_user.php?$query\">$name</a>";
}

// 40 минут