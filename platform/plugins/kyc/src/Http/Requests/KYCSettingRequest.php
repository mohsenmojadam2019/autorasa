<?php

namespace Botble\Kyc\Http\Requests;

use Botble\Base\Rules\OnOffRule;
use Botble\Media\Facades\RvMedia;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class KYCSettingRequest extends Request
{
    public function rules(): array
    {
        $rules = [
            'kyc_driver' => ['required', 'string', 'in:public,s3,r2,do_spaces,wasabi,bunnycdn,backblaze'],
            'kyc_aws_access_key_id' => ['nullable', 'string', 'required_if:kyc_driver,s3'],
            'kyc_aws_secret_key' => ['nullable', 'string', 'required_if:kyc_driver,s3'],
            'kyc_aws_default_region' => ['nullable', 'string', 'required_if:kyc_driver,s3'],
            'kyc_aws_bucket' => ['nullable', 'string', 'required_if:kyc_driver,s3'],
            'kyc_aws_url' => ['nullable', 'string', 'required_if:kyc_driver,s3'],
            'kyc_aws_endpoint' => ['nullable', 'string'],
            'kyc_aws_use_path_style_endpoint' => $onOffRule = new OnOffRule(),
            'kyc_r2_access_key_id' => ['nullable', 'string', 'required_if:kyc_driver,r2'],
            'kyc_r2_secret_key' => ['nullable', 'string', 'required_if:kyc_driver,r2'],
            'kyc_r2_bucket' => ['nullable', 'string', 'required_if:kyc_driver,r2'],
            'kyc_r2_endpoint' => ['nullable', 'string', 'required_if:kyc_driver,r2'],
            'kyc_r2_url' => ['nullable', 'string', 'required_if:kyc_driver,r2'],
            'kyc_r2_use_path_style_endpoint' => $onOffRule,

            'kyc_wasabi_access_key_id' => ['nullable', 'string', 'required_if:kyc_driver,wasabi'],
            'kyc_wasabi_secret_key' => ['nullable', 'string', 'required_if:kyc_driver,wasabi'],
            'kyc_wasabi_default_region' => ['nullable', 'string', 'required_if:kyc_driver,wasabi'],
            'kyc_wasabi_bucket' => ['nullable', 'string', 'required_if:kyc_driver,wasabi'],
            'kyc_wasabi_root' => ['nullable', 'string'],

            'kyc_do_spaces_access_key_id' => ['nullable', 'string', 'required_if:kyc_driver,do_spaces'],
            'kyc_do_spaces_secret_key' => ['nullable', 'string', 'required_if:kyc_driver,do_spaces'],
            'kyc_do_spaces_default_region' => ['nullable', 'string', 'size:4', 'required_if:kyc_driver,do_spaces,in:NYC1,NYC2,NYC3,SFO1,SFO2,SFO3,TOR1,LON1,AMS2,AMS3,FRA1,SGP1,BLR1,SYD1'],
            'kyc_do_spaces_bucket' => ['nullable', 'string', 'required_if:kyc_driver,do_spaces'],
            'kyc_do_spaces_endpoint' => ['nullable', 'string', 'required_if:kyc_driver,do_spaces'],
            'kyc_do_spaces_cdn_enabled' => $onOffRule,
            'kyc_do_spaces_cdn_custom_domain' => ['nullable', 'url', 'required_if:kyc_driver,do_spaces'],
            'kyc_do_spaces_use_path_style_endpoint' => $onOffRule,

            'kyc_bunnycdn_hostname' => ['nullable', 'string', 'required_if:kyc_driver,bunnycdn'],
            'kyc_bunnycdn_zone' => ['nullable', 'string', 'required_if:kyc_driver,bunnycdn'],
            'kyc_bunnycdn_key' => ['nullable', 'string', 'required_if:kyc_driver,bunnycdn'],
            'kyc_bunnycdn_region' => ['nullable', 'string', 'max:200'],

            'kyc_backblaze_access_key_id' => ['nullable', 'string', 'required_if:kyc_driver,backblaze'],
            'kyc_backblaze_secret_key' => ['nullable', 'string', 'required_if:kyc_driver,backblaze'],
            'kyc_backblaze_bucket' => ['nullable', 'string', 'required_if:kyc_driver,backblaze'],
            'kyc_backblaze_default_region' => ['nullable', 'string', 'required_if:kyc_driver,backblaze'],
            'kyc_backblaze_endpoint' => ['nullable', 'string', 'required_if:kyc_driver,backblaze'],
            'kyc_backblaze_url' => ['nullable', 'url'],
            'kyc_backblaze_use_path_style_endpoint' => $onOffRule,

            'kyc_turn_off_automatic_url_translation_into_latin' => $onOffRule,
            'kyc_use_original_name_for_file_path' => $onOffRule,
            'kyc_keep_original_file_size_and_quality' => $onOffRule,
//            'kyc_default_placeholder_image' => ['nullable', 'string'],
            'kyc_default_placeholder_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
            'max_upload_filesize' => ['nullable', 'numeric', 'min:0', 'max:5120'],

            'kyc_chunk_enabled' => $onOffRule,
            'kyc_chunk_size' => [ 'numeric', 'min:0'],
            'kyc_max_file_size' => [ 'numeric', 'min:0', 'max:5120'],

            'kyc_folders_can_add_watermark' => ['nullable', 'array'],
            'kyc_folders_can_add_watermark.*' => ['nullable', 'string'],

            'kyc_watermark_enabled' => $onOffRule,
            'kyc_image_processing_library' => ['nullable', 'in:gd,imagick'],
            'kyc_watermark_source' => ['nullable', 'string', 'required_if:kyc_watermark_enabled,1'],
            'kyc_watermark_size' => ['nullable', 'numeric', 'min:0', 'required_if:kyc_watermark_enabled,1'],
            'kyc_watermark_opacity' => ['nullable', 'numeric', 'min:0', 'max:100', 'required_if:kyc_watermark_enabled,1'],
            'kyc_watermark_position' => [
                'nullable',
                Rule::in(['top-left', 'top-right', 'bottom-left', 'bottom-right', 'center']),
                'required_if:kyc_watermark_enabled,1',
            ],
            'kyc_watermark_position_x' => ['nullable', 'numeric', 'min:0', 'required_if:kyc_watermark_enabled,1'],
            'kyc_watermark_position_y' => ['nullable', 'numeric', 'min:0', 'required_if:kyc_watermark_enabled,1'],
            'kyc_thumbnail_crop_position' => [
                'nullable',
                Rule::in(['left', 'right', 'bottom', 'top', 'center']),
            ],
            'user_can_only_view_own_kyc' => [$onOffRule],
            'kyc_convert_image_to_webp' => [$onOffRule],
            'kyc_enable_thumbnail_sizes' => [$onOffRule],
            'kyc_reduce_large_image_size' => [$onOffRule],
            'kyc_image_max_width' => ['nullable', 'numeric', 'min:200'],
            'kyc_image_max_height' => ['nullable', 'numeric', 'min:200'],
            'kyc_customize_upload_path' => [$onOffRule],
            'kyc_upload_path' => ['required', 'string', 'max:255'],
        ];

        foreach (array_keys(RvMedia::getSizes()) as $size) {
            $rules['kyc_sizes_' . $size . '_width'] = ['required', 'numeric', 'min:0'];
            $rules['kyc_sizes_' . $size . '_height'] = ['required', 'numeric', 'min:0'];
        }

        return apply_filters('cms_kyc_settings_validation_rules', $rules);
    }

    public function attributes(): array
    {
        $attributes = [];

        foreach (array_keys(RvMedia::getSizes()) as $size) {
            $attributes['kyc_sizes_' . $size . '_width'] = trans('plugins/kyc::kyc.media_size_width', ['size' => ucfirst($size)]);
            $attributes['kyc_sizes_' . $size . '_height'] = trans('plugins/kyc::kyc.media_size_height', ['size' => ucfirst($size)]);
        }

        return $attributes;
    }
}
