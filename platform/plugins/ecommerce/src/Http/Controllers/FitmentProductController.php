<?php

namespace Botble\Ecommerce\Http\Controllers;

use App\Rules\ValidFitmentOption;
use Botble\Base\Supports\Breadcrumb;
use Botble\Ecommerce\Models\FitmentGroup;
use Botble\Ecommerce\Models\FitmentProduct;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Tables\FitmentProductTable;
use Illuminate\Http\Request;

class FitmentProductController extends BaseController
{
    public function index(Request $request)
    {
        return app(FitmentProductTable::class)->renderTable();
    }

    public function edit(string $product_id)
    {
        $product = Product::with('fitments')->findOrFail($product_id); // assuming relation exists

        $fitmentGroups = FitmentGroup::with(['fitmentAttributes.options'])->orderBy('id','desc')->get();

        return view('plugins/ecommerce::fitment-products.index', compact( 'fitmentGroups','product'));
    }

    public function addOption(Request $request)
    {
        $input = $request->all();
        $validated = [];

        foreach ($input as $index => $item) {
            $optionIds = is_array($item['option_id']) ? $item['option_id'] : [$item['option_id']];

            foreach ($optionIds as $optionIndex => $optionId) {
                $validator = \Validator::make([
                    'product_id'   => $item['product_id'],
                    'attribute_id' => $item['attribute_id'],
                    'option_id'    => $optionId,
                ], [
                    'product_id' => 'required|integer|exists:ec_products,id',
                    'attribute_id' => 'required|integer|exists:ec_fitment_attributes,id',
                    'option_id' => [
                        'required',
                        'integer',
                        'exists:ec_fitment_attribute_options,id',
                        new \Botble\Ecommerce\Rules\ValidFitmentOption($item['attribute_id']),
                    ],
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'message' => 'خطا در داده‌های ورودی',
                        'errors' => $validator->errors(),
                        'index' => $index,
                        'option_index' => $optionIndex,
                    ], 422);
                }

                $validated[] = $validator->validated();
            }
        }

        foreach ($validated as $data) {
            FitmentProduct::updateOrCreate(
                [
                    'product_id'   => $data['product_id'],
                    'attribute_id' => $data['attribute_id'],
                    'option_id'    => $data['option_id'],
                ],
                []
            );
        }

        return response()->json(['message' => 'Options updated successfully.']);
    }

    public function removeOption(Request $request)
    {
        $result = FitmentProduct::where('product_id', $request->product_id)
            ->where('attribute_id', $request->attribute_id)
            ->where('option_id', $request->option_id)
            ->first();
//dd($result);
        if ($result) {
            $result->delete();
        }

        return response()->json(['success' => (bool) $result]);
    }


    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('plugins/ecommerce::product-fitment.fitment_products.title'), route($this->getIndexRouteName()));
    }
    protected function getIndexRouteName(): string
    {
        return 'ecommerce.fitment-products.index';
    }

    public function details(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:ec_products,id',
            'attribute_id' => 'required|exists:ec_fitment_attributes,id',
        ]);
//        $childrens=FitmentProduct::where('product_id',$request->product_id)->where('attribute_id',$request->attribute_id)->with('option')->get();
        $childrens = FitmentProduct::where('product_id', $request->product_id)
            ->where('attribute_id', $request->attribute_id)
            ->with(['option','option.children']) // لود option و parent
            ->get();

        return response()->json(['message' => 'Attribute fetch successfully','data'=>$childrens]);
    }
}
