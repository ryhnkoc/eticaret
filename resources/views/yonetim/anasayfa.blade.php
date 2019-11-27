@extends('yonetim.layouts.master')
@section('title','Anasayfa')
@section('content')
    <h1 class="page-header">Kontrol Paneli</h1>

    <section class="row text-center placeholders">
        <div class="col-6 col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Bekleyen Sipariş</div>
                <div class="panel-body">
                    <h4>{{$istatistikler['bekleyen_siparis']}}</h4>
                    <p>Sipariş</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Tamamlanan Sipariş</div>
                <div class="panel-body">
                    <h4>{{$istatistikler['tamamlanan_siparis']}}</h4>
                    <p>Sipariş</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Toplam Ürün</div>
                <div class="panel-body">
                    <h4>{{$istatistikler['toplam_urun']}}</h4>
                    <p>Ürün</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Kullanıcı Sayısı</div>
                <div class="panel-body">
                    <h4>{{$istatistikler['toplam_kullanici']}}</h4>
                    <p>Kullanıcı</p>
                </div>
            </div>
        </div>
    </section>
    <section class="row">
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Çok Satan Ürünler</div>
                <div class="panel-body">
                    <canvas id="chartCokSatan"></canvas>
                </div>
            </div>

        </div>
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Aylara Göre Satışlar</div>
                <div class="panel-body">
                    <canvas id="chartAylaraGoreSatislar"></canvas>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
    @php
        $keys="";
        $values="";
        foreach ($cok_satan_urunler as $rapor)
        {
        $keys.="\"$rapor->urun_adi\",";
        $values="$rapor->adet,";
        }
    @endphp

    <script>  var ctx = document.getElementById('chartCokSatan').getContext('2d');
        var chartCokSatan = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: [{!!$keys!!}],/*blade template engine html veya özel kayakterler yazdırcagımız zaman bu yapıyı kullanıyoruz*/
                datasets: [{
                    label: 'Çok Satan Ürünler',
                    data: [{!!$values!!}],

                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1
                        }
                    }]
                }
            }
        });

{{--        @php--}}
{{--            $keys="";--}}
{{--            $values="";--}}
{{--            foreach ($aylara_gore_satislar as $rapor)--}}
{{--            {--}}
{{--            $keys.="\"$rapor->ay\",";--}}
{{--            $values="$rapor->adet,";--}}
{{--            }--}}
{{--        @endphp--}}
{{--var ctx2 = document.getElementById('chartAylaraGoreSatislar\n').getContext('2d');--}}
{{--        var chartAylaraGoreSatislar= new Chart(ctx2, {--}}
{{--            type: 'line',--}}
{{--            data: {--}}
{{--                labels: [{!!$keys!!}],/*blade template engine html veya özel kayakterler yazdırcagımız zaman bu yapıyı kullanıyoruz*/--}}
{{--                datasets: [{--}}
{{--                    label: 'Çok Satan Ürünler',--}}
{{--                    data: [{!!$values!!}],--}}

{{--                    borderColor: '#f4645f',--}}
{{--                    borderWidth: 1--}}
{{--                }]--}}
{{--            },--}}
{{--            options: {--}}
{{--                legend:{position:'bottom'},--}}
{{--                scales: {--}}
{{--                    yAxes: [{--}}
{{--                        ticks: {--}}
{{--                            beginAtZero: true,--}}
{{--                            stepSize: 1--}}
{{--                        }--}}
{{--                    }]--}}
{{--                }--}}
{{--            }--}}
{{--        });--}}
    </script>
@endsection
