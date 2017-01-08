<?php

namespace app\components;

use yii\helpers\Html;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 *  Change render item widget Gallery
 *
 *  @author Muhamad Alfan <muhamad.alfan01@gmail.com>
 *  @since  1.0
 */

class MaGallery extends \dosamigos\gallery\Gallery
{
    /**
     * @param mixed $item
     * @return null|string the item to render
     */
    public function renderItem($item)
    {
        if (is_string($item)) {
            return Html::a(Html::img($item), $item, ['class' => 'gallery-item']);
        }
        $src = ArrayHelper::getValue($item, 'src');
        if ($src === null) {
            return null;
        }
        $url           = ArrayHelper::getValue($item, 'url', $src);
        $options       = ArrayHelper::getValue($item, 'options', []);
        $imageOptions  = ArrayHelper::getValue($item, 'imageOptions', []);
        $deleteUrl     = ArrayHelper::getValue($item, 'deleteUrl', []);
        $deleteOptions = ArrayHelper::getValue($item, 'deleteOptions', []);
        Html::addCssClass($options, 'gallery-item');

        $deleteLabel = Html::a('X', Url::to($deleteUrl), $deleteOptions);
        $link = Html::a(Html::img($src, $imageOptions), $url, $options);

        return Html::tag('span', $deleteLabel . $link);
    }
}
