<?php

namespace app\services;

use app\models\Users;
use Yii;

class ImportCsvService
{
	public static function importByContent(string $content): bool
	{
        Yii::$app->db->createCommand()->truncateTable('users')->execute();
        $data = self::parseString($content);
        self::insertDataToDb($data);
        return true;
	}

	private static function parseString(string $content): array
    {
        $rows = str_getcsv($content, "\n");
        $data = [];
        foreach($rows as $row)
            $data[] = str_getcsv($row, ';');

        $labels = $data[0];
        unset($data[0]);
        $result = [];
        foreach($data as $row) {
            $item = [];
            foreach($labels as $i=>$label) {
                $item[$label] = $row[$i];
            }
            $result[] = $item;
        }

        return $result;
    }

    private static function insertDataToDb($data): void
    {
        // TODO: импорт можно и ускорить, но времени на это нет
        foreach($data as $row) {
            $model = new Users();
            $model->setAttributes($row);
            $model->save();
        }
    }
}
