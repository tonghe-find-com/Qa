<?php

namespace TypiCMS\Modules\Qas\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        if (!Gate::denies('read qacategories')) {
            $view->sidebar->group(__('QA Group'), function (SidebarGroup $group) {
                $group->id = 'qagroup';
                $group->weight = 30;
                $group->addItem(__('Qacategories'), function (SidebarItem $item) {
                    $item->id = 'qacategories';
                    $item->icon = config('typicms.qacategories.sidebar.icon');
                    $item->weight = config('typicms.qacategories.sidebar.weight');
                    $item->route('admin::index-qacategories');
                    $item->append('admin::create-qacategory');
                });
            });
        }

        if (!Gate::denies('read qas')) {
            $view->sidebar->group(__('QA Group'), function (SidebarGroup $group) {
                $group->id = 'qagroup';
                $group->weight = 30;
                $group->addItem(__('Qas'), function (SidebarItem $item) {
                    $item->id = 'qas';
                    $item->icon = config('typicms.qas.sidebar.icon');
                    $item->weight = config('typicms.qas.sidebar.weight');
                    $item->route('admin::index-qas');
                    $item->append('admin::create-qa');
                });
            });
        }

        return ;
    }
}
