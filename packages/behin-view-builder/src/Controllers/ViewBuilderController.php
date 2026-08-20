<?php

namespace ViewBuilder\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use BaleBot\Models\BaleUser;
use Exception;
use ViewBuilder\Models\ViewBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;
use ReflectionMethod;

class ViewBuilderController extends Controller
{
    public static function baseQuery()
    {
        return ViewBuilder::query();
    }

    public static function getById($id)
    {
        return ViewBuilder::find($id);
    }

    public function index()
    {
        $rows = self::baseQuery()->get();
        return view('view-builder::index', compact('rows'));
    }

    public function create()
    {
        return view('view-builder::create');
    }

    public function store(Request $request)
    {
        // آماده سازی داده ها برای ذخیره سازی
        $data = $request->only([
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
        ]);

        // تبدیل رشته ها به آرایه (برای middleware و display_columns)
        // اگر middleware ورودی شما مثلا "web,auth" باشد، آن را به آرایه ['web', 'auth'] تبدیل می کند.
        // اگر middleware خالی باشد، آرایه خالی برمی گرداند.
        // $data['middleware'] = $data['middleware'] ? explode(',', $data['middleware']) : ['web', 'auth']; // مقدار پیش فرض هم اضافه شد

        // اگر display_columns ورودی شما مثلا "id,name,email" باشد، آن را به آرایه ['id', 'name', 'email'] تبدیل می کند.
        // $data['display_columns'] = $data['display_columns'] ? explode(',', $data['display_columns']) : [];

        // نگاشت نام فیلدهای فرم به نام ستون های جدول (در صورت نیاز)
        // در این مورد، نام ها تا حد زیادی مشابه هستند، فقط برای id ها نیاز به تغییر نام داریم.
        $preparedData = [
            'route_name' => $data['route_name'],
            'route_path' => $data['route_path'],
            'permission_name' => $data['permission_name'],
            'middleware' => $data['middleware'], // تبدیل آرایه به JSON برای ذخیره در دیتابیس
            'main_entity' => $data['main_entity'],
            'display_columns' => $data['display_columns'], // تبدیل آرایه به JSON
            'advanced_search_form_name' => $data['advanced_search_form_id'], // نگاشت id به name
            'after_search_script' => $data['after_search_script_id'], // نگاشت id به name
            'before_display_rows_script' => $data['before_display_rows_script'], // نگاشت id به name
            'detail_view_form_name' => $data['detail_view_form_id'], // نگاشت id به name
        ];


        try {
            // ایجاد رکورد جدید در جدول wf_views
            ViewBuilder::create($preparedData);

            // بازگشت به صفحه قبل با پیام موفقیت آمیز بودن عملیات
            return redirect()->back()->with('success', 'تنظیمات نما با موفقیت ذخیره شد.');
        } catch (\Exception $e) {
            // در صورت بروز خطا، به صفحه قبل برگرد با پیام خطا
            // بهتر است لاگ خطا را نیز در جایی ثبت کنید
            // Log::error('Failed to save WfView settings: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(ViewBuilder $viewBuilder)
    {
        return view('view-builder::edit', compact('viewBuilder'));
    }

    public function update(Request $request, ViewBuilder $viewBuilder)
    {
        try {
            $data = $request->all();
            $viewBuilder->update($data);
            return redirect()->back()->with(['success' => 'ویرایش شد']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function search(Request $request)
    {
        $viewBuilder = self::getById($request->viewBuilder);
        $data = $request->all();
        return $data;
        if ($data['type'] == 'column') {
            return [
                'level' => $data['level'],
                'operators' => ['equal'],
            ];
        }
        if ($data['type'] == 'relation') {
            $mainEntityClassName = $viewBuilder->main_entity;
            $class = $mainEntityClassName::first();
            for($i=0; $i < count($data['field']); $i++){
                $relation = $data['field'][$i];
                $class = $class->$relation->first();
            }
            // $relationName = $data['value'];
            // $mainEntityInstance = new $mainEntityClassName();
            // // 3. استفاده از Reflection برای یافتن متد رابطه
            // $reflectionClass = new ReflectionClass($mainEntityClassName);
            // $reflectionMethod = $reflectionClass->getMethod($relationName);
            // $relationInstance = $reflectionMethod->invoke($mainEntityInstance);

            // // 5. تعیین نوع رابطه و کلاس مرتبط
            // $relationType = '';
            // $relatedClass = '';

            // if ($relationInstance instanceof HasOne) {
            //     $relationType = 'HasOne'; // یک به یک (از دید mainEntity)
            // } elseif ($relationInstance instanceof HasMany) {
            //     $relationType = 'HasMany'; // یک به چند (از دید mainEntity)
            // } elseif ($relationInstance instanceof BelongsTo) {
            //     $relationType = 'BelongsTo'; // متعلق به (یک به یک یا یک به چند از دید طرف دیگر)
            // } elseif ($relationInstance instanceof BelongsToMany) {
            //     $relationType = 'BelongsToMany'; // چند به چند
            // } else {
            //     $relationType = 'Unknown'; // نوع رابطه نامشخص
            // }

            // کلاس مرتبط (کلاسی که mainEntity با آن رابطه دارد)
            $relatedClass = get_class($class);
            $filterItems = exploreModel($relatedClass);
            $filterItems['previuos_level'] = $data['level'];
            $filterItems['level'] = $data['level'] + 1;
            return $filterItems;

            // Namespace کلاس مرتبط
            $relatedNamespace = (new ReflectionClass($relatedClass))->getNamespaceName();

            return $reflectionMethod;
        }
    }
}
