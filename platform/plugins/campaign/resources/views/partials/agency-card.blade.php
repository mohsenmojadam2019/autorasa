
<a class="card shadow-lg mb-3" style="border-radius: 15px !important;" href="{{ route('campaigns.agency', $data->id) }}">
    <div class="card-body" >
        <div class="row">
            <div class="col-12 col-md-3">
                {{ RvMedia::image($data->img  ?: $data->img , theme_option('site_title'), attributes: ['class' => 'img-fluid','style'=>'width: 95px !important; height: 95px !important; object-fit: contain;']) }}
            </div>
            <div class="col-12 col-md-9">
                <h5 class="card-title" style="color:#212121 !important;font-size:18px;font-weight: 700; line-height: 27px;">{{ $data->name }}</h5>
                <p class="card-text text-muted mb-1 text-gray-900-fg" style="color:#636363;font-size:14px;font-weight: 400; line-height: 21px;"><i class="fas fa-map-marker-alt"></i> {{ $data->address }}</p>
                <p class="card-text text-muted "><i style="font-size:12px;font-weight: 400;color:#212121 !important; line-height: 18px;background-color: #C9D9E0 !important; border-radius:16px;"> {{ $data->city }}</i></p>
            </div>
        </div>
    </div>
</a>
