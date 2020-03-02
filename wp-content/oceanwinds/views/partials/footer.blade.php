<footer class="pv-xl bg-blue tc-grey-light">
  <div class="mxw-1512 mh-auto ph-m">
    <section class="flex justify-between justify-center-nl items-center flex-column-nl mb-xl mb-xxl-l">
      <img class="mb-l-nl h-38-nl" src="@asset('images/logo-bottom.svg')" alt="Ocean Winds">
      <div class="flex flex-column-nl">
        @if (has_nav_menu('bottom_menu'))
          {!! 
            wp_nav_menu( 
              array( 
                'theme_location' => 'bottom_menu', 
                'container' => false, 
                'sort_column' => 'menu_order', 
                'menu_class' => 'flex flex-column-nl items-center-nl mb-m-nl f6 f5-xl fw-300 footer-nav-menu'
              ) 
            ); 
          !!}
        @endif
        <div class="tc-nl">
          <button class="js-lang-menu mb-s va-middle"><img src="@asset('images/lang-grey.svg')" alt="Multi language menu"></button>
          @if (has_nav_menu('lang_menu'))
            {!! 
              wp_nav_menu(
                array(
                  'theme_location' => 'lang_menu',
                  'menu_class' => 'lang-menu f8 tc', 
                  'container' => false
                ) 
              );
            !!}
          @endif
        </div>
      </div>
    </section>
    <section class="flex justify-between items-center flex-column-nl tc-nl">
      <p class="mb-l-nl f8 tc-yellow uppercase">© <span class="js-year"></span> | @php pll_e( 'All rights reserved' ) @endphp</p>
      <div class="flex justify-between justify-center-nl flex-column-nl w-p-100-l mxw-675 mxw-610-d">
        <p class="mb-l-nl"><span class="db-nl mr-l-l mb-s-nl f6 f5-xl">@php pll_e( 'Call us' ) @endphp</span><a href="tel:{!! the_field('phone_number', 'options') !!}">{!! the_field('phone_number', 'options') !!}</a></p>
        <div class="flex-l">
          <p class="mr-l-l mb-s-nl f6 f5-xl">@php pll_e( 'Follow us' ) @endphp</p>
          @if (have_rows('social', 'options'))
            <ul class="flex items-center">
              @while (have_rows('social', 'options')) @php the_row() @endphp
                <li class="mh-s-nl ml-m-l pl-s-l">
                  <a href="{!! the_sub_field('link', 'options') !!}" target="blank" class="icon-{!! the_sub_field('network_type', 'options'); !!} f5"></a>
                </li>
              @endwhile
            </ul>
          @endif
        </div>
      </div>
    </section>
  </div>
</footer>
