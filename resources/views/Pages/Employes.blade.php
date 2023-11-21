@extends('Layouts.Base')
@section('title')
    : Daftar Pegawai
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> List Pegawai </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">pegawai</li>
        </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-row justify-content-between mb-2">
                <div class="row">
                    <h4 class="card-title">Data Pegawai</h4>
                    <p class="card-description"> Perhatian, harap berhati-hati dalam merubah ataupun menambahkan data baru ke sistem.
                    </p>
                </div>
                <span>
                    <button type="button" disabled onclick="addButton(event)" class="btn btn-primary rounded btn-edit" data-type="0">Tambah Data <i class="fa-regular fa-plus ms-2"></i></button>
                </span>
            </div>
            <div id="skeleton">
                @include('Components.TableSkelton')
            </div>
            <table class="table pb-4" id="data-table" style="display: none">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Profile</th>
                  <th>Detail</th>
                  <th>DIbuat</th>
                  <th style="width: 15%">Opsi</th>
                </tr>
              </thead>
              <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($list['data'] as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td class="">
                            <span style="width: 50px; font-size: 16px; font-weight: 600" class="text-uppercase m-0"><b class="text-capitalize">{{ $item['sex'] === 'pria' ? 'Tn.' : 'Ny.' }}</b> {{ $item['name'] }} / {{ $item['rfid'] }}</span>
                            <p class="font-weight-light m-0 mt-2" style="width: 50px;">NIRP: {{ $item['nirp'] }}</p>
                            <p class="font-weight-light m-0" style="width: 50px; margin-top: -4px !important;">NIK: {{ $item['nik'] }}</p>
                        </td>
                        <td class="">
                            <p class="font-weight-light m-0" style="font-size: 16px; font-weight: 600">{{ $item['position'] }}</p>
                            <p class="font-weight-light m-0">{{ $item['satker'] }}</p>
                        </td>
                        <td>
                            <span>{{ $item['created_at']->format('j M Y') }}</span>
                        </td>
                        <td>
                            <div style="width: 15%" class="d-flex flex-row">
                                <button 
                                    type="button" 
                                    data-id="{{ $item['id'] }}" 
                                    data-rfid="{{ $item['rfid'] }}" 
                                    data-name="{{ $item['name'] }}" 
                                    data-nirp="{{ $item['nirp'] }}" 
                                    data-nik="{{ $item['nik'] }}" 
                                    data-sex="{{ $item['sex'] }}" 
                                    data-position_id="{{ $item['position_id'] }}" 
                                    data-satker_id="{{ $item['satker_id'] }}"
                                    disabled 
                                    class="btn btn-sm btn-primary me-2 edit-data">Edit</button>
                                <button type="button" data-id="{{ $item['id'] }}" disabled class="btn btn-sm btn-danger delete-data">Hapus</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
    </div>
@endsection
@section('modal-body')
    <div class="p-4">
        <input type="hidden" id="idData">
        <div class="row">
            <div class="form-group col-lg">
                <label for="" class="text-label">RFID Kode</label>
                <input type="number" id="rfid" class="form-control" placeholder="-- input disini --">
            </div>
            <div class="form-group col-lg">
                <label for="" class="text-label">Nama</label>
                <input type="text" id="name" class="form-control" placeholder="-- input disini --">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg">
                <label for="" class="text-label">Nomor NIRP</label>
                <input type="number" id="nirp" class="form-control" placeholder="-- input disini --">
            </div>
            <div class="form-group col-lg">
                <label for="" class="text-label">NIK</label>
                <input type="number" id="nik" class="form-control" placeholder="-- input disini --">
            </div>
            <div class="form-group col-lg">
                <label for="" class="text-label">Jenis Kelamin</label>
                <select id="sex" class="form-control form-control-sm">
                    <option value="pria">Pria</option>
                    <option value="wanita">Wanita</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg">
                <label for="" class="text-label">Jabatan</label>
                <select id="position_id" class="form-control form-control-sm">
                    <option value="" selected disabled>--pilih disini--</option>
                    @foreach ($list['position'] as $item)
                        <option class="text-capitalize
                        " value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-lg">
                <label for="" class="text-label">Satuan Kerja</label>
                <select id="satker_id" class="form-control form-control-sm">
                    <option value="" selected disabled>--pilih disini--</option>
                    @foreach ($list['satker'] as $item)
                        <option class="text-capitalize
                        " value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
@endsection
@section('modal-footer')
    <div class="d-flex flex-row justify-content-end">
        <button onclick="sendData()" disabled type="button" class="btn btn-primary me-2">Proses</button>
        <button type="button" disabled class="btn btn-danger btn-close-modal">Batal</button>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#modalOption').addClass('modal-lg')
            $('#modalTitle').html('Formulir Data')
            setTimeout(() => {
                setLoading(false)
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const url = `{{ config('app.url') }}/api/v1/employe/`

        const setLoading = (value) => {
            $('.btn').prop('disabled', value)
        }

        const addButton = (event) => {
            clearData()
            $('#formModal').modal('show')
        }

        const clearData = () => {
            $('#idData').val('');
            $('#rfid').val('');
            $('#nik').val('');
            $('#name').val('');
            $('#nirp').val('');
            $('#sex').val('');
            $('#position_id').val('');
            $('#satker_id').val('');

        }

        const sendData = async () => {
            setLoading(true)
            const formData = {
                id          : $('#idData' ).val() || null,
                name        : $('#name' ).val(),
                description : $('#description').val(),
                rfid        : $('#rfid' ).val(),
                nirp        : $('#nirp' ).val(),
                nik         : $('#nik' ).val(),
                sex         : $('#sex' ).val(),
                position_id : $('#position_id').val(),
                satker_id   : $('#satker_id' ).val()
            }

            await $.ajax({
                type       : 'POST',
                url        : url,
                contentType: 'application/json; charset=utf-8',
                data       : JSON.stringify(formData),
                dataType   : 'json',
                success    : function (response) {
                    // Handle response dari server
                    Swal.fire({
                        title: "Berhasil",
                        text: "Data berhasil diproses",
                        icon: "success"
                    }).then((res) => {
                        if (res.isConfirmed) {
                            location.reload()
                        }
                    });
                    setLoading(false)
                },
                error      : function (error) {
                    if (error.status === 422) {
                        const errContent = error.responseJSON

                        Swal.fire({
                            title: errContent.response.title,
                            text : errContent.response.message,
                            icon : errContent.response.icon
                        });
                    } else {
                        Swal.fire({
                            title: "Gagal",
                            text: "Periksa koneksi anda dan coba lagi",
                            icon: "error"
                        });
                    }
                    setLoading(false)
                }
            });
            clearData()
        }

        $(document).on('click', '.edit-data', function() {
            const dataId         = $(this).data('id'          );
            const dataRfid       = $(this).data('rfid'        );
            const dataName       = $(this).data('name'        );
            const dataNirp       = $(this).data('nirp'        );
            const dataNik        = $(this).data('nik'        );
            const dataSex        = $(this).data('sex'         );
            const dataPositionId = $(this).data('position_id' );
            const dataSatkerId   = $(this).data('satker_id'   );

            $('#idData' ).val(dataId );
            $('#rfid' ).val(dataRfid );
            $('#name' ).val(dataName );
            $('#nirp' ).val(dataNirp );
            $('#nik' ).val(dataNik );
            $('#sex' ).val(dataSex );
            $('#position_id').val(dataPositionId);
            $('#satker_id' ).val(dataSatkerId );

            $('#formModal').modal('show')
        })

        $(document).on('click', '.delete-data', function() {
            const dataId = $(this).data('id')
            const delurl = `${url}${dataId}`

            Swal.fire({
                title             : "Apa Kamu Yakin?",
                text              : "Data yang dihapus tidak dapat dikembalikan lagi!",
                icon              : "warning",
                showCancelButton  : true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor : "#d33",
                confirmButtonText : "Ya, Hapus!"
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type       : 'DELETE',
                    url        : delurl,
                    success    : (res) => {
                        Swal.fire({
                            title: "Terhapus!",
                            text : "Data berhasil dihapus.",
                            icon : "success"
                        }).then((res) => {
                            if (res.isConfirmed) {
                                location.reload()
                            }
                        });
                    },
                    error        : (err) => {
                        if (error.status === 404) {
                            const errContent = error.responseJSON

                            Swal.fire({
                                title: 'Not Found',
                                text : 'Data tidak ditemukan',
                                icon : 'warning'
                            });
                        } else {
                            Swal.fire({
                                title: "Gagal",
                                text: "Periksa koneksi anda dan coba lagi",
                                icon: "error"
                            });
                        }
                    }
                })
            }
            });
        })
    </script>
@endsection