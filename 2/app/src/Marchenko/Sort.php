<?php

namespace Marchenko;

class Sort
{
    public function do(array $articles, string $field, string $typeSort): array
    {

        $methodName = 'get' . ucfirst($field);
        usort(
            $articles,
            static function ($first, $second) use ($methodName, $typeSort)
            {
                $value1 = [$first, $methodName];
                $value2 = [$second, $methodName];

                if ($value1 == $value2) {
                    return 0;
                }

                if ($typeSort === 'DESC') {
                    return ($value1 < $value2) ? -1 : 1;
                }
                else {
                    return ($value1 > $value2) ? -1 : 1;
                }
            }
        );
        return $articles;
    }

}