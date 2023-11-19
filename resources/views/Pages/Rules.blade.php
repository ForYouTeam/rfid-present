@extends('Layouts.Base')
@section('title')
    : Rules
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> List Pengaturan </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">pengaturan</li>
        </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-body">
          <div class="d-flex flex-row justify-content-between">
            <div class="row">
                <h4 class="card-title">Data Pengaturan Sistem</h4>
                <p class="card-description"> Perhatian, harap berhati-hati dalam merubah ataupun menambahkan peraturan baru ke sistem.
                </p>
            </div>
            <span>
                <button type="button" onclick="editButton(event)" class="btn btn-primary rounded btn-edit" data-type="0">Ubah Data <i class="fa-regular fa-pen-to-square ms-2"></i></button>
            </span>
          </div>
          <div id="skeleton">
            @include('Components.FormSkelton')
          </div>
          <div id="data-table" style="display: none" class="pt-4">
            <div class="row">
                @foreach ($list as $item)
                    <div class="form-group col-6">
                        <label class="text-uppercase" for="">{{ str_replace('_', ' ', $item['type']) }} - {{ str_replace('_', ' ', $item['tag']) }}</label>
                        <input type="time" id="input-{{ $item['tag'] }}" data-id="{{ $item['id'] }}" data-type="{{ $item['type'] }}" value="{{ $item['value'] }}" class="form-control input-form" placeholder="--Masukan Disini--" disabled>
                    </div>
                @endforeach
            </div>
          </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#modalTitle').html('Ubah Data Pengaturan')
            $('#modalOption').addClass('modal-lg')
            setTimeout(() => {
                $('#skeleton').attr('style', 'display:none')
                $('#data-table').attr('style', 'display:block')
            }, 1000);
        })

        const editButton = (event) => {
            const button = event.target
            const typeButton = button.getAttribute('data-type')

            if (typeButton == 0) {
                button.innerHTML = `Simpan <i class="fa-regular fa-floppy-disk ms-2"></i>`
                button.setAttribute('data-type', 1)
                $('.input-form').prop('disabled', false)
            } else {
                button.innerHTML = `Ubah Data <i class="fa-regular fa-pen-to-square ms-2"></i>`
                button.setAttribute('data-type', 0)
                $('.input-form').prop('disabled', true)

                sendData()
            }
        }

        const sendData = () => {
            const fieldData = ['s_time', 'e_time', 'ms', 'me']
            
            let formData = []
            fieldData.forEach(element => {
                formData.push({
                    id: $(`#input-${element}`).data('id') || null,
                    type: $(`#input-${element}`).data('type'),
                    tag: element,
                    value: $(`#input-${element}`).val()
                })
            });

            $.ajax({
            type: 'POST',
            url: `{{ config('app.url') }}/api/v1/rule`,
            contentType: 'application/json; charset=utf-8',
            data: JSON.stringify(formData),
            dataType: 'json',
            success: function (response) {
                // Handle response dari server
                Swal.fire({
                    title: "Berhasil",
                    text: "Datqa berhasil diperbaharui",
                    icon: "success"
                }).then((res) => {
                    if (res.isConfirmed) {
                        location.reload()
                    }
                });
            },
            error: function (error) {
                // Handle error jika terjadi
                Swal.fire({
                    title: "TGagal",
                    text: "Periksa koneksi anda dan coba lagi",
                    icon: "error"
                });
            }
            });
        }
    </script>
@endsection