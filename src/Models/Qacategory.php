<?php

namespace TypiCMS\Modules\Qas\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Files\Traits\HasFiles;
use TypiCMS\Modules\History\Traits\Historable;
use TypiCMS\Modules\Qas\Presenters\ModulePresenter;
use Route;

class Qacategory extends Base
{
    use HasFiles;
    use HasTranslations;
    use Historable;
    use PresentableTrait;

    protected $presenter = ModulePresenter::class;

    protected $guarded = [];

    public $translatable = [
        'title',
        'slug',
        'status',
        //meta
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];

    public function allForSelect(): array
    {
        $categories = $this->order()
            ->get()
            ->pluck('title', 'id')
            ->all();

        return ['' => ''] + $categories;
    }

    public function getThumbAttribute(): string
    {
        return $this->present()->image(null, 54);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(File::class, 'image_id');
    }

    public function url(){
        if(Route::has(app()->getLocale()."::qa")){
            return route(app()->getLocale()."::qa",$this->slug);
        }else{
            return '/';
        }
    }
}
