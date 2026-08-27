<p class="text-secondary mb-0 p-3">
{{--    @dd($getTableUrl)--}}
    {{ trans('plugins/ecommerce::product-fitment.product.fitment_table.description') }}
</p>

<div class="fitment-table"></div>

<script>
    $(() => {
        $(document)
            .on('change', '#fitment_table_id', function(e) {
                const $this = $(this);
                const $form = $this.closest('form');
                const $table = $this.val();

                if ($table) {
                    $.ajax({
                        url: '{{ $getTableUrl }}',
                        data: {
                            table: $table,
                            @if($model)
                            product: '{{ $model->getKey() }}',
                            @endif
                        },
                        success: function(response) {
                            if (response.data) {
                                $form.find('.fitment-table').html(response.data);
                                // console.log(response.data);
                                $('.product-fitment-table p').hide();

                                $form.find('.fitment-table table tbody').sortable({
                                    update: function(event, ui) {
                                        $(this).find('tr').each(function(index) {
                                            $(this).find('input[name$="[order]"]').val(index);
                                        });
                                    },
                                });
                            }
                        },
                    });
                } else {
                    $form.find('.fitment-table').html('');
                    $('.product-fitment-table p').show();
                }
            });

        $('#fitment_table_id').trigger('change');
    });
</script>
