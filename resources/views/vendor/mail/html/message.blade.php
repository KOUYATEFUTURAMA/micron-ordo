@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('app.name') }}
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
@lang('Copyright © 2021 <a href="https://groupsmarty.com/" target="_blank" class="text-hover-primary">GroupSmarty</a>'). @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
