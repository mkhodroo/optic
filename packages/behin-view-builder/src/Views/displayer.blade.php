@extends('behin-layouts.app')

@section('title', '')

@php
    use Behin\SimpleWorkflow\Controllers\Core\ViewModelController;
    use Illuminate\Support\Str;
    function resolveColumnPath($model, string $columnPath)
    {
        try {
            $path = trim($columnPath);

            // ۱. یکنواخت‌سازی: تمام ترکیب‌های پیچیده را به صورت یک ساختار واحد دربیاوریم
            // هدف: "task()->process->name" و "inbox->process()->task->name" هر دو یکسان تفسیر بشن
            $path = str_replace(['()->', '()'], '->', $path); // تابع‌ها را به همان ساختار property تبدیل می‌کنیم

            // ۲. شکستن مسیر به بخش‌های جداگانه
            $parts = explode('->', $path);

            $current = $model;

            // ۳. پیمایش مسیرها
            foreach ($parts as $part) {
                $part = trim($part);
                if (!$part) {
                    continue;
                }

                if (!$current) {
                    return null;
                }

                // بررسی اینکه آیا $current شیء Eloquent Model یا Collection هست
                if (is_iterable($current) && !is_object($current)) {
                    // اگر یک آرایه است، کلید را بررسی کن
                    $current = $current[$part] ?? null;
                    continue;
                }

                // اگر متد با همین نام وجود دارد ⇒ رابطه یا accessor است
                if (is_object($current) && method_exists($current, $part)) {
                    $result = $current->$part();

                    // اگر result یک Relation است (مثل hasOne, belongsTo و ...)
                    if ($result instanceof \Illuminate\Database\Eloquent\Relations\Relation) {
                        $current = $result->getResults(); // داده واقعی رابطه را بگیر
                    } else {
                        $current = $result;
                    }
                    continue;
                }

                // در غیر این صورت، فرض کن که property است
                if (is_object($current) && isset($current->$part)) {
                    $current = $current->$part;
                } elseif (is_array($current) && array_key_exists($part, $current)) {
                    $current = $current[$part];
                } else {
                    return null;
                }
            }

            // در نهایت مقدار به دست آمده ر برگردان
            return $current;
        } catch (\Throwable $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            فیلتر
        </div>
        <div class="card-body">
            <form action="" id="search-form" class="row">
                <select name="field[0]" id="level-0-selector" class="form-control form-select search-select col-sm-3"
                    data-level="0">
                    <option value="">انتخاب کنید</option>
                    {{-- آیتم‌های سطح اول از filterableItems --}}
                    @foreach ($filterItems['columns'] as $item)
                        <option value="{{ $item }}" data-type="column">{{ $item }}</option>
                    @endforeach
                    @foreach ($filterItems['relations'] as $item)
                        <option value="{{ $item }}" data-type="relation">{{ $item }}
                        </option>
                    @endforeach
                </select>

                {{-- اینجا بخش‌های داینامیک اضافه خواهند شد --}}
                <div id="dynamic-filters"></div>
                <div id="value-input-section" style="display: none;">
                    <select id="operator-selector">
                        {{-- اپراتورها اینجا اضافه می‌شوند --}}
                    </select>
                    <input type="text" id="filter-value" placeholder="مقدار جستجو">
                    <button id="add-filter-btn">افزودن فیلتر</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">

        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        @foreach ($columns as $column)
                            <th>[[ $column ]]</th>
                        @endforeach
                    </tr>
                </thead>
                @foreach ($records as $row)
                    <tr>
                        @foreach ($columns as $column)
                            @php
                                $column = trim($column);
                                $value = resolveColumnPath($row, $column);
                            @endphp
                            <td>[[ $value ]]</td>
                        @endforeach
                    </tr>
                @endforeach
            </table>
            {!! createPagingLinks($records) !!}
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).on('change', '.search-select', function() {
            var url = '{{ route('view-builder.search') }}';
            var fd = new FormData($('#search-form')[0]);
            fd.append('viewBuilder', '{{ $viewBuilder->id }}')
            fd.append('value', $(this).val())
            var selectedOption = $(this).find('option:selected');
            fd.append('type', selectedOption.data('type'))
            fd.append('level', $(this).data('level'))
            send_ajax_formdata_request(
                url,
                fd,
                function(response) {
                    console.log(response)
                    if (response.class) {
                        var s = '';
                        s +=
                            `<select name="field[${response.level}]" id="level-${response.level}-selector" class="form-control form-select search-select col-sm-3" data-level="${response.level}">`;

                        s += `<option value=""></option>`;

                        // اصلاح در خط زیر:
                        response.columns.forEach(function(item) {
                            s +=
                                `<option value="${item}" data-type="column">${item}</option>`;
                        });

                        response.relations.forEach(function(item) {
                            s +=
                                `<option value="${item}" data-type="relation">${item}</option>`;
                        });

                        s += '</select>';
                        $('#level-' + response.previuos_level + '-selector').after(s)
                    }
                    if (response.operators) {
                        var s = '';
                        s +=
                            `<select name='operator' class="form-control form-select col-sm-3" >`;

                        s += `<option value=""></option>`;
                        // اصلاح در خط زیر:
                        response.operators.forEach(function(item) {
                            s +=
                                `<option value="${item}">${item}</option>`;
                        });

                        s += '</select>';
                        s += '<input type="text" name="value" class="form-control col-sm-3">';
                        s +=
                        '<button id="add-filter-btn" type="submit" class="btn btn-sm btn-outline-primary">فیلتر</button>';
                        $('#level-' + response.level + '-selector').after(s)
                    }
                }
            )
        })
    </script>
    <script>
        $('#add-filter-btn').on('click', function(e) {
            e.preventDefault();
            var searchForm = $('#search-form');
            var searchFormHtml = $('#search-form').html();
            var fd = new FormData(searchForm[0]);
            fd.append('serach_form_html', searchFormHtml)
            send_ajax_formdata_request(
                '{{ url('') }}',
                fd,
                function(response){
                    console.log(response)
                }
            )
        }
         
    </script>
@endsection
