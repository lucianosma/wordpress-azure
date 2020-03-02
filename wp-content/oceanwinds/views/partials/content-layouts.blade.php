@if( have_rows('page_sections') )
  @while(have_rows('page_sections')) @php the_row() @endphp
      
    @if( get_row_layout() === 'postal_section' )
      @include('partials.postal')
    @endif

    @if( get_row_layout() === 'text_column' )
      @include('partials.text-column')
    @endif

    @endwhile
@endif
