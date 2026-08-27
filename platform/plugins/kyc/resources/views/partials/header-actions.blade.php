<x-core::button
    tag="a"
    data-bs-toggle="modal"
    data-bs-target="#kyc-field-modal"
    :href="route('kyc-fields.create', ['kyc_entry_id' => BaseHelper::stringify($field->id)])"
    icon="ti ti-plus"
>
    {{ trans('plugins/kyc::kyc.add_new') }}
</x-core::button>
