<?php

namespace app\models;

use Itstructure\AdminModule\interfaces\ModelInterface;
use Itstructure\AdminModule\models\ActiveRecord;

/**
 * This is the model class for table "technologies".
 *
 * @property int $id
 * @property string $name
 * @property int $share
 * @property string $icon
 * @property string $created_at
 * @property string $updated_at
 *
 * @property About[] $about
 * @property AboutTechnology[] $aboutTechnologies
 *
 * @package app\models
 */
class Technology extends ActiveRecord implements ModelInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'technologies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'name',
                    'share',
                    'about'
                ],
                'required'
            ],
            [
                [
                    'share'
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
                    'name',
                    'icon'
                ],
                'string',
                'max' => 64
            ],
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
            'name',
            'share',
            'icon',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'share' => 'Share, %',
            'icon' => 'Icon',
            'about' => 'About',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_CREATE][] = 'about';
        $scenarios[self::SCENARIO_UPDATE][] = 'about';

        return $scenarios;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAboutTechnologies()
    {
        return $this->hasMany(AboutTechnology::class, [
            'technologies_id' => 'id'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAbout()
    {
        return $this->hasMany(About::class, [
            'id' => 'about_id'
        ])->viaTable('about_technologies', [
            'technologies_id' => 'id'
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
     * Link with about entity after save.
     *
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        $this->linkWithAbout(empty($this->about) ? [] : $this->about);

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Returns id of the model.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Link with about entity.
     *
     * @param array $aboutList
     */
    private function linkWithAbout(array $aboutList): void
    {
        AboutTechnology::deleteAll([
            'technologies_id' => $this->id
        ]);

        foreach ($aboutList as $aboutId) {
            $aboutTechnologies = new AboutTechnology();
            $aboutTechnologies->technologies_id = $this->id;
            $aboutTechnologies->about_id = $aboutId;
            $aboutTechnologies->save();
        }
    }
}
