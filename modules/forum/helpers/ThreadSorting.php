<?php

namespace app\modules\forum\helpers;

use yii\data\Sort;
use yii\helpers\Html;

class ThreadSorting
{
    /**
     * @param string $sort
     * @param string $direction
     */
    public function getSortingOptions($sort, $direction)
    {
        switch($sort) {
            case 'date':
                $sort = 'creation_date';
                break;
        }
        return new Sort([
            'attributes' => [
                $sort => [
                    'asc' => [$sort => SORT_ASC],
                    'desc' => [$sort => SORT_DESC],
                    'default' => SORT_ASC,
                ]
            ],
            'attributeOrders' => [
                $sort => $direction == 'desc' ? SORT_DESC : SORT_ASC
            ]
        ]);
    }

    /**
     * Returns the HTML for the sorting buttons
     * @param string $sort
     * @param string $direction
     * @param array $availableSortings
     */
    public function renderSortingButtons($sort = null, $direction = 'asc', $availableSortings = [])
    {
        $output = '';

        $oppositeDirection = $direction == 'asc' ? 'desc' : 'asc';
        foreach($availableSortings as $sorting) {
            $span = '';
            $newDirection = $direction;
            if($sort == $sorting->getAttributeName()) {
                $newDirection = $direction == 'asc' ? 'desc' : 'asc';
                $arrow = $direction == 'desc' ? 'down' : 'up';
                $span =  '<span class="glyphicon glyphicon-chevron-' . $arrow . '" aria-hidden="true"></span>';
            }
            $output .= Html::a($sorting->getTitle() . ' ' . $span, ['index', 'sort' => $sorting->getAttributeName(), 'direction' => $newDirection], ['class' => 'btn btn-default']);
            $output .= ' ';
        }

        return $output;
    }
}
