@extends('Layouts.Base')
@section('title')
    : Satuan Kerja
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> List Satuan Kerja </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">satker</li>
        </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-row justify-content-between mb-2">
                <div class="row">
                    <h4 class="card-title">Data Satuan Kerja</h4>
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
                  <th>Nama</th>
                  <th>DIbuat</th>
                  <th style="width: 15%">Opsi</th>
                </tr>
              </thead>
              <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($list as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td class="">
                            <span style="width: 50px">{{ $item['name'] }}</span>
                            <p class="mt-1 font-weight-light" style="width: 50px">{{ $item['description'] }}</p>
                        </td>
                        <td>
                            <span>{{ $item['created_at']->format('j M Y') }}</span>
                        </td>
                        <td>
                            <div style="width: 15%" class="d-flex flex-row">
                                <button type="button" data-id="{{ $item['id'] }}" data-name="{{ $item['name'] }}" data-desc="{{ $item['description'] }}" disabled class="btn btn-sm btn-primary me-2 edit-data">Edit</button>
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
        <div class="form-group">
            <label for="" class="text-label">Nama Satuan Kerja</label>
            <input type="text" id="name" class="form-control" placeholder="-- input disini --">
        </div>
        <div class="form-group">
            <label for="" class="text-label">Deskripsi</label>
            <textarea name="name" id="description" cols="30" class="form-control" rows="10" placeholder="-- input disini --"></textarea>
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

        const url = `{{ config('app.url') }}/api/v1/satker/`

        const setLoading = (value) => {
            $('.btn').prop('disabled', value)
        }

        const addButton = (event) => {
            clearData()
            $('#formModal').modal('show')
        }

        const clearData = () => {
            $('#idData').val('')
            $('#name').val(''),
            $('#description').val('')
        }

        const sendData = async () => {
            setLoading(true)
            const formData = {
                id         : $('#idData').val() || null,
                name       : $('#name').val(),
                description: $('#description').val()
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
            const dataId   = $(this).data('id'   )
            const dataName = $(this).data('name' )
            const dataDesc = $(this).data('desc' )
            $('#idData').val(dataId)
            $('#name').val(dataName)
            $('#description').val(dataDesc)

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