<div class="kyc-field-form-wrapper">
    <form action="">

        <!-- Field Name -->
        <div class="col-md-6 col-sm-6">
            <x-core::form.text-input
                :label="__('Field Name')"
                name="field_name"
                :value="$kycField->field_name ?? ''"
                class="form-control"
                required
            />
        </div>


        <!-- Field Type -->
        <div class="col-md-6 col-sm-6">
            <x-core::form-group>
                <x-core::form.label for="field_type" class="required">
                    {{ __('Field Type') }}
                </x-core::form.label>
                <x-core::form.select
                    name="field_type"
                    :value="$kycField->field_type ?? ''"
                    class="form-control"
                    required
                >
                    <option value="">{{ __('Select field type...') }}</option>
                    @foreach (\Botble\Kyc\Models\KYCField::$field_types as $type)
                        <option value="{{ $type }}" @if(($kycField->field_type ?? '') == $type) selected @endif>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </x-core::form.select>
            </x-core::form-group>
        </div>

        <!-- Field Type -->
        <div class="col-md-6 col-sm-6">
            <x-core::form-group>
                <x-core::form.label for="status" class="required">
                    {{ __('Status') }}
                </x-core::form.label>
                <x-core::form.select
                    name="status"
                    :value="$kycField->status ?? ''"
                    class="form-control"
                    required
                >
                    <option value="" >{{ __('Select status type...') }}</option>
                    @foreach (\Botble\Kyc\Enums\KycFieldStatusEnum::labels() as $status)
                        <option value="{{ $status }}" @if(($kycField->status ?? '') == $status) selected @endif>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </x-core::form.select>
            </x-core::form-group>
        </div>

        <!-- Is Required -->
        <div class="col-md-6 col-sm-6">
            <x-core::form.on-off.checkbox
                :label="__('Is Required')"
                name="is_required"
                :checked="$kycField->is_required ?? false"
            />
        </div>

    </form>
</div>
