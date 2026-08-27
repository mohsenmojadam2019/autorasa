{{--@dd($product->fitmentAttributes[0])--}}
<div class="table-responsive">
    <x-core::table class="table-bordered">
        <x-core::table.header>
            <x-core::table.header.cell colspan="1">
                {{ trans('plugins/ecommerce::product-fitment.product.fitment_table.group') }}
            </x-core::table.header.cell>
            <x-core::table.header.cell colspan="8">
                {{ trans('plugins/ecommerce::product-fitment.product.fitment_table.attribute') }}
            </x-core::table.header.cell>
        </x-core::table.header>
        <x-core::table.body>
            @foreach ($fitmentTable->groups as $key=>$group)
                <x-core::table.body.row>
                    <x-core::table.body.cell colspan="1">
                        {{ $group->name }}
                    </x-core::table.body.cell>
                    <x-core::table.body.cell colspan="8">
{{--                        @dd($product->id)--}}
{{--                        @dd($group->getFitmentAttributeDetailsForProduct($product->id))--}}
{{--                        @foreach($product->fitmentAttributes as $productfitmentAttribute)--}}
{{--                            @dd($productfitmentAttribute)--}}
{{--                            @if($productfitmentAttribute->group_id==$group->id)--}}
{{--                            @php--}}
{{--                                $values = json_decode($productfitmentAttribute->pivot->value);--}}
{{--                            @endphp--}}
{{--                            @foreach($values as $value)--}}
{{--                              <span>--}}
{{--                                  <label> {{ $value }} </label>--}}
{{--                                   <input class="form-check-input" type="checkbox" name="fitment_attributes[{{ $productfitmentAttribute->id }}][value][]" value="{{ $value }}" >--}}
{{--                              </span>--}}
{{--                                @endforeach--}}
{{--                            {{ $value }}--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
                        @foreach($group->getFitmentAttributeNameForProduct($product->id) as $item)
                            <span class="fitment-tag" >{{$item}}</span>
                        @endforeach
                        <div id="modal-inputs-{{$group->id}}"></div>
                        <x-core::button
                            type="button"
                            :icon-only="true"
                            icon="ti ti-plus"
                            onclick="openModal({{ json_encode($key) }},{{$group->id}})">

                        </x-core::button>
                        <div class="modal fade"
                             id="selectModal_{{$group->id}}"
                             tabindex="-1"
                             aria-labelledby="modalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content text-dark" style="height: 600px;">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <div class="row">
                                            <div class="col-12" id="modal_content_{{$group->id}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </x-core::table.body.cell>
                </x-core::table.body.row>
            @endforeach
        </x-core::table.body>
    </x-core::table>

</div>
<style>
    .size-container div {
        border: 1px solid #C7C7C7;
        text-align: center;
        /*margin-top: 1px;*/
        /*margin-bottom: 5px;*/
    }
    .fitment-tag {
        display: inline-block;
        background-color: #f3f4f6;
        color: #1f2937;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }
    .prev-step{
        text-align: center;
    }
    .stepper-wrapper {
        font-family: Arial;
        margin-top: 50px;
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .stepper-item {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
    @media (max-width: 768px) {
        font-size: 12px;
    }
    }

    .stepper-item::before {
        position: absolute;
        content: "";
        border-bottom: 2px solid #ccc;
        width: 100%;
        top: 35px;
        left: -50%;
        z-index: 2;
    }

    .stepper-item::after {
        position: absolute;
        content: "";
        border-bottom: 2px solid #ccc;
        width: 100%;
        top: 35px;
        left: 50%;
        z-index: 2;
    }

    .stepper-item .step-counter {
        position: relative;
        z-index: 5;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #ccc;
        margin-bottom: 6px;
    }

    .stepper-item.active {
        font-weight: bold;
    }

    .stepper-item.completed .step-counter {
        background-color: #9D503C;
    }

    .stepper-item.completed::after {
        position: absolute;
        content: "";
        border-bottom: 2px solid #9D503C;
        width: 100%;
        top: 35px;
        left: 50%;
        z-index: 3;
    }

    /*.stepper-item:first-child::before {*/
    /*    content: none;*/
    /*}*/
    /*.stepper-item:last-child::after {*/
    /*    content: none;*/
    /*}*/
    .stepper-item:first-child::after,
    .stepper-item:last-child::before {
        content: none;
    }

</style>

<script>

    var filters=[];
    let currentStep = 1;
    let steps = 1;
    const fitmentGroups = <?= json_encode($fitmentTable->groups) ?>;
    function openModal(key,groupId) {
        // $('#modal_content').html('55');
        currentStep = 1;
        steps = 1;
        filters=[]
        renderFitmentModalContent(key);
        $('#selectModal_'+groupId).modal('show'); // Correct way to open the modal

    }
    function addFilter(fitmentGroupIndex,optionId,attribute_id,value) {

        const filterItem = {
            product_id: '{{$product->id}}',
            group_id: fitmentGroupIndex,
            attribute_id: attribute_id,
            option_id: optionId,
            value: value
        };

        // Check if it already exists
        const existingIndex = filters.findIndex(f =>
            f.product_id === filterItem.product_id &&
            f.group_id === filterItem.group_id &&
            f.attribute_id === filterItem.attribute_id &&
            f.option_id === filterItem.option_id &&
            f.value === filterItem.value
        );

        if (existingIndex !== -1) {
            // Already exists – remove it
            filters.splice(existingIndex, 1);
        } else {
            // Doesn't exist – add it
            filters.push(filterItem);
        }
//         let html=`<input class="form-check-input" type="checkbox" name="fitment_attributes[${attribute_id}][value][]" value="${value}" checked hidden>`;
//         // $('#modal-inputs').append(html);
// filters.push(html);
        // createInput(attribute_id,value);
        renderFitmentStep(fitmentGroupIndex,optionId);
    }
    function renderFitmentStep(key, optionId) {
        const fitmentGroup = fitmentGroups[key];
        const container = $('#modal_content_' + fitmentGroup.id);
        if (!container.length || !fitmentGroup.fitment_attributes || fitmentGroup.fitment_attributes.length === 0) return;

        const stepId = `step-${fitmentGroup.id}-` + (currentStep + 1);

        // حذف عنصر قبلی با همین ID (اگر وجود دارد)
        container.find(`#${stepId}`).remove();

        const stepContainer = document.createElement('div');
        stepContainer.className = 'step active size-container';
        stepContainer.id = stepId;

        const firstAttribute = fitmentGroup.fitment_attributes[currentStep];
        if (!firstAttribute) {

        } else {
            if (firstAttribute.icon) {
                stepContainer.innerHTML += firstAttribute.icon;
            }

            firstAttribute.options.forEach((option, index) => {
                if (option.option_parent_id == optionId) {
                    const optionDiv = document.createElement('div');
                    optionDiv.className = 'rounded-3 border-grey-blue m-1';
                    optionDiv.setAttribute('onclick', `addFilter(${key}, ${option.id}, ${option.attribute_id}, '${option.value}')`);
                    if (option.icon) {
                        optionDiv.innerHTML += option.icon;
                    }

                    const textNode = document.createTextNode(' ' + option.value);
                    optionDiv.appendChild(textNode);
                    stepContainer.appendChild(optionDiv);

                    // ایجاد label و input به صورت داینامیک
                    const label = document.createElement('label');
                    label.textContent = option.value;

                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.className = 'form-check-input';
                    checkbox.name = `fitment_attributes[${option.attribute_id}][value][]`;
                    checkbox.value = option.id;
                    const isChecked = fitmentGroup.fitmentDetails.some(detail => detail.option_id === option.id);
                    checkbox.checked = isChecked;
                    console.log('##############', fitmentGroup);
                    // checkbox.hidden = true;

                    // اضافه کردن label و input به stepContainer
                    // optionDiv.appendChild(label);
                    optionDiv.appendChild(checkbox);
                }
            });

            const prevButton = document.createElement('button');
            prevButton.type = 'button';
            prevButton.className = 'btn btn-link type-prev-step';
            prevButton.innerText = 'مرحله قبلی';
            prevButton.setAttribute('onclick', `prevStep('${fitmentGroup.id}')`);
            stepContainer.appendChild(prevButton);


            if(!fitmentGroup.fitment_attributes[currentStep]) {
                const submitButton = document.createElement('button');
                submitButton.type = 'button';
                submitButton.className = 'btn btn-link type-submit-step';
                submitButton.innerText = 'افزودن';
                submitButton.setAttribute('onclick', `next('${fitmentGroup.id}')`);
                stepContainer.appendChild(submitButton);
            }
            // else{
            //     // Add nextButton
            //     const nextButton = document.createElement('button');
            //     nextButton.type = 'button';
            //     nextButton.className = 'btn btn-link type-next-step';
            //     nextButton.innerText = 'مرحله بعدی';
            //     nextButton.setAttribute('onclick', `next('${fitmentGroup.id}')`);
            //     stepContainer.appendChild(nextButton);
            // }
            container.append(stepContainer);
            nextStep(fitmentGroup.id);
        }
    }
    // function next() {
    //     renderFitmentStep(fitmentGroupIndex,optionId);
    //
    // }
    function nextStep(fitmentGroupId) {
        if (currentStep == steps) {
            console.log('yes');
            submitSearch(fitmentGroupId); // or any other logic when steps end
            return;
        }

        // Update stepper classes
        document.getElementById(`stepper-item-${fitmentGroupId}-${currentStep}`).classList.remove('active');
        document.getElementById(`stepper-item-${fitmentGroupId}-${currentStep}`).classList.add('completed');
        document.getElementById(`stepper-item-${fitmentGroupId}-${currentStep + 1}`).classList.add('active');

        // Hide current step content and show next
        document.getElementById(`step-${fitmentGroupId}-${currentStep}`).classList.remove('active');
        document.getElementById(`step-${fitmentGroupId}-${currentStep}`).classList.add('d-none');
        document.getElementById(`step-${fitmentGroupId}-${currentStep + 1}`).classList.remove('d-none');
        document.getElementById(`step-${fitmentGroupId}-${currentStep + 1}`).classList.add('active');

        currentStep++;
    }
    function submitSearch(fitmentGroupId) {
        console.log(filters);
        filters=[];
    }
    function prevStep(fitmentGroupId) {
        if (currentStep > 1) {
            document.getElementById(`stepper-item-${fitmentGroupId}-${currentStep}`).classList.remove('active');
            // document.getElementById('size_stepper-item_'+(currentWidthStep)).classList.remove('completed');
            document.getElementById(`stepper-item-${fitmentGroupId}-${currentStep-1}`).classList.add('active');
            document.getElementById(`stepper-item-${fitmentGroupId}-${currentStep-1}`).classList.remove('completed');
            document.getElementById(`step-${fitmentGroupId}-${currentStep}`).classList.remove('active');
            document.getElementById(`step-${fitmentGroupId}-${currentStep}`).classList.add('d-none');
            document.getElementById(`step-${fitmentGroupId}-${currentStep-1}`).classList.remove('d-none');
            document.getElementById(`step-${fitmentGroupId}-${currentStep-1}`).classList.add('active');
            currentStep--;
        }
    }
    function renderFitmentModalContent(key) {
        const fitmentGroup=fitmentGroups[key];
        const container = document.getElementById('modal_content_'+fitmentGroup.id);
        steps=fitmentGroup.fitment_attributes.length+1;
        if (!container || !fitmentGroup.fitment_attributes || fitmentGroup.fitment_attributes.length === 0) return;
        const wrapper = document.createElement('div');
        wrapper.className = 'col-12';
        wrapper.id = 'modal_content_'+fitmentGroup.id;

        const stepperWrapper = document.createElement('div');
        stepperWrapper.className = 'stepper-wrapper';
        stepperWrapper.id = 'ProgressBar' + fitmentGroup.id;

        fitmentGroup.fitment_attributes.forEach((attribute, index) => {
            const stepItem = document.createElement('div');
            stepItem.className = 'stepper-item';
            if (index === 0) stepItem.classList.add('completed', 'active');
            stepItem.id = `stepper-item-${fitmentGroup.id}-${index + 1}`;

            const nameDiv = document.createElement('div');
            nameDiv.className = 'step-name';
            nameDiv.textContent = attribute.name;

            const counterDiv = document.createElement('div');
            counterDiv.className = 'step-counter';
            counterDiv.textContent = index + 1;

            stepItem.appendChild(nameDiv);
            stepItem.appendChild(counterDiv);
            stepperWrapper.appendChild(stepItem);
        });

        wrapper.appendChild(stepperWrapper);

        const stepContainer = document.createElement('div');
        stepContainer.className = 'step active size-container';
        stepContainer.id = `step-${fitmentGroup.id}-1`;

        const firstAttribute = fitmentGroup.fitment_attributes[currentStep-1];
        if (firstAttribute.icon) {
            stepContainer.innerHTML += firstAttribute.icon;
        }

        firstAttribute.options.forEach((option, index) => {
            const optionDiv = document.createElement('div');
            optionDiv.className = 'rounded-3 border-grey-blue m-1';
            optionDiv.setAttribute('onclick',     `addFilter(${key}, ${option.id}, ${option.attribute_id}, '${option.value}')`);

            if (option.icon) {
                optionDiv.innerHTML += option.icon;
            }

            const textNode = document.createTextNode(' ' + option.value);
            optionDiv.appendChild(textNode);

            stepContainer.appendChild(optionDiv);
            // ایجاد label و input به صورت داینامیک
            const label = document.createElement('label');
            label.textContent = option.value;

            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.className = 'form-check-input';
            checkbox.name = `fitment_attributes[${option.attribute_id}][value][]`;
            checkbox.value = option.id;
            console.log('##############',fitmentGroup);

            const isChecked = fitmentGroup.fitmentDetails.some(detail => detail.option_id === option.id);
            checkbox.checked = isChecked;
            // checkbox.hidden = true;

            // اضافه کردن label و input به stepContainer
            // optionDiv.appendChild(label);
            optionDiv.appendChild(checkbox);
        });

        wrapper.appendChild(stepContainer);

        container.innerHTML = ''; // Clear existing content
        container.appendChild(wrapper);
    }


</script>
