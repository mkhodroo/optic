<?php

namespace ViewBuilder\Models; // مطمئن شوید این namespace با ساختار پروژه شما مطابقت دارد

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;


class ViewBuilder extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $incrementing = false;
    protected $keyType = 'string';
    public $table = 'wf_views';


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'route_name',
        'route_path',
        'permission_name',
        'middleware',
        'main_entity',
        'display_columns',
        'advanced_search_form_id',
        'after_search_script_id',
        'before_display_rows_script',
        'detail_view_form_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    // protected $casts = [
    //     'middleware' => 'array', // تبدیل JSON به آرایه PHP
    //     'display_columns' => 'array', // تبدیل JSON به آرایه PHP
    // ];

    // می توانید روابط (Relationships) را اینجا اضافه کنید، به عنوان مثال:
    //
    // public function permission()
    // {
    //     return $this->belongsTo(Permission::class, 'permission_name', 'name'); // اگر نام دسترسی در جدول permissions ذخیره می شود
    // }
    //
    // public function mainEntity()
    // {
    //     // این رابطه کمی پیچیده تر است چون نام کلاس در یک رشته ذخیره شده.
    //     // ممکن است نیاز به یک متد کمکی یا custom relationship داشته باشید.
    //     // مثال ساده:
    //     return $this->hasOne(config('app.models.' . $this->main_entity), 'id', 'id'); // این فرض می کند نام کلاس در config ذخیره شده و کلید اصلی یکی است که صحیح نیست.
    //     // راه بهتر این است که یک متد بسازید که کلاس را instance کند و query بزند.
    // }
    //
    // public function getEntityInstanceAttribute()
    // {
    //     if (!class_exists($this->main_entity)) {
    //         return null;
    //     }
    //     return new $this->main_entity;
    // }

    /**
     * متد کمکی برای گرفتن instance مدل اصلی
     *
     * @return Model|null
     */
    public function getMainEntityInstance()
    {
        if (empty($this->main_entity) || !class_exists($this->main_entity)) {
            // اگر نام موجودیت اصلی خالی است یا کلاس وجود ندارد، null برگردان
            return null;
        }
        // اگر main_entity شامل namespace کامل است، مستقیما استفاده کن
        return new $this->main_entity;
    }

     /**
     * متد کمکی برای گرفتن instance فرم جستجوی پیشرفته
     *
     * @return Model|null
     */
    public function getAdvancedSearchFormInstance()
    {
        if (empty($this->advanced_search_form_id)) {
            return null;
        }
        // این فرض می کند که نام فرم جستجو، نام کامل یک کلاس است
        // اگر نام فرم فقط نام کلاس است و namespace ندارد، باید namespace را اضافه کنید
        $formClass = $this->advanced_search_form_id;
        if (!class_exists($formClass)) {
             // ممکن است نیاز باشد namespace پیش فرض را اضافه کنید، مثلا:
             // $formClass = 'App\\Forms\\' . $formClass;
             // این بستگی به ساختار پروژه شما دارد.
             return null;
        }
        return new $formClass;
    }

     /**
     * متد کمکی برای گرفتن instance فرم نمایش جزئیات
     *
     * @return Model|null
     */
    public function getDetailViewFormInstance()
    {
        if (empty($this->detail_view_form_id)) {
            return null;
        }
        $formClass = $this->detail_view_form_id;
        if (!class_exists($formClass)) {
             // ممکن است نیاز باشد namespace پیش فرض را اضافه کنید
             return null;
        }
        return new $formClass;
    }
}
