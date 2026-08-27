<div id="product-variations-wrapper">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Field Name</th>
            <th>Field Type</th>
            <th>Status</th>
            <th>Is Required</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($kycFields as $field)
            <tr>
                <td>
                    <input type="text" name="fields[{{ $loop->index }}][field_name]" value="{{ $field->field_name }}" class="form-control">
                </td>
                <td>
                    <select name="fields[{{ $loop->index }}][field_type]" class="form-control">
                        <option value="text" {{ $field->field_type == 'text' ? 'selected' : '' }}>Text</option>
                        <option value="number" {{ $field->field_type == 'number' ? 'selected' : '' }}>Number</option>
                        <option value="file" {{ $field->field_type == 'file' ? 'selected' : '' }}>File</option>
                    </select>
                </td>
                <td>
                    <select name="fields[{{ $loop->index }}][field_type]" class="form-control">
                        <option value="activate" {{ $field->status == 'activate' ? 'selected' : '' }}>Activate</option>
                        <option value="deactivate" {{ $field->status == 'deactivate' ? 'selected' : '' }}>Deactivate</option>
                    </select>
                </td>
                <td>
                    <input type="checkbox" name="fields[{{ $loop->index }}][is_required]" value="1" {{ $field->is_required ? 'checked' : '' }}>
                </td>
                <td>
                    <a href="#" class="btn btn-danger btn-sm">Remove</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<x-core::modal
    id="select-attribute-sets-modal"
    :title="trans('plugins/ecommerce::products.select_attribute')"
>
    <x-slot:footer>
        <x-core::button
            type="button"
            data-bs-dismiss="modal"
        >
            {{ trans('core/base::base.close') }}
        </x-core::button>

        <x-core::button
            type="button"
            color="primary"
            id="store-related-attributes-button"
            class="ms-auto"
        >
            {{ trans('plugins/ecommerce::products.save_changes') }}
        </x-core::button>
    </x-slot:footer>
</x-core::modal>

@push('footer')
    <x-core::modal
        id="add-new-product-variation-modal"
        :title="trans('plugins/ecommerce::products.add_new_variation')"
        size="xl"
    >
        <x-core::loading />
        <x-slot:footer>
            <x-core::button
                type="button"
                data-bs-dismiss="modal"
            >
                {{ trans('core/base::base.close') }}
            </x-core::button>

            <x-core::button
                type="button"
                color="primary"
                id="store-product-variation-button"
                class="ms-auto"
            >
                {{ trans('plugins/ecommerce::products.save_changes') }}
            </x-core::button>
        </x-slot:footer>
    </x-core::modal>


    <x-core::modal.action
        id="confirm-delete-version-modal"
        type="danger"
        :title="trans('plugins/ecommerce::products.delete_variation')"
        :description="trans('plugins/ecommerce::products.delete_variation_confirmation')"
        :submit-button-attrs="['id' => 'delete-version-button']"
        :submit-button-label="trans('plugins/ecommerce::products.continue')"
    />

    <x-core::modal.action
        id="delete-variations-modal"
        type="danger"
        :title="trans('plugins/ecommerce::products.delete_variations')"
        :description="trans('plugins/ecommerce::products.delete_variations_confirmation')"
        :submit-button-attrs="['id' => 'delete-selected-variations-button']"
        :submit-button-label="trans('plugins/ecommerce::products.continue')"
    />
@endpush
