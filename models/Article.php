<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use Itstructure\AdminModule\models\{MultilanguageTrait, Language, ActiveRecord};
use Itstructure\AdminModule\interfaces\ModelInterface;
use Itstructure\MFUploader\behaviors\{BehaviorMediafile, BehaviorAlbum};
use Itstructure\MFUploader\models\OwnerAlbum;
use Itstructure\MFUploader\models\album\Album;
use Itstructure\MFUploader\interfaces\UploadModelInterface;
use app\traits\ThumbnailTrait;

/**
 * This is the model class for table "articles".
 *
 * @property int|string $thumbnail thumbnail(mediafile id or url).
 * @property array $image image(array of 'mediafile id' or 'mediafile url').
 * @property array $albums Existing album ids.
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int $pageId
 * @property string $icon
 * @property string $alias
 * @property int $active
 *
 * @property Page $page
 * @property ArticleLanguage[] $articlesLanguages
 * @property Language[] $languages
 *
 * @package app\models
 */
class Article extends ActiveRecord
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
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'pageId',
                    'active',
                    'alias',
                ],
                'required'
            ],
            [
                [
                    'pageId',
                    'active',
                ],
                'integer'
            ],
            [
                [
                    'created_at',
                    'updated_at'
                ],
                'safe'
            ],
            [
                [
                    'icon',
                    'alias',
                ],
                'string',
                'max' => 128
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
                [
                    'pageId'
                ],
                'exist',
                'skipOnError' => true,
                'targetClass' => Page::class,
                'targetAttribute' => ['pageId' => 'id']
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
            'pageId',
            'icon',
            'alias',
            'active',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pageId' => Yii::t('articles', 'Parent page'),
            'icon' => Yii::t('app', 'Icon'),
            'active' => Yii::t('app', 'Active status'),
            'alias' => Yii::t('app', 'URL Alias'),
            'created_at' => Yii::t('app', 'Created date'),
            'updated_at' => Yii::t('app', 'Updated date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::class, [
            'id' => 'pageId'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticlesLanguages()
    {
        return $this->hasMany(ArticleLanguage::class, [
            'articles_id' => 'id'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguages()
    {
        return $this->hasMany(Language::class, [
            'id' => 'language_id'
        ])->viaTable('articles_language', [
            'articles_id' => 'id'
        ]);
    }

    /**
     * Get albums, that article has.
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
