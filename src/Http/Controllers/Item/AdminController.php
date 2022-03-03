<?php

namespace Tonghe\Modules\Qas\Http\Controllers\Item;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use Tonghe\Modules\Qas\Exports\Export;
use Tonghe\Modules\Qas\Http\Requests\FormRequest;
use Tonghe\Modules\Qas\Models\Qa;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('qas::admin.item.index');
    }

    public function export(Request $request)
    {
        $filename = date('Y-m-d').' '.config('app.name').' qas.xlsx';

        return Excel::download(new Export($request), $filename);
    }

    public function create(): View
    {
        $model = new Qa();

        return view('qas::admin.item.create')
            ->with(compact('model'));
    }

    public function edit(qa $qa): View
    {
        return view('qas::admin.item.edit')
            ->with(['model' => $qa]);
    }

    public function store(FormRequest $request): RedirectResponse
    {
        $qa = Qa::create($request->validated());

        return $this->redirect($request, $qa);
    }

    public function update(qa $qa, FormRequest $request): RedirectResponse
    {
        $qa->update($request->validated());

        return $this->redirect($request, $qa);
    }
}
