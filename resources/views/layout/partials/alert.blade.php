<style>
    .alertCon{
        margin:0 auto;
        with:50%;
    }
</style>

@if(session()->has('mesaj'))<!-- sessionda mesaj diye bir bilgi var ise yapacaklarını yazıyoruz-->
<div class="alertCon">
<div class="alert alert-{{session('mesaj_tur')}}">{{session('mesaj')}}</div>
</div>
@endif
