<?php

use Itstructure\MFUploader\models\Mediafile;
use Itstructure\MFUploader\interfaces\UploadModelInterface;

return [
    UploadModelInterface::FILE_TYPE_APP => [
        'existing' => function (Mediafile $mediafile) {
            return [
                'externalTag' => [
                    'name' => 'a',
                    'options' => [
                        'href' => $mediafile->url,
                        'target' => '_blank'
                    ]
                ]
            ];
        },
    ],
];
