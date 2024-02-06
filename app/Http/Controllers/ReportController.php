<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReportController extends Controller
{
    //function index receives query params from the URL

    public function index(Request $request)
    {
        if (!$request->query('tahun')) {
            $tahun = 2021;
        } else {
            $tahun = $request->query('tahun');
        }
        $menuItems = Http::get('http://tes-web.landa.id/intermediate/menu')->json();
        $transaction = Http::get('http://tes-web.landa.id/intermediate/transaksi?tahun=' . $tahun)->json();

        $total_penjualan_makanan_per_bulan = [];
        $total_penjualan_minuman_per_bulan = [];
        foreach ($transaction as $key => $value) {
            $tanggal = $value["tanggal"];
            $bulan = date("F", strtotime($tanggal));
            $menu = $value["menu"];
            $total = $value["total"];

            // Fetch the category of the current menu item
            $kategori = '';
            foreach ($menuItems as $menuItem) {
                if ($menuItem['menu'] == $menu) {
                    $kategori = $menuItem['kategori'];
                    break;
                }
            }

            // Check if the category is 'makanan' before adding the total
            if ($kategori == 'makanan') {
                if (!isset($total_penjualan_makanan_per_bulan[$menu])) {
                    $total_penjualan_makanan_per_bulan[$menu] = [];
                }
                if (!isset($total_penjualan_makanan_per_bulan[$menu][$bulan])) {
                    $total_penjualan_makanan_per_bulan[$menu][$bulan] = 0;
                }
                $total_penjualan_makanan_per_bulan[$menu][$bulan] += $total;
            } else if ($kategori == 'minuman') {
                if (!isset($total_penjualan_minuman_per_bulan[$menu])) {
                    $total_penjualan_minuman_per_bulan[$menu] = [];
                }
                if (!isset($total_penjualan_minuman_per_bulan[$menu][$bulan])) {
                    $total_penjualan_minuman_per_bulan[$menu][$bulan] = 0;
                }
                $total_penjualan_minuman_per_bulan[$menu][$bulan] += $total;
            }
        }

        return view('report.index', ['total_penjualan_makanan' => $total_penjualan_makanan_per_bulan, 'total_penjualan_minuman' => $total_penjualan_minuman_per_bulan]);
    }
}
