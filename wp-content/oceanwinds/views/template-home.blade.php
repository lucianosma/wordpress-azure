{{--
  Template Name: Home Template
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.content-page')

    <section class="relative bg-cover bg-center video-section" style="background-image: url('{!! the_field('video_cover') !!}')">
      <div class="absolute bottom-0 w-p-100 flex items-end items-center-nl flex-column-reverse-nl video-section__copy">
        <div class="w-p-100 w-p-50-l pv-xl ph-m bg-yellow">
          <p class="mxw-520-l f4 f3-ns f2-xl fw-800 tc-blue">@php the_field('video_text') @endphp</p>
        </div>
        <button class="js-open-modal ph-l pv-m f8 f6-xl uppercase tc-yellow bg-blue btn video-section__btn" data-video="{!! the_field('video_id') !!}">@php pll_e( 'Play video' ) @endphp</button>
      </div>
      <div class="absolute center-elem-v dn-nl tc-blue video-section__social">
        @if (have_rows('social', 'options'))
          <ul class="">
            @while (have_rows('social', 'options')) @php the_row() @endphp
              <li class="mb-l">
                <a href="{!! the_sub_field('link', 'options') !!}" target="blank" class="icon-{!! the_sub_field('network_type', 'options'); !!} f5"></a>
              </li>
            @endwhile
          </ul>
          <p class="mt-l f6 f5-xl">@php pll_e( 'Follow us' ) @endphp</p>
        @endif
      </div>
    </section>

    <section class="relative z-1 pv-xl bg-grey page-section page-section--company">
      <div class="flex flex-wrap flex-column-s mxw-1512 mh-auto ph-m">
        <div class="relative bg-cover bg-center page-section__image" style="background-image: url({{ the_field('company_image') }})">
          <a href="{{ the_field('company_link') }}" class="absolute bottom-0 db dn-nl ph-l pv-m f8 f6-xl uppercase tc-yellow bg-blue h-scale td-40 btn">@php pll_e( 'Learn more' ) @endphp</a>
        </div>
        <div class="pt-m pl-l-ns page-section__text-container">
          <h3 class="mb-m mb-l-l mb-xl-xl f7 f5-l uppercase">@php the_field('company_label') @endphp</h3>
          <h2 class="mb-m f3 f2-d f1-l fw-200">@php the_field('company_title') @endphp</h2>
          <div class="f6-d f5-l fw-300">@php the_field('company_text') @endphp</div>
          <a href="{{ the_field('company_link') }}" class="dn-l dib mt-l ph-l pv-m f8 f6-xl uppercase tc-yellow bg-blue btn">@php pll_e( 'Learn more' ) @endphp</a>
        </div>
      </div>
    </section>

    <section class="relative map-section">
      <div id="map" class="map-section__map"></div>

      @if (have_rows('addresses'))
        <ul class="js-map-addresses h-0 of-hidden">
          @while (have_rows('addresses')) @php the_row() @endphp
            <li data-address="{!! the_sub_field('address') !!}" data-email="{!! the_sub_field('email') !!}" data-phone="{!! the_sub_field('phone_number') !!}"></li>
          @endwhile
        </ul>
      @endif

      <div class="js-map-box absolute-l bottom-0 right-0 flex-nl flex-column items-center pt-l pt-xl-l pr-xxl-l tc-blue bg-yellow map">
        <div class="mxw-340-l mb-m ml-s pl-m">
          <p class="js-map-city mb-m f3 f2-l f1-xl fw-200"></p>
          <p class="js-map-street f6 f5-l f4-xl fw-200"></p>
          <p class="js-map-country f6 f5-l f4-xl fw-200"></p>
          <a class="js-map-phone f6 f5-l f4-xl fw-800" href=""></a>
        </div>
        <a href="" class="js-map-email dib ph-l pv-m f8 f6-xl uppercase tc-yellow bg-blue btn">@php pll_e( 'Mail us' ) @endphp</a>
      </div>
    </section>

    <section class="pv-xl bg-grey-light news-section">
      <div class="mxw-1512 mh-auto ph-m tc-blue">
        @php
          $loop = new WP_Query(array(
            'post_type' => 'post',
            'posts_per_page' => 3
          ));
        @endphp

        @if ( $loop->have_posts() ) 
          <h2 class="mb-xl f4 uppercase tc">@php pll_e( 'Latest news' ) @endphp</h2>
          <ul class="flex justify-between justify-center-s flex-wrap">
            @while ($loop->have_posts()) @php $loop->the_post() @endphp
              <li class="w-p-100 w-p-30-ns mxw-480 mb-l-s pb-m bg-white h-scale td-40 news-section__tile">
                <a href="{{ get_permalink() }}">
                  <div class="mb-l bg-cover bg-center news-section__cover" style="background-image: url({{ get_the_post_thumbnail_url() }})"></div>
                  <div class="ph-s">
                    <h2 class="mb-m f7-m fw-800"><span class="text-highlight">{!! get_the_title() !!}</span></h2>
                    <div class="mb-l f6 f7-m">
                      @php the_excerpt(false) @endphp
                    </div>
                    @php $cats = get_the_category() @endphp
                    @if (count($cats) > 0)
                      <div class="flex">
                        @php foreach ($cats as $cat) : @endphp
                          <p class="mr-m f8 f7-ns">@php echo $cat->name @endphp</p>
                        @php endforeach; @endphp
                      </div>
                    @endif
                    <p class="f8 f7-ns">@php the_date() @endphp</p>
                  </div>
                </a>
              </li>
            @endwhile
            @php wp_reset_query() @endphp
          </ul>
          <div class="tc">
            <a href="{{ the_field('news_page_link') }}" class="dib ph-l pv-m f6-xl uppercase tc-yellow bg-blue h-scale td-40 btn news-section__btn">@php pll_e( 'See more' ) @endphp</a>
          </div>
        @endif
      </div>
    </section>


    <section class="relative z-1 pv-xl bg-grey page-section page-section--careers">
      <div class="flex flex-wrap flex-column-s mxw-1512 mh-auto ph-m">
        <div class="relative bg-cover bg-center page-section__image" style="background-image: url({{ the_field('careers_image') }})">
          <a href="{{ the_field('careers_link') }}" class="absolute bottom-0 db dn-nl ph-l pv-m f8 f6-xl uppercase tc-yellow bg-blue h-scale td-40 btn">@php pll_e( 'Careers' ) @endphp</a>
        </div>
        <div class="pt-m pl-l-ns page-section__text-container">
          <h3 class="mb-m mb-l-l mb-xl-xl f7 f5-l uppercase">@php the_field('careers_label') @endphp</h3>
          <h2 class="mb-m f3 f2-d f1-l fw-200">@php the_field('careers_title') @endphp</h2>
          <div class="f6-d f5-l fw-300">@php the_field('careers_text') @endphp</div>
          <a href="{{ the_field('careers_link') }}" class="dn-l dib mt-l ph-l pv-m f8 f6-xl uppercase tc-yellow bg-blue btn">@php pll_e( 'Careers' ) @endphp</a>
        </div>
      </div>
    </section>
    
    <div class="js-modal fixed top-0 left-0 z-3 w-p-100 flex justify-center items-center of-hidden td-60 modal">
      <button class="js-close-modal absolute modal__close close-icon"></button>
      <div class="relative modal__container">
        <div class="js-modal-content absolute top-0 left-0 w-p-100 h-p-100 modal__content">
        </div>
      </div>
    </div>

    @endwhile

  @endsection
