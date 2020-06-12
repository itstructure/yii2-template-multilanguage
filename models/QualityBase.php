<?php

namespace app\models;

use Itstructure\AdminModule\models\{MultilanguageTrait, Language, ActiveRecord};
use Itstructure\AdminModule\interfaces\ModelInterface;

/**
 * This is the model class for table "qualities".
 *
 * @property int $id
 * @property string $icon
 * @property string $created_at
 * @property string $updated_at
 *
 * @property AboutQuality[] $aboutQualities
 * @property About[] $about
 * @property QualityLanguage[] $qualitiesLanguages
 * @property Language[] $languages
 */
class QualityBase extends ActiveRecord
{
    use MultilanguageTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qualities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'icon',
                    'about'
                ],
                'required'
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
            ]
        ];
    }

    /**
     * List if attributes.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'id',
            'icon',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * @return array
     */
    public function mainModelAttributes()
    {
        return [
            'id',
            'icon',
            'about',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios[ModelInterface::SCENARIO_CREATE][] = 'about';
        $scenarios[ModelInterface::SCENARIO_UPDATE][] = 'about';

        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icon' => 'Icon',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAboutQualities()
    {
        return $this->hasMany(AboutQuality::class, [
            'qualities_id' => 'id'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAbout()
    {
        return $this->hasMany(About::class, [
            'id' => 'about_id'
        ])->viaTable('about_qualities', [
            'qualities_id' => 'id'
        ]);
    }

    /**
     * @param $about
     *
     * @return void
     */
    public function setAbout($about): void
    {
        $this->about = $about;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQualitiesLanguages()
    {
        return $this->hasMany(QualityLanguage::class, [
            'qualities_id' => 'id'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguages()
    {
        return $this->hasMany(Language::class, [
            'id' => 'language_id'
        ])->viaTable('qualities_language', [
            'qualities_id' => 'id'
        ]);
    }

    /**
     * Link with about entity.
     *
     * @param array $aboutList
     */
    protected function linkWithAbout(array $aboutList): void
    {
        AboutQuality::deleteAll([
            'qualities_id' => $this->id
        ]);

        foreach ($aboutList as $aboutId) {
            $aboutQuality = new AboutQuality();
            $aboutQuality->qualities_id = $this->id;
            $aboutQuality->about_id = $aboutId;
            $aboutQuality->save();
        }
    }
}
