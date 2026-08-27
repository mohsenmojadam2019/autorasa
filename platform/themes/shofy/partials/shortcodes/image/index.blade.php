{{--<img src="{{$shortcode->src}}" alt="{{$shortcode->alt}}"  />--}}
{{ RvMedia::image($shortcode->image, 'banner', attributes: ['loading' => 'lazy', 'class' => 'img-fluid rounded', 'style' => 'object-fit: cover; max-height: 500px; width: 280px']) }}
