<?php

namespace app\models;

use Itstructure\AdminModule\models\{MultilanguageTrait, Language};
use Itstructure\MultiLevelMenu\MenuWidget;

/**
 * This is the model class for table "pages".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int $parentId
 * @property int $newParentId
 * @property string $icon
 * @property int $active
 *
 * @property PageLanguage[] $pagesLanguages
 * @property Language[] $languages
 *
 * @package app\models
 */
class Page extends ActiveRecord
{
    use MultilanguageTrait;

    /**
     * @var int
     */
    public $newParentId;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'created_at',
                    'updated_at',
                ],
                'safe',
            ],
            [
                [
                    'active'
                ],
                'required',
            ],
            [
                [
                    'parentId',
                    'newParentId',
                    'active'
                ],
                'integer',
            ],
            [
                'icon',
                'string',
                'max' => 64,
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'id',
            'parentId',
            'icon',
            'active',
            'newParentId',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parentId' => 'Parent Id',
            'icon' => 'Icon',
            'active' => 'Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @param bool $insert
     *
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->parentId = empty($this->newParentId) ? null : (int)$this->newParentId;

        if (empty($this->newParentId)) {
            $this->parentId = null;

        } elseif (MenuWidget::checkNewParentId($this, $this->newParentId)) {
            $this->parentId = $this->newParentId;
        }

        return parent::beforeSave($insert);
    }

    /**
     * Reassigning child objects to their new parent after delete the main model record.
     */
    public function afterDelete()
    {
        MenuWidget::afterDeleteMainModel($this);

        parent::afterDelete();
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getMenu()
    {
        return static::find()->select([
            'id', 'parentId'
        ])->all();
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getActiveMenu()
    {
        return static::find()->select([
            'id', 'parentId'
        ])->where([
            'active' => 1
        ])->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPagesLanguages()
    {
        return $this->hasMany(PageLanguage::class, [
            'pages_id' => 'id'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguages()
    {
        return $this->hasMany(Language::class, [
            'id' => 'language_id'
        ])->viaTable('pages_language', [
            'pages_id' => 'id'
        ]);
    }
}
