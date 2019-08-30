<?php


namespace app\controllers;

use app\graphql\Types;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Error\FormattedError;
use Yii;

class GraphqlController extends RestController
{
    public function methodGet()
    {
        $request = Yii::$app->request;
        $variables = $request->get('variables', $request->post('variables'));
        $query     = $request->get('query', $request->post('query'));
        $operation = $request->get('operationName', $request->post('operationName'));

        $schema = new Schema([
            'query' => Types::query(),
        ]);

        $debug = defined('YII_DEBUG') AND YII_DEBUG;
        $result = GraphQL::executeQuery(
            $schema,
            $query,
            null,
            null,
            empty($variables) ? null : $variables,
            empty($operation) ? null : $operation
        )->toArray($debug);

        return json_encode($result);
    }

    public function methodPost()
    {
        return $this->methodGet();
    }
}
