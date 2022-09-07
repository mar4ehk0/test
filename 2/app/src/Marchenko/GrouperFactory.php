<?php

namespace Marchenko;

class GrouperFactory
{
    public static function create(string $typeGrouper): Grouper
    {
        switch ($typeGrouper) {
            case 'default': return new GrouperDefault();
            default:  return new GrouperDefault();
        }
    }

}