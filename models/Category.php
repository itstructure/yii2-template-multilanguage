<?php

namespace app\models;

use Yii;
use Itstructure\MultiLevelMenu\MenuWidget;
use Itstructure\AdminModule\models\{MultilanguageTrait, Language, ActiveRecord};
use Itstructure\AdminModule\interfaces\ModelInterface;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int $parentId
 * @property string $icon
 * @property string $alias
 * @property int $active
 *
 * @property CategoryLanguage[] $categoriesLanguages
 * @property Language[] $languages
 *
 * @package app\models
 */
class Category extends ActiveRecord
{
    use MultilanguageTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
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
                    'active',
                ],
                'required',
            ],
            [
                [
                    'parentId',
                    'active'
                ],
                'integer',
            ],
            [
                [
                    'icon',
                    'alias',
                ],
                'string',
                'max' => 128,
            ],
            [
                'parentId',
                'filter',
                'filter' => function ($value) {
                    if (empty($value)) {
                        return null;
                    } else {
                        return MenuWidget::checkNewParentId($this, $value) ? $value : $this->getOldAttribute('parentId');
                    }
                }
            ],
            [
                'alias',
                'filter',
                'filter' => function ($value) {
                    return preg_replace( '/[^a-z0-9_]+/', '-', strtolower(trim($value)));
                }
            ],
            [
                'alias',
                'unique',
                'skipOnError'     => true,
                'targetClass'     => static::class,
                'filter' => $this->getScenario() == ModelInterface::SCENARIO_UPDATE ? 'id != '.$this->id : ''
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
            'alias',
            'active',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parentId' => Yii::t('app', 'Parent object'),
            'icon' => Yii::t('app', 'Icon'),
            'active' => Yii::t('app', 'Active status'),
            'alias' => Yii::t('app', 'URL Alias'),
            'created_at' => Yii::t('app', 'Created date'),
            'updated_at' => Yii::t('app', 'Updated date'),
        ];
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
            'id', 'parentId', 'alias'
        ])->where([
            'active' => 1
        ])->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriesLanguages()
    {
        return $this->hasMany(CategoryLanguage::class, [
            'categories_id' => 'id'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguages()
    {
        return $this->hasMany(Language::class, [
            'id' => 'language_id'
        ])->viaTable('categories_language', [
            'categories_id' => 'id'
        ]);
    }
}
