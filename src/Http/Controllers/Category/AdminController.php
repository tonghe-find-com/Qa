<?php

namespace TypiCMS\Modules\Qas\Http\Controllers\Category;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Qas\Exports\Export;
use TypiCMS\Modules\Qas\Http\Requests\CategoryFormRequest;
use TypiCMS\Modules\Qas\Models\Qacategory;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('qas::admin.category.index');
    }

    public function export(Request $request)
    {
        $filename = date('Y-m-d').' '.config('app.name').' qacategories.xlsx';

        return Excel::download(new Export($request), $filename);
    }

    public function create(): View
    {
        $model = new Qacategory();

        return view('qas::admin.category.create')
            ->with(compact('model'));
    }

    public function edit(qacategory $qacategory): View
    {
        return view('qas::admin.category.edit')
            ->with(['model' => $qacategory]);
    }

    public function store(CategoryFormRequest $request): RedirectResponse
    {
        $qacategory = Qacategory::create($request->validated());

        return $this->redirect($request, $qacategory);
    }

    public function update(qacategory $qacategory, CategoryFormRequest $request): RedirectResponse
    {
        $qacategory->update($request->validated());

        return $this->redirect($request, $qacategory);
    }
}
