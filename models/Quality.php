<?php

namespace app\models;

use Itstructure\AdminModule\models\Language;

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
class Quality extends QualityBase
{
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
}
