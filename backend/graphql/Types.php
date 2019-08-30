<?php


namespace app\graphql;

class Types
{
    private static $query;
    private static $user;

    public static function query()
    {
        return self::$query ?: (self::$query = new QueryType());
    }

    public static function user()
    {
        return self::$user ?: (self::$user = new UserType());
    }
}