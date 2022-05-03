<?php

namespace TypiCMS\Modules\Qas\Http\Controllers\Item;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Qas\Models\Qa;

class ApiController extends BaseApiController
{
    public function index(Request $request): LengthAwarePaginator
    {
        $data = QueryBuilder::for(Qa::class)
            ->selectFields($request->input('fields.qas'))
            ->allowedSorts(['status_translated', 'title_translated','position'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->allowedIncludes(['image'])
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(Qa $qa, Request $request)
    {
        foreach ($request->only('status','position') as $key => $content) {
            if ($qa->isTranslatableAttribute($key)) {
                foreach ($content as $lang => $value) {
                    $qa->setTranslation($key, $lang, $value);
                }
            } else {
                $qa->{$key} = $content;
            }
        }

        $qa->save();
    }

    public function destroy(Qa $qa)
    {
        $qa->delete();
    }
}
