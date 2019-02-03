<?php

namespace app\models;

use yii\base\Model;
use yii\db\Connection;

/**
 * This is the model class for table "settings".
 *
 * @property Connection $db
 */
class Setting extends Model
{
    /**
     * @var int
     */
    public $initUserStatus;

    /**
     * @var string
     */
    public $initUserRole;

    /**
     * @var int
     */
    public $regBlock;

    /**
     * @var string
     */
    private $tableName = 'settings';

    /**
     * Data base connection driver.
     *
     * @var Connection
     */
    private $db;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'initUserStatus',
                    'initUserRole',
                    'regBlock',
                ],
                'required',
            ],
            [
                [
                    'initUserStatus',
                    'regBlock',
                ],
                'integer',
            ],
            [
                [
                    'initUserRole',
                ],
                'string',
                'max' => 64
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'initUserStatus' => 'User status after registration',
            'initUserRole' => 'User role after registration',
            'regBlock' => 'Block registration',
        ];
    }

    /**
     * Set db driver.
     *
     * @param Connection $db
     */
    public function setDb(Connection $db): void
    {
        $this->db = $db;
    }

    /**
     * Set table name.
     *
     * @param string $tableName
     */
    public function setTableName(string $tableName): void
    {
        $this->tableName = $tableName;
    }

    /**
     * Returns this object with field's values.
     *
     * @return $this
     */
    public function getSettings()
    {
        $result = $this->db->createCommand('SELECT * FROM ' . $this->tableName)
            ->queryOne();

        $this->setAttributes($result, false);

        return $this;
    }

    /**
     * Save settings data.
     *
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $count = (int)$this->db->createCommand('SELECT COUNT(*) FROM ' . $this->tableName)->queryScalar();

        if ($count > 0) {
            $result = $this->db->createCommand('UPDATE ' . $this->tableName. ' SET ' . $this->queryUpdateAttributes())
                ->bindValues($this->attributesToBind())
                ->execute();
        } else {
            $result = $this->db->createCommand('INSERT INTO ' . $this->tableName. ' ' . $this->queryInsertAttributes())
                ->bindValues($this->attributesToBind())
                ->execute();
        }

        if (!$result) {
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    private function attributesToBind(): array
    {
        $attributesToBind = [];

        foreach ($this->getAttributes() as $name => $value) {
            $attributesToBind[':' . $name] = $value;
        }

        return $attributesToBind;
    }

    /**
     * @return string
     */
    private function queryUpdateAttributes(): string
    {
        $toUpdateArray = [];

        foreach ($this->getAttributes() as $name => $value) {
            $toUpdateArray[] = $name . ' = :' . $name;
        }

        return implode(', ', $toUpdateArray);
    }

    /**
     * @return string
     */
    private function queryInsertAttributes(): string
    {
        $toInsertArrayNames = [];
        $toInsertArrayValues = [];

        foreach ($this->getAttributes() as $name => $value) {
            $toInsertArrayNames[] = $name;
            $toInsertArrayValues[] = ':' . $name;
        }

        return
            ' (' . implode(', ', $toInsertArrayNames) . ') VALUES ' .
            ' (' . implode(', ', $toInsertArrayValues) . ') ';
    }
}
