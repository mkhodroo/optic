<?php

namespace Arghavan\FinReport\Models;

use Behin\SimpleWorkflow\Controllers\Core\FormController;
use Behin\SimpleWorkflow\Controllers\Core\VariableController;
use Behin\SimpleWorkflow\Models\Core\Cases as CoreCases;
use Behin\SimpleWorkflow\Models\Core\Process;
use Behin\SimpleWorkflow\Models\Core\Variable;
use Behin\SimpleWorkflow\Models\Entities\Case_customer;
use Behin\SimpleWorkflow\Models\Entities\Device_repair;
use Behin\SimpleWorkflow\Models\Entities\Repair_incomes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Behin\SimpleWorkflow\Models\Core\Inbox;


class Cases extends CoreCases
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';
    public $table = 'wf_cases';


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
    protected $fillable = [
        'process_id',
        'number',
        'name',
        'creator'
    ];

    public function variables()
    {
        return VariableController::getVariablesByCaseId($this->id);
    }

    public function process()
    {
        return $this->belongsTo(Process::class, 'process_id');
    }

    public function repairIncomes()
    {
        return $this->hasMany(Repair_incomes::class, 'case_number', 'number');
        // 'case_number' نام ستون در جدول repair_incomes است که به case مربوط می‌شود.
        // 'your_case_id_column' نام ستون کلید اصلی در جدول cases است که case_number به آن اشاره دارد (معمولا 'id').
    }

    public function caseCustomer()
    {
        return $this->belongsTo(Case_customer::class, 'number', 'case_number');
    }

    public function repair()
    {
        return $this->belongsTo(Device_repair::class, 'number', 'case_number');
    }

    public function repairCategory()
    {
        // از HasMany استفاده می‌کنیم چون یک کیس می‌تواند چندین 'repair_category' داشته باشد (هرچند بعید است)
        // اگر مطمئن هستید هر کیس فقط یک repair_category دارد، می‌توانید از hasOne استفاده کنید.
        // ما فعلا HasMany را در نظر می‌گیریم.
        return $this->hasOne(Variable::class, 'case_id')
            ->where('key', 'repair_category');
    }

    public function openInboxes()
    {
        return $this->hasMany(Inbox::class, 'case_id', 'id')
            ->open()
            ->with(['task', 'actor'])
            ->orderBy('created_at');
    }
}
