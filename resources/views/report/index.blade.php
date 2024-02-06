@extends('layouts.app')


@section('content')

<div class="container-fluid">
    <div class="card" style="margin: 2rem 0rem;">
        <div class="card-header">
            Venturo - Laporan Penjualan tahunan per menu
        </div>
        <div class="card-body">
            <form action="" method="get">
                <div class="row">
                    <div class="col-2">
                        <div class="form-group">
                            <select class="form-control" name="tahun" id="my-select" onchange="location = this.value;">
                                <option value="">Pilih Tahun</option>
                                <option value="?tahun=2021" {{ request()->get('tahun') == '2021' ? 'selected' : ''
                                    }}>2021</option>
                                <option value="?tahun=2022" {{ request()->get('tahun') == '2022' ? 'selected' : ''
                                    }}>2022</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-primary" type="submit">Tampilkan</button>
                    </div>
                </div>
            </form>
            <hr>
            {{--Table--}}
            <div class="table-responsive">
                <table class="table table-hover table-bordered" style="margin: 0;">
                    <thead>

                        <tr class="table-dark">
                            <th rowspan="2" style="text-align:center;vertical-align: middle;width: 250px;">Menu</th>
                            <th colspan="12" style="text-align: center;">Periode Pada {{$tahun}}
                            </th>
                            <th rowspan="2" style="text-align:center;vertical-align: middle;width:75px">Total</th>
                        </tr>
                        <tr class="table-dark">
                            <th style="text-align: center;width: 75px;">Jan</th>
                            <th style="text-align: center;width: 75px;">Feb</th>
                            <th style="text-align: center;width: 75px;">Mar</th>
                            <th style="text-align: center;width: 75px;">Apr</th>
                            <th style="text-align: center;width: 75px;">Mei</th>
                            <th style="text-align: center;width: 75px;">Jun</th>
                            <th style="text-align: center;width: 75px;">Jul</th>
                            <th style="text-align: center;width: 75px;">Ags</th>
                            <th style="text-align: center;width: 75px;">Sep</th>
                            <th style="text-align: center;width: 75px;">Okt</th>
                            <th style="text-align: center;width: 75px;">Nov</th>
                            <th style="text-align: center;width: 75px;">Des</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="table-secondary" colspan="14">
                                <b>Makanan</b>
                            </td>
                        </tr>
                        @foreach ($total_penjualan_makanan as $menu => $penjualan_makanan)
                        <tr>
                            <td>{{ $menu }}</td>
                            @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                            'September', 'October',
                            'November',
                            'December'] as $bulan)
                            <td style="text-align: right;">{{ $penjualan_makanan[$bulan] ?? "" ?
                                number_format(floatval($penjualan_makanan[$bulan] ?? 0)) : "" }}</td>
                            @endforeach
                            <td style="text-align: right;"><b>{{ number_format(floatval(array_sum($penjualan_makanan)))
                                    }}</b></td>
                        </tr>
                        @endforeach
                        <tr>
                            <td class="table-secondary" colspan="14">
                                <b>Minuman</b>
                            </td>
                        </tr>
                        @foreach ($total_penjualan_minuman as $menu => $penjualan_minuman)
                        <tr>
                            <td>{{ $menu }}</td>
                            @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                            'September', 'October', 'November', 'December'] as $bulan)
                            <td style="text-align: right;">{{ $penjualan_minuman[$bulan] ?? "" ?
                                number_format(floatval($penjualan_minuman[$bulan] ?? 0)) : "" }}</td>
                            @endforeach
                            <td style="text-align: right;"><b>{{ number_format(floatval(array_sum($penjualan_minuman)))
                                    }}</b></td>
                        </tr>
                        @endforeach
                        <tr class="table-dark">
                            <td><b>Total</b></td>
                            @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                            'September', 'October', 'November', 'December'] as $bulan)
                            <td><b>{{ array_sum(array_column($total_penjualan_makanan, $bulan)) +
                                    array_sum(array_column($total_penjualan_minuman, $bulan)) ?
                                    number_format(floatval(array_sum(array_column($total_penjualan_makanan, $bulan)) +
                                    array_sum(array_column($total_penjualan_minuman, $bulan)))) : "" }}</b></td>
                            @endforeach
                            <td><b>{{ number_format(floatval(array_sum(array_map('array_sum', $total_penjualan_makanan))
                                    + array_sum(array_map('array_sum', $total_penjualan_minuman)))) }}</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>