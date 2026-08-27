<?php

namespace Botble\Ecommerce\Http\Controllers;

use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Supports\Breadcrumb;
use Botble\Ecommerce\Forms\DimensionForm;
use Botble\Ecommerce\Http\Requests\DimensionRequest;
use Botble\Ecommerce\Http\Resources\DimensionResource;
use Botble\Ecommerce\Models\Dimension;
use Botble\Ecommerce\Tables\DimensionTable;
use Illuminate\Http\Request;

class DimensionController extends BaseController
{
    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('plugins/ecommerce::dimensions.menu'), route('dimensions.index'));
    }

    public function index(DimensionTable $dataTable)
    {
        $this->pageTitle(trans('plugins/ecommerce::dimensions.menu'));

        return $dataTable->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/ecommerce::dimensions.create'));

        return DimensionForm::create()->renderForm();
    }

    public function store(DimensionRequest $request)
    {
        /**
         * @var Dimension $dimension
         */
        $dimension = Dimension::query()->create($request->input());

        $dimension->categories()->detach();

        $dimension->categories()->sync((array) $request->input('categories', []));

        event(new CreatedContentEvent(BRAND_MODULE_SCREEN_NAME, $request, $dimension));

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('dimensions.index'))
            ->setNextUrl(route('dimensions.edit', $dimension->id))
            ->withCreatedSuccessMessage();
    }

    public function edit(Dimension $dimension)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $dimension->name]));

        return DimensionForm::createFromModel($dimension)->renderForm();
    }

    public function update(Dimension $dimension, DimensionRequest $request)
    {
        $dimension->fill($request->input());
        $dimension->save();

        $dimension->categories()->detach();

        $dimension->categories()->sync((array) $request->input('categories', []));

        event(new UpdatedContentEvent(BRAND_MODULE_SCREEN_NAME, $request, $dimension));

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('dimensions.index'))
            ->withUpdatedSuccessMessage();
    }

    public function destroy(Dimension $dimension)
    {
        return DeleteResourceAction::make($dimension);
    }

    public function getSearch(Request $request)
    {
        $term = $request->input('search');

        $categories = Dimension::query()
            ->select(['id', 'name'])
            ->where('name', 'LIKE', '%' . $term . '%')
            ->paginate(10);

        $data = DimensionResource::collection($categories);

        return $this
            ->httpResponse()
            ->setData($data)->toApiResponse();
    }
}
