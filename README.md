# bat-media
### Apiato MediaEntity Container

`composer require batyukovstudio/bat-media`

Для использования подключить к нужной сущности

Интерфейс

`HasBatImages`

Трейт

`InteractsWithBatImages`

Вы можете изменить основные свойства для генерации картинок в

`config/bat-media.conf`

Также в этом конфиге вы можете поменять драйвер получения конфигурации картинок

- Чтобы выбрать драйвер DATABASE, необходимо заполнить таблицу в бд, можно сделать это с помощью страницы в filament


- Чтобы выбрать драйвер CONFIG_FILE, необходимо добавить в модель функцию


    public function getMediaConfigName(): string
    {
        return 'section-modelMedia';
    }

Структура конфига

    return [
        'collections' => [
            ModelMediaEnum::COLLECTION_PREVIEW => [
                'is_gallery' => false,
                'format' => MediaFormat::WEBP,
                'non_queued' => true,
                'quality' => 80,
                'conversions' => [
                    MediaSize::SMALL->value => [
                        'width' => 672,
                        'height' => 248,
                    ],
                    MediaSize::MEDIUM->value => [
                        'width' => 672,
                        'height' => 248,
                        'quality' => 90,
                    ],
                ],
            ],
            ModelMediaEnum::COLLECTION_GALLERY => [
                'is_gallery' => false,
                    'conversions' => [
                        MediaSize::MEDIUM->value => [
                            'width' => 675,
                            'height' => 418,
                            'quality' => 90,
                        ],
                    ],
                ],
            ],
        ];
