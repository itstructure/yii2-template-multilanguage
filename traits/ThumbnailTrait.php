<?php

namespace app\traits;

use yii\helpers\Html;
use yii\db\ActiveRecord;
use Itstructure\MFUploader\Module as MFUModule;
use Itstructure\MFUploader\models\{Mediafile, OwnerMediafile};

/**
 * Class ThumbnailTrait
 *
 * @package app\traits
 */
trait ThumbnailTrait
{
    /**
     * @var array|null|ActiveRecord|Mediafile
     */
    protected $thumbnailModel;

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
     * Get model's thumbnail.
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