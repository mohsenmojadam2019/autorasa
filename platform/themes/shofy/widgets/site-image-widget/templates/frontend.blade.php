@if ($config['image'])
    <div class="mb-3">
        <div class="tp-footer-payment text-center">
            <p>
                @if (($url = $config['url']) && $url !== '#')
                    <a href="{{ $url }}" target="_blank">
                        {{ RvMedia::image($config['image'], 'footer image') }}
                    </a>
                @else
                    {{ RvMedia::image($config['image'], 'footer image') }}
                @endif
            </p>
        </div>
    </div>
@endif
