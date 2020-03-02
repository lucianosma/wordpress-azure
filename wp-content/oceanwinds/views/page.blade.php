@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.page-cover')
    @include('partials.content-layouts')
  @endwhile
@endsection
