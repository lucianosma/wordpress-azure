<header class="fixed-nl relative z-3 w-p-100 bg-grey">
  <div class="flex justify-between items-center mxw-1512 mh-auto ph-m">
    <div class="relative mnw-p-80-nl flex items-center pr-xl-l bg-yellow logo-section">
      <a class="mr-s-nl mr-xl-l mr-xxl-xl" href="{{ home_url('/') }}"><img class="js-logo h-38-nl" src="@asset('images/logo.svg')" alt=""></a>
      <div class="js-geo-info mnw-p-70-nl flex-nl flex-row-reverse-nl justify-around tc dn">
        <div class="mr-s-nl">
          <p class="f8"><span class="js-country fw-800"></span> | <span class="js-city fw-200"></span></p>
          <p class="mb-s f8 fw-200">@php pll_e( "Today's wind direction" ) @endphp</p>
        </div>
        <div class="js-wind-info flex items-center justify-center mr-s-nl dn">
          <img class="js-wind-direction-icon mr-s logo-section__wind-icon" src="" alt="">
          <p class="js-wind-direction f8-nl capitalize"></p>
        </div>
      </div>
    </div>
    <button class="js-toggle-menu relative dn-l ml-m menu-icon"></button>
    <div class="js-nav-container absolute-nl left-0-nl vw-100-nl vh-100-nl bg-grey-nl td-40 nav-container">
      <nav class="flex justify-center flex-column-nl items-center-nl ph-100-nl">
        @if (has_nav_menu('top_menu'))
          {!! 
            wp_nav_menu( 
              array( 
                'theme_location' => 'top_menu', 
                'container' => false, 
                'sort_column' => 'menu_order', 
                'menu_class' => 'flex flex-column-nl items-center-nl mb-l-nl f6 f5-xl fw-300 tc-blue nav-menu', 
                'walker' => new My_Walker()
              ) 
            ); 
          !!}
        @endif
        <div>
          <button class="js-lang-menu mb-s va-middle"><img src="@asset('images/lang-blue.svg')" alt="Multi language menu"></button>
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
      </nav>
    </div>
  </div>
  <div id="cookies" class="js-cookies absolute top-0 left-0 z-3 w-p-100 pa-m tc-blue bg-yellow cookies-warning">
    <script>
      if (document.cookie.indexOf("owvisited") >= 0) {
        document.getElementById('cookies').style.display = 'none';
      }
    </script>
    <div class="relative z-2 mxw-1212 mh-auto ph-m flex-l justify-between items-center">
      <div class="mb-m-nl pr-xl-l f7 fw2 text-field">@php the_field('cookies_text', 'options'); @endphp</div>
      <a href="#" class="js-cookies-btn dib ph-l pv-m f8 uppercase tc-yellow bg-blue h-scale td-40 btn">@php pll_e( 'Accept' ) @endphp</a>
    </div>
  </div>
</header>
