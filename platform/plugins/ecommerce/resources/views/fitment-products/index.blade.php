@extends(BaseHelper::getAdminMasterLayoutTemplate())


@section('content')
    <div class="card">

        <div class="card-header">
            {{$product->name}}

        </div>
{{--        <div class="card-body">--}}
{{--            {{!! $product->description !!}}--}}
{{--        </div>--}}
    </div>
    <x-core::table class="table table-bordered table-striped align-middle text-center">
        <x-core::table.header>
            <x-core::table.header.cell style="width: 20%;">
                {{ trans('plugins/ecommerce::product-fitment.product.fitment_table.group') }}
            </x-core::table.header.cell>
            <x-core::table.header.cell style="width: 20%;">
                {{ trans('plugins/ecommerce::product-fitment.product.fitment_table.attribute') }}
            </x-core::table.header.cell>
            <x-core::table.header.cell style="width: 20%;">
                {{ trans('plugins/ecommerce::product-fitment.product.fitment_table.options') }}
            </x-core::table.header.cell>
        </x-core::table.header>

        <x-core::table.body>
            @foreach($fitmentGroups as $group)
                @php
                    $firstAttributeWithoutChildShown = false;
                    $rowspanCount = $group->fitmentAttributes->count(); // یا فقط شمارش attributeهای بدون child اگه بخوای دقیق‌تر باشی
                @endphp
                <x-core::table.body.row>
                    <x-core::table.body.cell colspan="3" class="text-start">
                        @php
                            $shownParents = [];
                        @endphp

                        @foreach($group->fitmentAttributes as $attribute)
                            @foreach($attribute->fitmentProducts as $fitment)
                                @php
                                    $option = $fitment->option;
                                    $parent = $option->parent;
                                    $parentName = $parent->name ?? null;
                                @endphp

                                @if(
                                    $fitment->product->id == $product->id &&
                                    $option->children->isEmpty() &&
                                    $parentName &&
                                    !in_array($parentName, $shownParents)
                                )
                                    @php
                                        $shownParents[] = $parentName;
                                    @endphp

                                    <span class="btn btn-primary btn-sm px-2 py-1 small d-inline-flex align-items-center gap-1" onclick="openDetailsModal('{{ $fitment->product->id }}','{{ $fitment->attribute->id }}','{{ $option->option_parent_id }}')">
                {{ $parentName }}
            </span>
                                @endif
                            @endforeach
                        @endforeach


                    </x-core::table.body.cell>
                </x-core::table.body.row>
                @foreach($group->fitmentAttributes as $index => $attribute)
                    <x-core::table.body.row>
                        <x-core::table.body.cell style="width: 20%;">
                            {{ $group->name }}
                        </x-core::table.body.cell>

                        <x-core::table.body.cell style="width: 20%;">
                            {{ $attribute->name }}
                        </x-core::table.body.cell>

                        <x-core::table.body.cell style="width: 20%;">
                            <div class="d-flex align-items-center">
                                <select id="attribute_{{ $attribute->id }}"
                                        class="form-control me-2 parent-select group-{{ $group->id }}"
                                        data-parent-id="{{ $attribute->id }}"
                                        @if($attribute->child)
                                        data-child-id="{{ $attribute->child->id }}"
                                    @endif
                                >
                                    <option value="" selected>-- انتخاب کنید --</option>
                                    @if(is_null($attribute->parent))

                                    @foreach($attribute->options as $option)
                                        <option value="{{ $option->id }}">{{ $option->value }}</option>
                                    @endforeach
                                    @endif
                                </select>

                                @if(is_null($attribute->child))
                                    <x-core::button
                                        type="button"
                                        :icon-only="true"
                                        icon="ti ti-plus"
                                        onclick="addOption('{{ $group->id }}')"
                                    />
                                @endif
                            </div>
                        </x-core::table.body.cell>
                    </x-core::table.body.row>
                @endforeach
            @endforeach

        </x-core::table.body>
    </x-core::table>
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">جزئیات آیتم‌ها</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                </div>
                <div class="modal-body" id="modalOptionList">
                    <!-- لیست گزینه‌ها اینجا قرار می‌گیرد -->
                </div>

            </div>
        </div>
    </div>

@endsection


<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.parent-select').forEach(select => {
            select.addEventListener('change', function () {
                const parentId = this.dataset.parentId;
                const childId = this.dataset.childId;

                if (childId) {
                    getChild(parentId, childId, this.value);
                }
            });
        });
    });

    function getChild(parentId, childId, parent_option_id) {
        // console.log(parentId, childId, parent_option_id);

        axios.get("{{ route('ecommerce.fitment-attributes.option.children') }}", {
            params: {
                id: parent_option_id
            }
        })
            .then(response => {
                console.log(response);

                // ساختن گزینه‌ها
                let html = '<option value="">-- انتخاب کنید --</option>';
                if (response.data.data[0]) {
                    var ids = [];
                    response.data.data.forEach(item => {
                        ids.push(item.id);
                    });
                    console.log('$$$$$$$$$@@@@@@@@@@@@@@@@',ids);
                    if (response.data.data[0].attribute.children.length === 0) {
                        html += `<option value="${ids}"> انتخاب همه </option>`;
                    }
                }

                response.data.data.forEach(item => {
                    console.log('#', item);
                    html += `<option value="${item.id}">${item.value}</option>`;
                });

                // پیدا کردن dropdown فرزند
                const childSelect = document.getElementById('attribute_' + childId);
                if (childSelect) {
                    childSelect.innerHTML = html;
                } else {
                    console.warn('Child select not found:', 'attribute_' + childId);
                }
            })
            .catch(error => {
                console.error(error.response?.data ?? error);
                alert(error.response?.data?.message || 'خطا در دریافت اطلاعات');
            });
    }

    function addOption(group_id) {
        const formData = [];

        document.querySelectorAll('.group-' + group_id).forEach(select => {
            if (select.value) {
                let optionValues = select.value;

                // اگر مقدار به صورت string بوده و با "," جدا شده
                if (typeof optionValues === 'string' && optionValues.includes(',')) {
                    optionValues = optionValues.split(',');
                }

                if (Array.isArray(optionValues)) {
                    optionValues.forEach(id => {
                        formData.push({
                            'attribute_id': select.dataset.parentId,
                            'product_id': {{$product->id}},
                            'option_id': id
                        });
                    });
                } else {
                    formData.push({
                        'attribute_id': select.dataset.parentId,
                        'product_id': {{$product->id}},
                        'option_id': optionValues
                    });
                }
            }
        });

        console.log(formData);

        axios.post("{{ route('ecommerce.fitment-products.option.add') }}", formData)
            .then(response => {
                window.location.reload();
            })
            .catch(error => {
                console.error(error.response?.data ?? error);
                alert(error.response?.data?.message || 'خطا در دریافت اطلاعات');
            });
    }
    function removeOption(product_id, attribute_id, option_id) {
        axios.delete("{{ route('ecommerce.fitment-products.option.remove') }}", {
            params: {
                product_id: product_id,
                attribute_id:attribute_id,
                option_id:option_id,
            }
        })
            .then(response => {
                console.log(response);
                window.location.reload();
            })
            .catch(error => {
                console.error(error.response?.data ?? error);
                alert(error.response?.data?.message || 'خطا در دریافت اطلاعات');
            });
    }
    function openDetailsModal(product_id, attribute_id, parent_id) {
        axios.get("{{ route('ecommerce.fitment-products.option.details') }}", {
            params: {
                product_id: product_id,
                attribute_id: attribute_id
            }
        })
            .then(response => {
                const container = document.getElementById('modalOptionList');
                container.innerHTML = ''; // پاک کردن قبلی

                const items = response.data.data.filter(item =>
                    item.option.children.length === 0 &&
                    item.option.option_parent_id == parent_id
                );

                if (items.length === 0) {
                    container.innerHTML = '<p class="text-muted">موردی یافت نشد.</p>';
                } else {
                    items.forEach(item => {
                        const row = document.createElement('div');
                        row.className = 'd-flex justify-content-between align-items-center border-bottom py-1';

                        const name = document.createElement('span');
                        name.textContent = item.option.name;

                        const deleteBtn = document.createElement('button');
                        deleteBtn.className = 'btn btn-sm btn-danger d-inline-flex align-items-center justify-content-center rounded-pill px-2 py-1';
                        deleteBtn.innerHTML = '<i class="fa fa-trash text-white"></i>';
                        deleteBtn.title = 'حذف';
                        deleteBtn.style.minWidth = '32px';
                        deleteBtn.style.minHeight = '32px';
                        deleteBtn.onclick = () => {
                            removeOption(item.product_id, item.attribute_id, item.option_id);
                            row.remove();
                        };


                        row.appendChild(name);
                        row.appendChild(deleteBtn);
                        container.appendChild(row);
                    });
                }

                const modal = new bootstrap.Modal(document.getElementById('detailsModal'));
                modal.show();
            })
            .catch(error => {
                console.error(error.response?.data ?? error);
                alert(error.response?.data?.message || 'خطا در دریافت اطلاعات');
            });
    }
</script>



