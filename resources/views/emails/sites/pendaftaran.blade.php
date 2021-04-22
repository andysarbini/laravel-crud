@component('mail::message')
# Pendaftaran siswa

Selamat anda telah terdaftar di SMA 59 Jakarta

@component('mail::button', ['url' => 'http://rolloic.com'])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
