<select class="form-select" name="fitment_table_id" id="fitment_table_id">
    <option value="">{{ trans('plugins/ecommerce::product-fitment.product.fitment_table.select_none') }}</option>
    @foreach($tables as $value => $label)
        <option value="{{ $value }}" @selected($model->fitment_table_id === $value)>{{ $label }}</option>
    @endforeach
</select>
