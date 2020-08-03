<?php

namespace app\traits;

use Yii;
use yii\data\Pagination;
use Itstructure\MFUploader\models\OwnerMediafile;
use Itstructure\MFUploader\models\album\Album;

/**
 * Class AdditionFieldsTrait
 * @package app\traits
 */
trait AdditionFieldsTrait
{
    /**
     * @param string $ownerName
     * @param int $ownerId
     * @param string $ownerAttribute
     * @param array $paginationOptions
     * @return array
     */
    protected function getMediaFiles(string $ownerName, int $ownerId, string $ownerAttribute, array $paginationOptions = [])
    {
        $mediafilesQuery = OwnerMediafile::getMediaFilesQuery([
            'owner' => $ownerName,
            'ownerId' => $ownerId,
            'ownerAttribute' => $ownerAttribute,
        ]);
        $pagination = new Pagination(array_merge([
                'defaultPageSize' => Yii::$app->params['defaultPageSize'],
                'totalCount' => $mediafilesQuery->count()
            ], $paginationOptions)
        );

        return [
            'items' => $mediafilesQuery->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all(),
            'pagination' => $pagination
        ];
    }

    /**
     * @param string|null $type
     * @return array|\yii\db\ActiveRecord[]
     */
    protected function getAlbums(string $type = null)
    {
        $albumsQuery = Album::find()->select([
            'id', 'title', 'type'
        ]);

        if (!empty($type)) {
            $albumsQuery = $albumsQuery->where(['type' => $type]);
        }

        return $albumsQuery->all();
    }
}
