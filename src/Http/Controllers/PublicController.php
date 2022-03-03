<?php

namespace Tonghe\Modules\Qas\Http\Controllers;

use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use Tonghe\Modules\Qas\Models\Qacategory;
use Tonghe\Modules\Qas\Models\Qa;

class PublicController extends BasePublicController
{
    public function index(): View
    {
        $model = null;
        $list = Qa::published()->orderBy('position','ASC')->get();

        return view('qaitems::public.index')
            ->with(compact('model','list'));
    }

    public function show($slug): View
    {
        $model = Qacategory::published()->whereSlugIs($slug)->firstOrFail();
        $list = Qa::published()->where('category_id',$model->id)->orderBy('position','ASC')->get();

        return view('qaitems::public.index')
            ->with(compact('model','list'));
    }
}
