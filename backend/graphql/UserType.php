<?php

namespace app\graphql;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use app\models\Users;
use DateTime;

class UserType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => function() {
                return [
                    'ACTIVE' => [
                        'type' => Type::string(),
                    ],
                    'NAME' => [
                        'type' => Type::string(),
                    ],
                    'LAST_NAME' => [
                        'type' => Type::string(),
                    ],
                    'EMAIL' => [
                        'type' => Type::string(),
                    ],
                    'PERSONAL_GENDER' => [
                        'type' => Type::string(),
                    ],
                    'WORK_POSITION' => [
                        'type' => Type::string(),
                    ],
                    'Region' => [
                        'type' => Type::string(),
                    ],
                    'City' => [
                        'type' => Type::string(),
                    ],
                    'liverCount' => [
                        'type' => Type::int(),
                    ],
                    'PERSONAL_BIRTHDAY' => [
                        'type' => Type::string(),
                        'description' => 'Date when user was born',
                        'args' => [
                            'format' => Type::string(),
                        ],
                        'resolve' => function(Users $user, $args) {
                            $format = isset($args['format']) ? $args['format'] : 'd.m.Y';
                            return (new DateTime($user->PERSONAL_BIRTHDAY))->format($format);
                        },
                    ],
                ];
            }
        ];

        parent::__construct($config);
    }
}