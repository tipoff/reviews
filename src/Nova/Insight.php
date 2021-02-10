<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\Resource;

class Insight extends Resource
{
    public static $model = \Tipoff\Reviews\Models\Insight::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public static $group = 'Reporting';

    public static $perPageViaRelationship = 10;

    public function fieldsForIndex(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Location', 'location', app()->getAlias('nova.location'))->sortable(),
            Date::make('Date')->sortable(),
            Number::make('Views', function () {
                return $this->views_maps + $this->views_search;
            })->sortable(),
            Number::make('Visits')->sortable(),
        ];
    }

    public function fields(Request $request)
    {
        return [
            Date::make('Date'),
            Date::make('Day of Week', 'date')->format('dddd'),
            Number::make('Views', function () {
                return $this->views_maps + $this->views_search;
            }),
            Number::make('Visits'),
            BelongsTo::make('Location', 'location', app()->getAlias('nova.location')),
            ID::make(),

            new Panel('Views', $this->viewFields()),

            new Panel('Searches', $this->searchFields()),

            new Panel('Actions', $this->actionFields()),

            new Panel('Photos', $this->photoFields()),
        ];
    }

    protected function viewFields()
    {
        return [
            Number::make('Views Maps'),
            Number::make('Views Search'),
            Number::make('Total Views', function () {
                return $this->views_maps + $this->views_search;
            }),
        ];
    }

    protected function searchFields()
    {
        return [
            Number::make('Searches Discovery'),
            Number::make('Searches Direct'),
            Number::make('Searches Branded'),
            Number::make('Total Searches', function () {
                return $this->searches_discovery + $this->searches_direct + $this->searches_branded;
            }),
        ];
    }

    protected function actionFields()
    {
        return [
            Number::make('Visits'),
            Number::make('Directions'),
            Number::make('Calls'),
            Number::make('Posts Views'),
            Number::make('Photos Views Merchant'),
            Number::make('Photos Views Customer'),
            Number::make('Total Photo Views', function () {
                return $this->photos_views_merchant + $this->photos_views_customer;
            }),
        ];
    }

    protected function photoFields()
    {
        return [
            Number::make('# Photos from Us', 'photos_count_merchant'),
            Number::make('# Photos from Customers', 'photos_count_customer'),
            Number::make('Total Photos', function () {
                return $this->photos_count_merchant + $this->photos_count_customer;
            }),
        ];
    }

    public function cards(Request $request)
    {
        return [];
    }

    public function filters(Request $request)
    {
        return [
            // TODO - figure out how to share this
            // new Filters\Location,
        ];
    }

    public function lenses(Request $request)
    {
        return [];
    }

    public function actions(Request $request)
    {
        return [];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->where('views_maps', '>', 0);
    }
}