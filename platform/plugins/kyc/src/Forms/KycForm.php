<?php

namespace Botble\Kyc\Forms;

use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Kyc\Enums\KycStatusEnum;
use Botble\Kyc\Http\Requests\KycRequest;
use Botble\Kyc\Models\Kyc;
use Botble\Kyc\Tables\KycFieldTable;
use Botble\Kyc\Tables\KycGroupFieldTable;
use Botble\Table\TableBuilder;

class KycForm extends FormAbstract
{
    public function __construct(protected TableBuilder $tableBuilder)
    {
        parent::__construct();
    }

    public function setup(): void
    {
        $userTypes = $this->getUserTypes(); // Fetch user types dynamically
        $this
            ->model(Kyc::class)
            ->setValidatorClass(KycRequest::class)
             ->add(
                 'model',
                 SelectField::class,
                 SelectFieldOption::make()
                     ->label(trans('plugins/kyc::kyc.name'))
                     ->choices($userTypes)
                     ->selected($this->getModel()->model)
             )
            ->add(
                'route_name_pattern',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/kyc::kyc.route_name_pattern'))
                    ->required()
                    ->maxLength(120)
            )
            ->add(
                'redirect_if_not_logged_in',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/kyc::kyc.redirect_if_not_logged_in'))
                    ->required()
                    ->maxLength(120)
            )
            ->add('status', SelectField::class, StatusFieldOption::make()->choices(KycStatusEnum::labels()))
            ->when(
                $this->getModel()->exists,
                function (FormAbstract $form): void {
//                    dd( $this->tableBuilder->create(KycGroupFieldTable::class));
                    $this->addMetaBoxes([
                        'group_fields' => [
                            'title' => trans('plugins/kyc::kyc.group_fields'),
                            'content' => $this->tableBuilder->create(KycGroupFieldTable::class)
                                ->setAjaxUrl(route(
                                    'kyc-group-fields.index',
                                    $this->getModel()->id ?: 0
                                ))
                                ->renderTable([
                                    'kyc-field-id' => $this->getModel()->getKey(),
                                ]),
                            'header_actions' => view('plugins/kyc::partials.new-group-action', [
                                'field' => $this->getModel(),
                            ])->render(),
                            'has_table' => true,
                        ],
                    ]);
                })
            ->when(
                $this->getModel()->exists,
                function (FormAbstract $form): void {
                    $this->addMetaBoxes([
                        'fields' => [
                            'title' => trans('plugins/kyc::kyc.fields'),
                            'content' => $this->tableBuilder->create(KycFieldTable::class)
                                ->setAjaxUrl(route(
                                    'kyc-fields.index',
                                    $this->getModel()->id ?: 0
                                ))
                                ->renderTable([
                                    'kyc-field-id' => $this->getModel()->getKey(),
                                ]),
                            'header_actions' => view('plugins/kyc::partials.header-actions', [
                                'field' => $this->getModel(),
                            ])->render(),
                            'has_table' => true,
                        ],
                    ]);
                })

            ->setBreakFieldPoint('status');
    }


    protected function getUserTypes(): array
    {
        return [
            'user'=>'user',
            'customer'=>'customer',
        ];
        // Define the base directory for Botble plugins
        $pluginDirectory = base_path('platform/plugins');

        $authenticatableModels = [];
        // Scan each plugin directory for models
        foreach (glob($pluginDirectory . '/*/models/*.php') as $file) {
            $className = $this->getClassFromFile($file);
            if (!class_exists($className)) {
//                array_push($arrp,$className);
                continue;
            }

            $reflectionClass = new \ReflectionClass($className);

            // Check if the class extends Authenticatable or implements Authenticatable contract
            if ($reflectionClass->isSubclassOf(\Illuminate\Foundation\Auth\User::class) ||
                $reflectionClass->implementsInterface(\Illuminate\Contracts\Auth\Authenticatable::class)) {
                $authenticatableModels[$className] = class_basename($className); // Use class name as label
            }
        }
        return $authenticatableModels;
    }

    /**
     * Get fully qualified class name from a file.
     *
     * @param string $file
     * @return string|null
     */
    protected function getClassFromFile(string $file): ?string
    {
        $content = file_get_contents($file);
        $namespace = null;

        if (preg_match('/namespace\s+(.+?);/', $content, $matches)) {
            $namespace = $matches[1];
        }

        if (preg_match('/class\s+(\w+)/', $content, $matches)) {
            $className = $matches[1];
            return $namespace ? $namespace . '\\' . $className : $className;
        }

        return null;
    }


}
