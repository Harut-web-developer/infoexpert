<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "texts".
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $text_am
 * @property string|null $text_ru
 * @property string|null $text_en
 * @property int|null $page_id
 */
class Texts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'texts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text_am', 'text_ru', 'text_en'], 'string'],
            [['page_id'], 'integer'],
            [['slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'text_am' => 'Text Am',
            'text_ru' => 'Text Ru',
            'text_en' => 'Text En',
            'page_id' => 'Page ID',
        ];
    }
}
