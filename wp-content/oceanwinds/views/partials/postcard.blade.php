@php 
  $alignment = get_sub_field('postcard_alignment');
  $color = get_sub_field('postcard_background_color');
@endphp
<section class="relative z-1 pv-xl bg-grey postcard postcard--{!! $alignment !!} postcard--{!! $color !!}">
  <div class="flex-ns justify-center flex-wrap flex-column-s mxw-1512 mh-auto">
    <section class="flex justify-end items-center w-p-50-ns mb-l-s ph-m ph-l-l">
      <div class="relative bg-cover bg-center postcard__image" style="background-image: url({{ the_sub_field('postcard_image') }})"></div>
    </section>
    <section class="w-p-50-ns ph-m ph-l-l">
      @if(get_sub_field('postcard_title'))
        <h2 class="mb-m mb-l-l mb-xl-xl f4 f3-m f2-l f1-xl uppercase">@php the_sub_field('postcard_title') @endphp</h2>
      @endif
      @if(get_sub_field('postcard_highlight_text'))
        <div class="mb-m f6 f4-m f3-xl fw-600 postcard__text">@php the_sub_field('postcard_highlight_text') @endphp</div>
      @endif
      @if(get_sub_field('postcard_text'))
        <div class="f6-d f5-l fw-300 postcard__text">@php the_sub_field('postcard_text') @endphp</div>
      @endif
    </section>
  </div>
</section>