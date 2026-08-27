<x-core::table>
    <x-core::form xmlns:x-core="http://www.w3.org/1999/html">
        <select class="form-control m-3 form-select is-valid" required="required" id="parent" name="parent_id" aria-required="true" aria-invalid="false" aria-describedby="type-error">
            <option @if($parent==null) selected @endif value="null" selected>
                {{ trans('plugins/ecommerce::product-fitment.product.fitment_table.no_parent') }}
            </option>
            @foreach($parentFields as $key=>$item)
                <option @if($parent==$item->id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
            @endforeach
        </select>
    </x-core::form>
    <x-core::table.header>
        <x-core::table.header.cell>
            {{ trans('plugins/ecommerce::product-fitment.product.fitment_table.parent') }}
        </x-core::table.header.cell>
        <x-core::table.header.cell />
    </x-core::table.header>
    <x-core::table.body>

{{--        @foreach(is_array($options)? $options : json_decode($options, true) as $option)--}}
{{--            @dd($option['value'])--}}
{{--            <x-core::table.body.row>--}}
{{--                <x-core::table.body.cell>--}}
{{--                    <input--}}
{{--                        type="text"--}}
{{--                        class="form-control"--}}
{{--                        name="options[{{$loop->index}}][value]"--}}
{{--                        value="{{$option['value']}}"--}}
{{--                        data-bb-toggle="option-value"--}}
{{--                    />--}}
{{--                    {{ print_r($option['value'])  }}--}}
{{--                </x-core::table.body.cell>--}}
{{--                <x-core::table.body.cell>--}}
{{--                    <select--}}
{{--                        type="text"--}}
{{--                        class="form-control parent-children"--}}
{{--                        name="options[{{$loop->index}}][parent]"--}}
{{--                    >--}}
{{--                    </select>--}}
{{--                </x-core::table.body.cell>--}}
{{--                <x-core::table.body.cell style="width: 7%">--}}
{{--                    <x-core::button--}}
{{--                        type="button"--}}
{{--                        :icon-only="true"--}}
{{--                        icon="ti ti-trash"--}}
{{--                        data-bb-toggle="remove-option"--}}
{{--                    />--}}
{{--                </x-core::table.body.cell>--}}
{{--            </x-core::table.body.row>--}}
{{--        @endforeach--}}
    </x-core::table.body>
</x-core::table>
<x-core::button type="button" data-bb-toggle="add-option" icon="ti ti-plus">
    {{ trans('plugins/ecommerce::product-fitment.fitment_attributes.options.add.label') }}
</x-core::button>
<script>
    $(function() {
        let optionCounter = <?=sizeof($options)?>;
        let parent=null;
        $(document)
            .on('change', '.js-base-form select[name="type"]', (e) => {
                const $currentTarget = $(e.currentTarget)
                const $options = $currentTarget.closest('form').find('.fitment-attribute-parent')

                if ($currentTarget.val() === 'parent') {
                    $options.show()
                } else {
                    $options.hide()
                }
            })
        {{--    .on('change', '#parent', (e) => {--}}
        {{--    const $currentTarget = $(e.currentTarget);--}}
        {{--    const selectedValue = $currentTarget.val();--}}
        {{--    const parentFields = <?= json_encode($parentFields)?>;--}}
        {{--    const selectedField = parentFields.find(field => field.id == selectedValue);--}}
        {{--    const $options = $currentTarget.closest('form').find('.parent-children');--}}
        {{--    let $optionsFields = selectedField.options;--}}
        {{--    console.log($optionsFields);--}}
        {{--    let html = '';--}}
        {{--    $.each($optionsFields, (index, item) => {--}}
        {{--        html += `<option value="${item}">${item}</option>`;--}}
        {{--    });--}}
        {{--    $options.html(html);--}}
        {{--})--}}
            .on('click', '[data-bb-toggle="add-option"]', (e) => {
            e.preventDefault()

            const $currentTarget = $(e.currentTarget)
            const $table = $currentTarget.closest('.card').find('table')


            $table.append($tr)

            optionCounter++;
        })
            // .on('click', '[data-bb-toggle="remove-option"]', (e) => {
            //     e.preventDefault()
            //
            //     const $currentTarget = $(e.currentTarget)
            //     const $tr = $currentTarget.closest('tr')
            //
            //     $tr.remove()
            // })
    });
</script>
