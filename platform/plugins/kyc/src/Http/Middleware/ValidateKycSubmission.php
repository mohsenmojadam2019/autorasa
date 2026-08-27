<?php

namespace Botble\Kyc\Http\Middleware;

use Botble\Kyc\Models\Kyc;
use Botble\Kyc\Models\KYCField;
use Botble\Kyc\Models\KYCSubmission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ValidateKycSubmission
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth('customer')->user();

        if (! $user) {
            abort(401);
        }

        $request->validate([
            'fields' => ['required', 'array'],
        ]);

        $kyc = Kyc::query()
            ->where('model', strtolower(class_basename($user)))
            ->first();

        if (! $kyc) {
            throw ValidationException::withMessages([
                'fields' => 'فرایند احراز هویت برای این کاربر تعریف نشده است.',
            ]);
        }

        $fields = KYCField::query()
            ->where('kyc_entry_id', $kyc->getKey())
            ->get(['id', 'field_name', 'is_required']);

        $allowedIds = $fields->pluck('id')->map(fn ($id) => (string) $id)->all();
        $submittedFields = $request->input('fields', []);

        foreach (array_keys($submittedFields) as $fieldId) {
            if (! in_array((string) $fieldId, $allowedIds, true)) {
                throw ValidationException::withMessages([
                    "fields.{$fieldId}" => 'این فیلد متعلق به فرایند احراز هویت جاری نیست.',
                ]);
            }
        }

        $errors = [];

        foreach ($fields->where('is_required', true) as $field) {
            $fieldId = (string) $field->getKey();
            $value = $request->file("fields.{$fieldId}") ?? ($submittedFields[$fieldId] ?? null);

            if ($this->hasValue($value)) {
                continue;
            }

            $hasExistingValue = KYCSubmission::query()
                ->where('kyc_entry_id', $kyc->getKey())
                ->where('kyc_field_id', $field->getKey())
                ->where('modelable_id', $user->getKey())
                ->where('modelable_type', $user::class)
                ->whereNotNull('value')
                ->where('value', '!=', '')
                ->exists();

            if (! $hasExistingValue) {
                $errors["fields.{$fieldId}"] = sprintf('فیلد «%s» الزامی است.', $field->field_name);
            }
        }

        if ($errors !== []) {
            throw ValidationException::withMessages($errors);
        }

        return $next($request);
    }

    private function hasValue(mixed $value): bool
    {
        if ($value instanceof \Illuminate\Http\UploadedFile) {
            return $value->isValid();
        }

        if (is_array($value)) {
            return $value !== [];
        }

        return $value !== null && trim((string) $value) !== '';
    }
}
