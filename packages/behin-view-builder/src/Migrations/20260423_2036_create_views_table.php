<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('wf_views')) {
            Schema::create('wf_views', function (Blueprint $table) {
                $table->id(); // آیدی اصلی ردیف

                // 1. امکان ثبت روت و نام روت
                $table->string('route_name')->unique()->comment('نام منحصر به فرد روت'); // نام نمایشی و قابل استفاده در Route::is() یا Route::has()
                $table->string('route_path')->nullable()->comment('مسیر URL روت (مثال: /users/profile)'); // مسیر URL، میتونه null باشه اگر فقط از نام استفاده میشه

                // 2. امکان ثبت نام دسترسی برای این روت
                $table->string('permission_name')->nullable()->comment('نام دسترسی مورد نیاز (اگر خالی باشد همه دسترسی دارند)'); // اگر خالی باشد، روت عمومی است

                // 3. امکان انتخاب میدلور های اعمالی برای این روت
                // به صورت پیش فرض middleware های Web و auth باید فعال باشند.
                // اینجا لیست middleware ها را به صورت JSON ذخیره میکنیم.
                $table->json('middleware')->default(json_encode(['web', 'auth'])); // پیش فرض web و auth

                // 4. امکان ثبت موجودیت اصلی
                $table->string('main_entity')->comment('نام کلاس موجودیت اصلی (مثال: App\Models\User)'); // نام کامل کلاس مدل اصلی

                // 5. امکان ثبت و تعیین ستون های جدول
                // ذخیره ستون های مورد نیاز برای نمایش به صورت JSON
                $table->json('display_columns')->comment('ستون هایی که در جدول نمایش داده میشوند');

                // 6. امکان ثبت و انتخاب فرم جستجو پیشرفته
                $table->uuid('advanced_search_form_id')->nullable()->comment('نام فرم جستجو پیشرفته');

                // 7. امکان ثبت اسکریپت پس از جستجو پیشرفته
                $table->uuid('after_search_script_id')->nullable()->comment('اسکریپت PHP یا کدی که پس از جستجو اجرا میشود');

                // 8. امکان ثبت اجرای اسکریپت قبل از نمایش ردیف ها
                $table->uuid('before_display_rows_script')->nullable()->comment('اسکریپت PHP که قبل از نمایش ردیف ها اجرا میشود');

                // 9. امکان ثبت فرم نمایش جزئیات بیشتر
                $table->uuid('detail_view_form_id')->nullable()->comment('نام فرم نمایش جزئیات');

                $table->timestamps(); // created_at و updated_at
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wf_views');
    }
};
