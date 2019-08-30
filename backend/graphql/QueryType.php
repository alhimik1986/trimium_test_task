<?php


namespace app\graphql;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use app\models\Users;

class QueryType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => function() {
                return [
                    'user' => [
                        'type' => Types::user(),
                        'args' => [
                            'id' => Type::nonNull(Type::int()),
                        ],
                        'resolve' => function($root, $args) {
                            return Users::find()->where(['id' => $args['id']])->one();
                        }
                    ],
                ];
            }
        ];

        parent::__construct($config);
    }
}