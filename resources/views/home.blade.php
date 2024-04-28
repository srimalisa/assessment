@extends('layouts.skote.master-layouts')

@section('content')

<div class="page-section border-bottom-2 bg-white pt-4">
    <div class="container page__container">
        <div class="page-headline text-center">
            <h2>Why FlyHigh?</h2>
            <p class="lead measure-lead mx-auto text-70">What other students turned professionals have to say about us after learning with us and reaching their goals.</p>
        </div>

        <div class="container">
            <div class="row align-items-center">
                <div class="col-md mb-4 d-flex align-items-center border-bottom border-md-0 pb-16pt pb-md-0">
                    <div class="rounded-circle bg-dark d-inline-flex align-items-center justify-content-center p-3" style="width: 64px; height: 64px;">
                        <i class="fa fa-user fa-3x text-white" aria-hidden="true"></i>
                    </div>
                    <div class="ml-3">
                        <div class="card-title">Experienced Teachers</div>
                        <p class="card-subtitle text-70">Expert guidance from experienced teachers.</p>
                    </div>
                </div>
                
                <div class="col-md mb-4 d-flex align-items-center border-bottom border-md-0 pb-16pt pb-md-0">
                    <div class="rounded-circle bg-dark d-inline-flex align-items-center justify-content-center p-3" style="width: 64px; height: 64px;">
                        <i class="fa fa-shield-alt fa-3x text-white" aria-hidden="true"></i>
                    </div>
                    <div class="ml-3">
                        <div class="card-title">Proven Track Record</div>
                        <p class="card-subtitle text-70">Results speak for themselves.</p>
                    </div>
                </div>
    
                <div class="col-md mb-4 d-flex align-items-center border-bottom border-md-0 pb-16pt pb-md-0">
                    <div class="rounded-circle bg-dark d-inline-flex align-items-center justify-content-center p-3" style="width: 64px; height: 64px;">
                        <i class="fa fa-clock fa-3x text-white" aria-hidden="true"></i>
                    </div>
                    <div class="ml-3">
                        <div class="card-title">Quality Content</div>
                        <p class="card-subtitle text-70">Top-notch content guaranteed.</p>
                    </div>
                </div>
            </div>
    
            <div class="row align-items-center">
                <div class="col-md mb-4 d-flex align-items-center border-bottom border-md-0 pb-16pt pb-md-0">
                    <div class="rounded-circle bg-dark d-inline-flex align-items-center justify-content-center p-3" style="width: 64px; height: 64px;">
                        <i class="fa fa-money-bill fa-3x text-white" aria-hidden="true"></i>
                    </div>
                    <div class="ml-3">
                        <div class="card-title">Affordable Price</div>
                        <p class="card-subtitle text-70">Quality doesn't have to be expensive.</p>
                    </div>
                </div>
    
                <div class="col-md mb-4 d-flex align-items-center border-bottom border-md-0 pb-16pt pb-md-0">
                    <div class="rounded-circle bg-dark d-inline-flex align-items-center justify-content-center p-3" style="width: 64px; height: 64px;">
                        <i class="fa fa-laptop fa-3x text-white" aria-hidden="true"></i>
                    </div>
                    <div class="ml-3">
                        <div class="card-title">Online & Face-to-Face</div>
                        <p class="card-subtitle text-70">Flexibility for your convenience.</p>
                    </div>
                </div>
    
                <div class="col-md mb-4 d-flex align-items-center border-bottom border-md-0 pb-16pt pb-md-0">
                    <div class="rounded-circle bg-dark d-inline-flex align-items-center justify-content-center p-3" style="width: 64px; height: 64px;">
                        <i class="fa fa-male fa-3x text-white" aria-hidden="true"></i>
                    </div>
                    <div class="ml-3">
                        <div class="card-title">Active Support</div>
                        <p class="card-subtitle text-70">Always available to assist you.</p>
                    </div>
                </div>
            </div>
        </div>
        

    </div>
</div>

<div class="page-section border-bottom-2">
    <div class="container page__container pt-3 pb-2">
        <div class="page-headline text-center pt-3">
            <h2>Categories</h2>
        </div>
        <div class="row">
            {{-- @foreach($standard_cat as $standard_cats)
            <div class="col-md-4 col-sm-12 ">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ isset($standard_cats->first()->standardCategory->description) ? $standard_cats->first()->standardCategory->description : '' }}</h4>
                        <div class="button-items">
                            @foreach($standard_cats as $stan)
                                <a href="{{ url('/package') }}?standard={{ $stan->id }}" class="btn btn-outline-primary btn-lg btn-block btn-rounded waves-effect waves-light w-100">{{ $stan->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach --}}
        </div>
    </div>
</div>

    <div class="page-section bg-alt">
        <div class="container page__container">

            <div class="page-headline text-center">
                <h2 class="mb-4 mt-4">Feedback</h2>
            </div>

            <div class="row">
                
                
                
            </div>
        </div>
    </div>

@endsection
@section('script')
<script>

    $(document).ready(function() {
        $('.js-image').each(function() {
            var $img = $(this).find('img');
            var imgUrl = $img.data('img-url');
            $.get(imgUrl, function(data) {
                $img.attr('src', data.url);
            });
        });
        $('.js-image2').each(function() {
            var $img = $(this).find('img');
            var imgUrl = $img.data('img-url2');
            $.get(imgUrl, function(data) {
                $img.attr('src', data.url);
            });
        });
    });
</script>

@endsection