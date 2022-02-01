<?php

$source = 'https://www.somehost.com/test/index.html?param1=4&param2=3&param3=2&param4=1&param5=3';

CONST DELETE3 = 3;

function changeUri(string $source)
{
    $path = getDomain($source);
    if (empty($path)) {
        return null;
    }

    $url = getUrl($source);
    $query = getQuery($source);
    $filteredQuery = filter($query);
    asort($filteredQuery);
    $result = http_build_query(array_merge($filteredQuery, ['url' => $url]));
    if (empty($result)) {
        return $path;
    }

    return $path . '/?' . $result;
}

function getDomain(string $source): string
{
    return parse_url($source, PHP_URL_SCHEME) . '://' . parse_url($source, PHP_URL_HOST);
}
function filter(array $query): array
{
    return array_filter($query, 'delete3');
}

function delete3($value): bool
{
    return !(DELETE3 == $value);
}

function getQuery(string $source): array
{
    $data = parse_url($source, PHP_URL_QUERY);

    if (empty($data)) {
        return [];
    }
    parse_str($data, $result);
    return $result;
}

function getUrl(string $source): string
{
    return parse_url($source, PHP_URL_PATH);
}

$result = changeUri($source);

var_dump($result);

//30 minutes