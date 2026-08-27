<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
    <div class="tp-footer-widget footer-col-2">
        <h4 class="tp-footer-widget-title" style="color: #314088 !important;">{{ $config['name'] }}</h4>
        <div class="tp-footer-widget-content" >
            {!! Menu::generateMenu(['slug' => $config['menu_id'], 'view' => 'footer.menu']) !!}
        </div>
    </div>
</div>
