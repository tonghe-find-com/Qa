<?php

namespace Tonghe\Modules\Qas\Http\Controllers\Category;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use Tonghe\Modules\Qas\Models\Qacategory;

class ApiController extends BaseApiController
{
    public function index(Request $request): LengthAwarePaginator
    {
        $data = QueryBuilder::for(Qacategory::class)
            ->selectFields($request->input('fields.qacategories'))
            ->allowedSorts(['status_translated', 'title_translated'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->allowedIncludes(['image'])
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(Qacategory $qacategory, Request $request)
    {
        foreach ($request->only('status') as $key => $content) {
            if ($qacategory->isTranslatableAttribute($key)) {
                foreach ($content as $lang => $value) {
                    $qacategory->setTranslation($key, $lang, $value);
                }
            } else {
                $qacategory->{$key} = $content;
            }
        }

        $qacategory->save();
    }

    public function destroy(Qacategory $qacategory)
    {
        try {
            $qacategory->delete();
        } catch (\Exception $ex) {
            switch($ex->getCode()){
                case 23000:
                    $errors = ['message' => '刪除失敗，因為該分類有相關連的資料'];
                    return response()->json($errors, 500);
            }
        }
    }
}
