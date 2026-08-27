<x-core::table>
    <x-core::table.header>
        <x-core::table.header.cell>
            {{ trans('plugins/ecommerce::product-fitment.product.fitment_table.options') }}
        </x-core::table.header.cell>
        <x-core::table.header.cell>
            {{ trans('plugins/ecommerce::product-fitment.fitment_attributes.svgicon') }}
        </x-core::table.header.cell>
        <x-core::table.header.cell>
            {{ trans('plugins/ecommerce::product-fitment.fitment_attributes.type') }}
        </x-core::table.header.cell>

        <x-core::table.header.cell />
    </x-core::table.header>


{{--@dd(request()->get('page', 1))--}}
    @if($model)
        @php
            $totalOptions = $model->options()->count();
            $perPage = 10;
            $lastPage = ceil($totalOptions / $perPage);
            $currentPage = (int) request()->get('page', 1);
        @endphp



        <x-core::table.body>
            <x-core::table.body.row>
                <x-core::table.body.cell>
                    <input
                        type="text"
                        class="form-control"
                        name="newoptionvalue"
                    />
                </x-core::table.body.cell>
                <x-core::table.body.cell>
                    <input
                        type="text"
                        class="form-control"
                        name="newoptionicon"
                    />
                    {{--                    <input type="file"--}}
                    {{--                           class="form-control"--}}
                    {{--                           name="newoptionicon"--}}
                    {{--                           accept=".jpg, .jpeg, .png, .heic, .heif"/>--}}
                </x-core::table.body.cell>
                {{--@dd($model->parent->options)--}}
                @if($model->parent_id)
                    {{-- Uncomment and use this if needed --}}
                    <x-core::table.body.cell>
                        {{--                         @dd($model->parent->options[0]->parent->name )--}}
                        <select class="form-control select_fitment" name="newparentoption" >
                            @foreach($model->parent->options as $option_parent)
                                <option value="{{$option_parent->id}}">
                                    {{$option_parent->parent?$option_parent->parent->name:''}} {{$option_parent->name}}
                                </option>
                            @endforeach
                        </select>
                    </x-core::table.body.cell>
                @endif

                <x-core::table.body.cell style="width: 7%">
                    <x-core::button
                        type="button"
                        :icon-only="true"
                        icon="ti ti-plus"
                        onclick="addOption()"
                    />
                </x-core::table.body.cell>
            </x-core::table.body.row>

            @foreach($model->latestOptions($currentPage - 1) as $key => $option)
                <x-core::table.body.row>
                    <x-core::table.body.cell>
                        <input
                            type="text"
                            class="form-control"
                            name="options[{{ $key }}][value]"
                            value="{{ $option->value ?? '' }}"
                            data-bb-toggle="option-value"
                        />
                    </x-core::table.body.cell>
                    <x-core::table.body.cell>
                        <input
                            type="text"
                            class="form-control"
                            name="options[{{ $key }}][icon]"
                            value="{{ $option->icon ?? '' }}"
                            data-bb-toggle="option-value"
                        />
                    </x-core::table.body.cell>
                    @if($model->parent_id)
                        <x-core::table.body.cell>
                            <select class="form-control select_fitment" name="options[{{ $key }}][option_parent_id]" >
                                @foreach($model->parent->options as $option_parent)
                                    <option value="{{$option_parent->id}}" @if($option->option_parent_id==$option_parent->id) selected @endif>
                                        {{$option_parent->name}}
{{--                                        {{\Botble\Ecommerce\Models\FitmentAttributeOption::find(16)->name}}--}}
                                    </option>
                                @endforeach
                            </select>
                        </x-core::table.body.cell>
                    @endif

                    <x-core::table.body.cell style="width: 7%">
                        <x-core::button
                            type="button"
                            :icon-only="true"
                            icon="ti ti-trash"
                            onclick="removeOption({{ $option->id }})"
                        />
                    </x-core::table.body.cell>
                </x-core::table.body.row>
            @endforeach

        </x-core::table.body>
        <x-core::table.body.row>
            <x-core::table.body.cell colspan="3">
            @if($lastPage > 1)
                <nav class="d-flex justify-content-center mt-4">
                    <ul class="pagination">

                        {{-- First --}}
                        @if($currentPage > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => 1]) }}">اول</a>
                            </li>
                        @endif

                        {{-- Previous --}}
                        @if($currentPage > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $currentPage - 1]) }}">قبلی</a>
                            </li>
                        @endif

                        {{-- Page Numbers --}}
                        @for($i = 1; $i <= $lastPage; $i++)
                            @if(
                                $i == 1 ||
                                $i == $lastPage ||
                                ($i >= $currentPage - 1 && $i <= $currentPage + 1) ||
                                $i <= 2 ||
                                $i >= $lastPage - 1
                            )
                                <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                    <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                                </li>
                            @elseif($i == 3 && $currentPage > 5)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @elseif($i == $lastPage - 2 && $currentPage < $lastPage - 4)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                        @endfor

                        {{-- Next --}}
                        @if($currentPage < $lastPage)
                            <li class="page-item">
                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $currentPage + 1]) }}">بعدی</a>
                            </li>
                        @endif

                        {{-- Last --}}
                        @if($currentPage < $lastPage)
                            <li class="page-item">
                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $lastPage]) }}">آخر</a>
                            </li>
                        @endif

                    </ul>
                </nav>
            @endif
            </x-core::table.body.cell>
        </x-core::table.body.row>

    @endif
</x-core::table>

@if($model)
    <script>
        {{--function addOption() {--}}
        {{--    const value = document.querySelector('[name="newoptionvalue"]').value;--}}
        {{--    const icon = document.querySelector('[name="newoptionicon"]').value;--}}
        {{--    @if($model->parent_id)--}}
        {{--    const option_parent_id=document.querySelector('[name="newparentoption"]').value;--}}
        {{--    @else--}}
        {{--    const option_parent_id=null;--}}
        {{--    @endif--}}
        {{--    const data = {--}}
        {{--        value: value,--}}
        {{--        attribute_id: {{ $model->id }},--}}
        {{--        parent_id: option_parent_id,--}}
        {{--        icon:icon--}}
        {{--    };--}}
        {{--    console.log('add', data);--}}

        {{--    // Optionally send to server via AJAX here--}}
        {{--    axios.post("{{ route('ecommerce.fitment-attributes.option.add') }}", data)--}}
        {{--        .then(response => location.reload())--}}
        {{--        .catch(error => console.error(error));--}}
        {{--}--}}
        function addOption() {
            const value = document.querySelector('[name="newoptionvalue"]').value;
            const iconInput = document.querySelector('[name="newoptionicon"]').value;
            // const iconFile = iconInput.files[0];

            @if($model->parent_id)
            const option_parent_id = document.querySelector('[name="newparentoption"]').value;
            @else
            const option_parent_id = null;
            @endif

            const formData = new FormData();
            formData.append('value', value);
            formData.append('attribute_id', {{ $model->id }});
            formData.append('icon', iconInput);
            if (option_parent_id) {
                formData.append('parent_id', option_parent_id);
            }

            axios.post("{{ route('ecommerce.fitment-attributes.option.add') }}", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(response => {
                    location.reload();
                })
                .catch(error => {
                    console.error(error.response?.data ?? error);
                    alert(error.response?.data?.message || 'Upload failed');
                });
        }
        function removeOption(id) {
            const data = {
                id: id,
            };

            axios.delete("{{ route('ecommerce.fitment-attributes.option.remove') }}", {
                data: data
            })
                .then(response => {
                    alert(response.data.message || 'Option deleted');
                    location.reload();
                })
                .catch(error => {
                    console.error(error.response?.data ?? error);
                    alert('Failed to remove option');
                });
        }

    </script>
@endif
