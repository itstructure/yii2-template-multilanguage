<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use Itstructure\MultiLevelMenu\MenuWidget;
use Itstructure\AdminModule\models\{MultilanguageTrait, Language, ActiveRecord};
use Itstructure\AdminModule\interfaces\ModelInterface;
use Itstructure\MFUploader\behaviors\{BehaviorMediafile, BehaviorAlbum};
use Itstructure\MFUploader\models\OwnerAlbum;
use Itstructure\MFUploader\models\album\Album;
use Itstructure\MFUploader\interfaces\UploadModelInterface;
use app\traits\ThumbnailTrait;

/**
 * This is the model class for table "pages".
 *
 * @property int|string $thumbnail thumbnail(mediafile id or url).
 * @property array $albums Existing album ids.
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int $parentId
 * @property string $icon
 * @property string $alias
 * @property int $active
 *
 * @property PageLanguage[] $pagesLanguages
 * @property Language[] $languages
 *
 * @package app\models
 */
class Page extends ActiveRecord
{
    use MultilanguageTrait, ThumbnailTrait;

    /**
     * @var int|string thumbnail(mediafile id or url).
     */
    public $thumbnail;

    /**
     * @var array image(array of 'mediafile id' or 'mediafile url').
     */
    public $image;

    /**
     * @var array
     */
    public $albums = [];

    /**
     * Init albums.
     */
    public function afterFind()
    {
        $this->albums = $this->getAlbums();

        parent::afterFind();
    }

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
            [
                UploadModelInterface::FILE_TYPE_THUMB,
                function($attribute){
                    if (!is_numeric($this->{$attribute}) && !is_string($this->{$attribute})){
                        $this->addError($attribute, 'Tumbnail content must be a numeric or string.');
                    }
                },
                'skipOnError' => false,
            ],
            [
                UploadModelInterface::FILE_TYPE_IMAGE,
                function($attribute) {
                    if (!is_array($this->{$attribute})) {
                        $this->addError($attribute, 'Image field content must be an array.');
                    }
                },
                'skipOnError' => false,
            ],
            [
                'albums',
                'each',
                'rule' => ['integer'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'mediafile' => [
                'class' => BehaviorMediafile::class,
                'name' => static::tableName(),
                'attributes' => [
                    UploadModelInterface::FILE_TYPE_THUMB,
                    UploadModelInterface::FILE_TYPE_IMAGE,
                ],
            ],
            'albums' => [
                'class' => BehaviorAlbum::class,
                'name' => static::tableName(),
                'attributes' => [
                    'albums',
                ],
            ],
        ]);
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            UploadModelInterface::FILE_TYPE_THUMB,
            UploadModelInterface::FILE_TYPE_IMAGE,
            'albums',
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

    /**
     * Get albums, that catalog has.
     *
     * @return Album[]
     */
    public function getAlbums()
    {
        return OwnerAlbum::getAlbumsQuery([
            'owner' => static::tableName(),
            'ownerId' => $this->id,
            'ownerAttribute' => 'albums',
        ])->all();
    }
}
