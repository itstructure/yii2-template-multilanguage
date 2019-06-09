<?php

namespace app\models;

use yii\helpers\{ArrayHelper, Html};
use Itstructure\AdminModule\models\{MultilanguageTrait, Language};
use Itstructure\MFUploader\Module as MFUModule;
use Itstructure\MFUploader\behaviors\{BehaviorMediafile, BehaviorAlbum};
use Itstructure\MFUploader\models\{Mediafile, OwnerAlbum, OwnerMediafile};
use Itstructure\MFUploader\models\album\Album;
use Itstructure\MFUploader\interfaces\UploadModelInterface;

/**
 * This is the model class for table "products".
 *
 * @property int|string $thumbnail thumbnail(mediafile id or url).
 * @property array $image image(array of 'mediafile id' or 'mediafile url').
 * @property array $albums Existing album ids.
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int $pageId
 * @property string $icon
 * @property int $active
 *
 * @property Page $page
 * @property ProductLanguage[] $productsLanguages
 * @property Language[] $languages
 *
 * @package app\models
 */
class Product extends ActiveRecord
{
    use MultilanguageTrait;

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
     * @var array|null|\yii\db\ActiveRecord|Mediafile
     */
    protected $thumbnailModel;

    /**
     * Initialize.
     * Set albums, that product has.
     */
    public function init()
    {
        $this->albums = $this->getAlbums();

        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
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
                    'active'
                ],
                'required'
            ],
            [
                [
                    'pageId',
                    'active'
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
                    'icon'
                ],
                'string',
                'max' => 64
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
            'pageId' => 'Page ID',
            'icon' => 'Icon',
            'active' => 'Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
    public function getProductsLanguages()
    {
        return $this->hasMany(ProductLanguage::class, [
            'products_id' => 'id'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguages()
    {
        return $this->hasMany(Language::class, [
            'id' => 'language_id'
        ])->viaTable('products_language', [
            'products_id' => 'id'
        ]);
    }

    /**
     * Get albums, that product has.
     *
     * @return Album[]
     */
    public function getAlbums()
    {
        return OwnerAlbum::getAlbumsQuery([
            'owner' => $this->tableName(),
            'ownerId' => $this->id,
            'ownerAttribute' => 'albums',
        ])->all();
    }

    /**
     * Get album thumb image.
     *
     * @param array  $options
     *
     * @return mixed
     */
    public function getDefaultThumbImage(array $options = [])
    {
        $thumbnailModel = $this->getThumbnailModel();

        if (null === $thumbnailModel){
            return null;
        }

        $url = $thumbnailModel->getThumbUrl(MFUModule::THUMB_ALIAS_DEFAULT);

        if (empty($url)) {
            return null;
        }

        if (empty($options['alt'])) {
            $options['alt'] = $thumbnailModel->alt;
        }

        return Html::img($url, $options);
    }

    /**
     * Get product's thumbnail.
     *
     * @return array|null|\yii\db\ActiveRecord|Mediafile
     */
    public function getThumbnailModel()
    {
        if (null === $this->id) {
            return null;
        }

        if ($this->thumbnailModel === null) {
            $this->thumbnailModel = OwnerMediafile::getOwnerThumbnail($this->tableName(), $this->id);
        }

        return $this->thumbnailModel;
    }
}
