<?php

namespace Botble\Autoservice\Http\Controllers;

use Botble\Autoservice\Forms\AutoserviceForm;
use Botble\Autoservice\Http\Requests\AutoserviceRequest;
use Botble\Autoservice\Models\Autoservice;
use Botble\Autoservice\Models\AutoserviceTimeslot;
use Botble\Autoservice\Models\AutoserviceWorkingHour;
use Botble\Autoservice\Tables\AutoserviceTable;
use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AutoserviceController extends BaseController
{
    private const WEEKDAYS = ['شنبه', 'یکشنبه', 'دوشنبه', 'سه شنبه', 'چهارشنبه', 'پنجشنبه', 'جمعه'];

    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans('plugins/autoservice::autoservice.name'), route('autoservice.index'));
    }

    public function index(AutoserviceTable $table)
    {
        $this->pageTitle(trans('plugins/autoservice::autoservice.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/autoservice::autoservice.create'));

        return AutoserviceForm::create()->renderForm();
    }

    public function store(AutoserviceRequest $request)
    {
        $form = AutoserviceForm::create()->setRequest($request);
        $form->save();

        $autoserviceId = $form->getModel()->getKey();

        foreach (self::WEEKDAYS as $workHour) {
            AutoserviceWorkingHour::firstOrCreate([
                'day' => $workHour,
                'service_center_id' => $autoserviceId,
            ]);
        }

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('autoservice.index'))
            ->setNextUrl(route('autoservice.edit', $autoserviceId))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Autoservice $autoservice)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $autoservice->title]));

        return AutoserviceForm::createFromModel($autoservice)->renderForm();
    }

    public function update(Autoservice $autoservice, AutoserviceRequest $request)
    {
        AutoserviceForm::createFromModel($autoservice)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('autoservice.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Autoservice $autoservice)
    {
        return DeleteResourceAction::make($autoservice);
    }

    public function addTimeslot(Request $request)
    {
        $data = $request->validate([
            'start_time' => $this->timeRules(),
            'end_time' => [...$this->timeRules(), 'gt:start_time'],
            'service_center_id' => ['required', 'integer', 'exists:service_centers,id'],
        ]);

        $timeslot = AutoserviceTimeslot::create($data);

        return response()->json(['success' => true, 'timeslot' => $timeslot]);
    }

    public function editTimeslot(Request $request)
    {
        $validated = $request->validate([
            'start_time' => $this->timeRules(),
            'end_time' => [...$this->timeRules(), 'gt:start_time'],
            'id' => ['required', 'integer', 'exists:autoservice_time_slots,id'],
        ]);

        $timeslot = AutoserviceTimeslot::findOrFail($validated['id']);
        $timeslot->update([
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
        ]);

        return response()->json(['success' => true, 'timeslot' => $timeslot]);
    }

    public function deleteTimeslot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', 'exists:autoservice_time_slots,id'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        AutoserviceTimeslot::findOrFail($request->integer('id'))->delete();

        return response()->json(['success' => true]);
    }

    public function addWorkingHour(Request $request)
    {
        $data = $request->validate([
            'day' => ['required', 'string', Rule::in(self::WEEKDAYS)],
            'service_center_id' => ['required', 'integer', 'exists:service_centers,id'],
            'time_slots' => ['present', 'array'],
            'time_slots.*' => ['integer', 'exists:autoservice_time_slots,id'],
        ]);

        if (AutoserviceWorkingHour::query()
            ->where('service_center_id', $data['service_center_id'])
            ->where('day', $data['day'])
            ->exists()) {
            return response()->json(['error' => 'Working hour for this day already exists.'], 422);
        }

        if (! $this->timeSlotsBelongToServiceCenter($data['time_slots'], (int) $data['service_center_id'])) {
            return response()->json(['error' => 'One or more time slots do not belong to this service center.'], 422);
        }

        $workingHour = AutoserviceWorkingHour::create([
            'service_center_id' => $data['service_center_id'],
            'day' => $data['day'],
        ]);

        $workingHour->timeSlots()->sync($data['time_slots']);

        return response()->json(['success' => true, 'working_hour' => $workingHour->load('timeSlots')]);
    }

    public function deleteWorkingHour(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', 'exists:service_center_working_hours,id'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        AutoserviceWorkingHour::findOrFail($request->integer('id'))->delete();

        return response()->json(['success' => true]);
    }

    public function editWorkingHour(Request $request)
    {
        $workingHour = AutoserviceWorkingHour::find($request->input('id'));

        if (! $workingHour) {
            return response()->json(['error' => 'Working Hour not found'], 404);
        }

        $data = $request->validate([
            'day' => ['required', 'string', Rule::in(self::WEEKDAYS)],
            'time_slots' => ['present', 'array'],
            'time_slots.*' => ['integer', 'exists:autoservice_time_slots,id'],
        ]);

        if (! $this->timeSlotsBelongToServiceCenter($data['time_slots'], (int) $workingHour->service_center_id)) {
            return response()->json(['error' => 'One or more time slots do not belong to this service center.'], 422);
        }

        $duplicate = AutoserviceWorkingHour::query()
            ->where('service_center_id', $workingHour->service_center_id)
            ->where('day', $data['day'])
            ->whereKeyNot($workingHour->getKey())
            ->exists();

        if ($duplicate) {
            return response()->json(['error' => 'Working hour for this day already exists.'], 422);
        }

        $workingHour->update(['day' => $data['day']]);
        $workingHour->timeSlots()->sync($data['time_slots']);

        return response()->json(['success' => true, 'working_hour' => $workingHour->load('timeSlots')]);
    }

    private function timeRules(): array
    {
        return [
            'required',
            'integer',
            'between:0,2359',
            function (string $attribute, mixed $value, \Closure $fail): void {
                if (((int) $value) % 100 >= 60) {
                    $fail("The {$attribute} minutes must be between 00 and 59.");
                }
            },
        ];
    }

    private function timeSlotsBelongToServiceCenter(array $timeSlotIds, int $serviceCenterId): bool
    {
        if ($timeSlotIds === []) {
            return true;
        }

        $uniqueIds = array_values(array_unique(array_map('intval', $timeSlotIds)));

        return AutoserviceTimeslot::query()
            ->where('service_center_id', $serviceCenterId)
            ->whereIn('id', $uniqueIds)
            ->count() === count($uniqueIds);
    }
}
