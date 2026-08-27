@if ($config['image'])
    <div class="col-xl-4 col-lg-3 col-md-4 col-sm-6 d-flex justify-content-center">
        <div class="tp-footer-payment text-center">
            <p>
                @if (($url = $config['url']) && $url !== '#')
                    <a href="{{ $url }}">
                        {{ RvMedia::image($config['image'], 'footer image') }}
                    </a>
                @else
                    {{ RvMedia::image($config['image'], 'footer image') }}
                @endif
            </p>
        </div>
    </div>
@endif
