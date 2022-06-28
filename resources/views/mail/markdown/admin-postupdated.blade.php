@component('mail::message')
# Introduction

Ciao Admin, il post <strong>{{$slug}}</strong> è stato modificato.

@component('mail::button', ['url' => '$url'])
Review Post
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
