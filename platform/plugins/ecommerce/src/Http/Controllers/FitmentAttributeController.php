<?php

namespace Botble\Ecommerce\Http\Controllers;

use Botble\Base\Forms\FormAbstract;
use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Supports\Breadcrumb;
use Botble\Ecommerce\Forms\FitmentAttributeForm;
use Botble\Ecommerce\Http\Requests\FitmentAttributeRequest;
use Botble\Ecommerce\Models\FitmentAttribute;
use Botble\Ecommerce\Models\FitmentAttributeOption;
use Botble\Ecommerce\Tables\FitmentAttributeTable;
//use Botble\Support\Http\Requests\Request;
use Botble\Media\Facades\RvMedia;
use Illuminate\Http\Request; // ✅ Laravel's request class
use Botble\Table\Abstracts\TableAbstract;
use Illuminate\Http\JsonResponse;

class FitmentAttributeController extends BaseController
{
    public function index()
    {
        $this->pageTitle(trans('plugins/ecommerce::product-fitment.fitment_attributes.title'));

        return app($this->getTable())->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/ecommerce::product-fitment.fitment_attributes.create.title'));
        return $this->getForm()::create()->renderForm();
    }

    public function store(FitmentAttributeRequest $request)
    {
        $model = FitmentAttribute::query()->create($request->input());
        return $this
            ->httpResponse()
            ->withCreatedSuccessMessage()
            ->setPreviousRoute($this->getIndexRouteName())
            ->setNextRoute($this->getEditRouteName(), $model);
    }

    public function edit(string $attribute)
    {
        $attribute = $this->getFitmentAttribute($attribute);

        $this->pageTitle(trans('plugins/ecommerce::product-fitment.fitment_attributes.edit.title', [
            'name' => $attribute->name,
        ]));

        return $this->getForm()::createFromModel($attribute)->renderForm();
    }

    public function update(FitmentAttributeRequest $request, $fitmentAttribute_id)
    {

        $fitmentAttribute=FitmentAttribute::find($fitmentAttribute_id);
        $fitmentAttribute->fill($request->input());
        $fitmentAttribute->save();

        return $this
            ->httpResponse()
            ->withUpdatedSuccessMessage()
            ->setPreviousRoute($this->getIndexRouteName())
            ->setNextRoute($this->getEditRouteName(), $fitmentAttribute);
    }

    public function destroy(string $attribute)
    {
        $attribute = $this->getFitmentAttribute($attribute);

        return DeleteResourceAction::make($attribute);
    }

    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('plugins/ecommerce::product-fitment.fitment_attributes.title'), route($this->getIndexRouteName()));
    }

    /**
     * @return class-string<TableAbstract>
     */
    protected function getTable(): string
    {
        return FitmentAttributeTable::class;
    }

    /**
     * @return class-string<FormAbstract>
     */
    protected function getForm(): string
    {
        return FitmentAttributeForm::class;
    }

    protected function getAdditionalDataForSaving(): array
    {
        return [];
    }

    protected function getIndexRouteName(): string
    {
        return 'ecommerce.fitment-attributes.index';
    }

    protected function getEditRouteName(): string
    {
        return 'ecommerce.fitment-attributes.edit';
    }

    protected function getFitmentAttribute(string $attribute)
    {
        return FitmentAttribute::query()->findOrFail($attribute);
    }

    public function addOption(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'attribute_id' => 'required|exists:ec_fitment_attributes,id',
            'value' => 'required|string|max:255',
//            'icon' => 'nullable|file|mimes:jpg,jpeg,png,heic,heif',
            'parent_id' => 'nullable|exists:ec_fitment_attribute_options,id',
        ]);

//        $iconPath = null;
//        if ($request->hasFile('icon')) {
//            $result = RvMedia::handleUpload($request->file('icon'), 0, 'icons/');
//            if ($result['error']) {
//                return response()->json($result, 422);
//            }
//            $iconPath = $result['data']['url'] ?? null;
//        }
//dd($iconPath);
        $option = new FitmentAttributeOption();
        $option->attribute_id = $validated['attribute_id'];
        $option->value = $validated['value'];
        $option->option_parent_id = $validated['parent_id'] ?? null;
        $option->icon =$validated['icon'] ?? null;
        $option->save();

        return response()->json([
            'message' => 'Option added successfully',
            'data' => $option,
        ]);
    }
    public function removeOption(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required|exists:ec_fitment_attribute_options,id',
        ]);

        $option = FitmentAttributeOption::find($request->id);

        if (! $option) {
            return response()->json(['message' => 'Option not found'], 404);
        }

        $option->delete();

        return response()->json(['message' => 'Option deleted successfully']);
    }
    public function getChildren(Request $request): JsonResponse
    {
//        dd($request->all());
        $request->validate([
            'id' => 'required|exists:ec_fitment_attribute_options,id',
        ]);
        $childrens=FitmentAttributeOption::where('option_parent_id',$request->id)->with(['attribute','attribute.children'])->get();
        return response()->json(['message' => 'Attribute fetch successfully','data'=>$childrens]);
    }

    public function getChildrenPublic(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required|exists:ec_fitment_attribute_options,id',
        ]);
        $productFitmentIds = \DB::table('ec_product_fitment_attribute')->pluck('option_id')->flatten()->unique();
        $childrens = FitmentAttributeOption::where('option_parent_id', $request->id)
            ->whereIn('id', $productFitmentIds)  // فیلتر کردن با استفاده از شناسه‌های موجود
            ->with(['attribute', 'attribute.children'])
            ->get();
        return response()->json(['message' => 'Attribute fetch successfully','data'=>$childrens]);
    }
    public function getGroupAttributes(Request $request): JsonResponse
    {
//        dd($request->all());
        $request->validate([
            'id' => 'required|exists:ec_fitment_groups,id',
        ]);
        $childrens=FitmentAttribute::where('group_id',$request->id)->with('options')->get();

        return response()->json(['message' => 'Option fetch successfully','data'=>$childrens]);
    }
}
