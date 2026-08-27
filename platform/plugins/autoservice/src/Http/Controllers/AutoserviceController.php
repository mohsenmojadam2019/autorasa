<?php

namespace Botble\Autoservice\Http\Controllers;

use Botble\Autoservice\Models\AutoserviceTimeslot;
use Botble\Autoservice\Models\AutoserviceWorkingHour;
use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Autoservice\Http\Requests\AutoserviceRequest;
use Botble\Autoservice\Models\Autoservice;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Autoservice\Tables\AutoserviceTable;
use Botble\Autoservice\Forms\AutoserviceForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AutoserviceController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans(trans('plugins/autoservice::autoservice.name')), route('autoservice.index'));
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
        $workingHours = ['شنبه','یکشنبه','دوشنبه','سه شنبه','چهارشنبه','پنجشنبه','جمعه'];

        $form = AutoserviceForm::create()->setRequest($request);
        $form->save();

        $autoserviceId = $form->getModel()->getKey();

        foreach ($workingHours as $workHour) {
            AutoserviceWorkingHour::create([
                'day' => $workHour,
                'service_center_id' => $autoserviceId, // ست کردن ارتباط
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
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $autoservice->name]));

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
            'start_time' => 'required',
            'end_time' => 'required',
            'service_center_id' => 'required|exists:service_centers,id',
        ]);

        $timeslot = AutoserviceTimeslot::create($data);

        return response()->json(['success' => true, 'timeslot' => $timeslot]);
    }

    public function editTimeslot(Request $request)
    {
        $validated = $request->validate([
            'start_time' => 'required',
            'end_time'   => 'required',
            'id'         => 'required|integer|exists:autoservice_time_slots,id',
        ]);

        $timeslot = AutoserviceTimeslot::find($validated['id']);

        if (!$timeslot) {
            return response()->json(['error' => 'Time Slot not found'], 404);
        }

        $timeslot->update([
            'start_time' => $validated['start_time'],
            'end_time'   => $validated['end_time'],
        ]);

        return response()->json(['success' => true, 'timeslot' => $timeslot]);
    }


    public function deleteTimeslot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:autoservice_time_slots,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $timeslot = AutoserviceTimeslot::find($request->id);
        $timeslot->delete();

        return response()->json(['success' => true]);
    }

    public function addWorkingHour(Request $request)
    {
        $data = $request->validate([
            'day' => 'required|string',
            'service_center_id' => 'required|exists:service_centers,id',
            'time_slots' => 'required|array',
        ]);

        $workingHour = AutoserviceWorkingHour::create([
            'service_center_id' => $data['service_center_id'],
            'day' => $data['day'],
        ]);

        // Attach selected time slots to the working hour
        $workingHour->timeSlots()->attach($data['time_slots']);

        return response()->json(['success' => true, 'working_hour' => $workingHour]);
    }

    public function deleteWorkingHour(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:service_center_working_hours,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $timeslot = AutoserviceWorkingHour::find($request->id);
        $timeslot->delete();

        return response()->json(['success' => true]);
    }

    public function editWorkingHour(Request $request)
    {
        $workingHour = AutoserviceWorkingHour::find($request->id);
        if (!$workingHour) {
            return response()->json(['error' => 'Working Hour not found'], 404);
        }

        $data = $request->validate([
            'day' => 'required|string',
            'time_slots' => 'required|array',
        ]);

        $workingHour->update([
            'day' => $data['day'],
        ]);

        // Sync time slots
        $workingHour->timeSlots()->sync($data['time_slots']);

        return response()->json(['success' => true, 'working_hour' => $workingHour]);
    }


}
