@extends('Layouts.Base')
@section('title')
    : Daftar Pegawai
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> List Daftar Hadir </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">daftar hadir</li>
        </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                <div class="row">
                    <h4 class="card-title">Daftar Hadir Pegawai</h4>
                    <p class="card-description">Data yang ditampilkan merupakan akumulatif absensi selama sebulan.</p>
                </div>
                <span class="row align-items-center">
                    <div class="form-group col">
                        <label for="">Mulai</label>
                        <input type="date" class="form-control form-control-sm" id="start_date">
                    </div>
                    <div class="form-group col">
                        <label for="">Akhir</label>
                        <input type="date" class="form-control form-control-sm" id="end_date">
                    </div>
                    <div class="col">
                        <button type="button" disabled class="btn btn-primary rounded btn-edit d-flex" data-type="0">Laporan <i class="fa-solid fa-download ms-2"></i></button>
                    </div>
                </span>
            </div>
            <div id="skeleton">
                @include('Components.TableSkelton')
            </div>
            <table class="table pb-4" id="data-table" style="display: none">
              <thead>
                <tr>
                  <th style="width: 4%">No</th>
                  <th>Profile</th>
                  <th>Detail</th>
                </tr>
              </thead>
              <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($list['data'] as $item)
                    <tr>
                        <td style="width: 4%">{{ $no++ }}</td>
                        <td class="">
                            <span style="width: 50px; font-size: 16px; font-weight: 500" class="text-uppercase m-0">{{ $item['employe_name'] }} / {{ $item['employe_rfid'] }}</span>
                        </td>
                        <td class="row">
                            <span style="font-size: 16px; font-weight: 500;">Kehadiran: <b class="text-success">{{ count($item['summary']['hadir']) }}</b></span>
                            <span style="font-size: 16px; font-weight: 500; margin-top:4px">Bolos: <b class="text-danger">{{ count($item['summary']['bolos']) }}</b></span>
                        </td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
    </div>
@endsection
@section('script')
    <script>
        const setLoading = (value) => {
            $('.btn').prop('disabled', value)
        }

        $(document).ready(function() {
            $('#modalOption').addClass('modal-lg')
            $('#modalTitle').html('Formulir Data')
            setTimeout(() => {
               
                $('#skeleton').attr('style', 'display:none')
                $('#data-table').attr('style', 'display:table')
                $('#data-table').DataTable({
                    "language": {
                        "sEmptyTable"    : "Tidak ada data yang tersedia di tabel",
                        "sInfo"          : "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                        "sInfoEmpty"     : "Menampilkan 0 sampai 0 dari 0 entri",
                        "sInfoFiltered"  : "(disaring dari _MAX_ total entri)",
                        "sInfoPostFix"   : "",
                        "sInfoThousands" : ".",
                        "sLengthMenu"    : "Tampilkan _MENU_ entri",
                        "sLoadingRecords": "Sedang memuat...",
                        "sProcessing"    : "Sedang memproses...",
                        "sSearch"        : "Cari:",
                        "sZeroRecords"   : "Tidak ditemukan data yang sesuai",
                        "oPaginate"      : {
                            "sFirst"   : "Pertama",
                            "sLast"    : "Terakhir",
                            "sNext"    : "Berikutnya",
                            "sPrevious": "Sebelumnya"
                        },
                        "oAria"          : {
                            "sSortAscending" : ": aktifkan untuk menyortir kolom secara ascending",
                            "sSortDescending": ": aktifkan untuk menyortir kolom secara descending"
                        }
                    }
                })
            }, 1000);
        })

        $(document).on('click', '.btn-edit', function() {
              // Mengambil nilai dari atribut href
            const startDate = $('#start_date').val()
            const endDate   = $('#end_date'  ).val()

            var urlTujuan = `{{ config('app.url') }}/api/v1/present/download?start_date=${startDate}&end_date=${endDate}`
                
            // Menavigasi ke URL yang telah diambil
            window.location.href = urlTujuan;
        })

        const input1 = document.getElementById('start_date');
        const input2 = document.getElementById('end_date');

        input1.addEventListener('input', checkInputs);
        input2.addEventListener('input', checkInputs);

        function checkInputs() {
        // Memeriksa apakah kedua input tidak null
            if (input1.value !== '' && input2.value !== '') {
                setLoading(false)
            } else {
                setLoading(true)
            }
        }
    </script>
@endsection