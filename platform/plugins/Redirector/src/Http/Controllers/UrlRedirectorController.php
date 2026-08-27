<?php

namespace ArchiElite\UrlRedirector\Http\Controllers;

use ArchiElite\UrlRedirector\Http\Requests\StoreUrlRedirectorRequest;
use ArchiElite\UrlRedirector\Tables\UrlRedirectorTable;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use ArchiElite\UrlRedirector\Forms\UrlRedirectorForm;
use ArchiElite\UrlRedirector\Http\Requests\UpdateUrlRedirectorRequest;
use ArchiElite\UrlRedirector\Models\UrlRedirector;
use Illuminate\Http\Request;

class UrlRedirectorController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans('plugins/url-redirector::url-redirector.menu'), route('url-redirector.index'));
    }

    public function index(UrlRedirectorTable $dataTable)
    {
        $this->pageTitle(trans('plugins/url-redirector::url-redirector.menu'));

        return $dataTable->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/url-redirector::url-redirector.create'));

        return UrlRedirectorForm::create()->renderForm();
    }

    public function store(StoreUrlRedirectorRequest $request)
    {
        $form = UrlRedirectorForm::create()->setRequest($request);

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('url-redirector.index'))
            ->setNextUrl(route('url-redirector.edit', $form->getModel()->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(UrlRedirector $url, FormBuilder $formBuilder)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $url->original]));

        return $formBuilder
            ->create(UrlRedirectorForm::class, ['model' => $url])
            ->setValidatorClass(UpdateUrlRedirectorRequest::class)
            ->renderForm();
    }

    public function update(UrlRedirector $url, UpdateUrlRedirectorRequest $request)
    {
        UrlRedirectorForm::createFromModel($url)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('url-redirector.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(UrlRedirector $url)
    {
        return DeleteResourceAction::make($url);
    }

    public function handle(Request $request)
    {
        $any = $request->path(); // مسیر درخواست‌شده مثلاً "about/us"

        $fullUrl = url()->full();

        $redirect = UrlRedirector::where('original', $fullUrl)->first() ?? UrlRedirector::where('original', $any)->first();

        $meta = [
            'noindex'   => (bool) ($redirect->is_noindex ?? false),
            'nofollow'  => (bool) ($redirect->is_nofollow ?? false),
            'canonical' => $redirect->is_canonical ?? null,
        ];

        if ($redirect->is_404) {
            $statusCode = 404;
        } elseif ($redirect->is_410) {
            $statusCode = 410;
        } elseif ($redirect->is_500) {
            $statusCode = 500;
        } else {
            $statusCode = 200;
        }

        return response()
            ->view('plugins/redirector::redirector.view', compact('meta', 'redirect', 'statusCode'), $statusCode);


    }


}
