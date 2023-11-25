@extends('Layouts.Base')
@section('title')
    : Posisi
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <label for="">Masukan Kode RFID Disini</label>
                <input id="rfid-code"  type="text" class="form-control form-control-lg" placeholder="cth: 0006288xxx">
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card border border-1" style="border-radius: 10px !important;">
                <div class="row p-4 align-items-center">
                    <div class="col-lg-4 row px-4 justify-content-center"
                    style="
                        height: 100%;
                        width: 500px;
                        padding-top: 60px;
                    ">
                        <span class="h3 text-center" style="color: #212A3E">Tempelkan Kartu Pada Alat</span>
                    <img src="{{asset('assets/images/scanner.png')}}" alt="">
                    </div>
                    <div class="col-lg-8 px-xl-5">
                        <div id="card-present" class="card bg-gradient-primary card-img-holder text-white py-lg-5 my-transition">
                            <div class="card-body">
                                <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image">
                                <div id="data-scanner">
                                    
                                    <div>
                                        <p>Silahkan melakukan scan ID CARD untuk melakukan absensi</p>
                                        <h4>Menunggu <i class="fa-solid fa-address-card"></i></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#rfid-code').focus()
        })
        // Fungsi untuk menangani kejadian ketika tombol Enter ditekan
        function handleEnter(event) {
            // Pastikan tombol yang ditekan adalah tombol Enter
            if (event.key === "Enter") {

                // Ambil nilai dari input
                const nilaiInput = event.target.value;
                $('#rfid-code').prop('disabled', true)
                // Periksa apakah input memiliki nilai
                if (nilaiInput.trim() !== "") {
                    // Lakukan console log untuk nilai input
                    $.get(`{{ config('app.url') }}/api/v1/present/set?rfid=${nilaiInput}`, (res) => {
                        const data = res.data[1].data
                        const present = res.data[0]

                        console.log(present);

                        $('#data-scanner').html(`
                            <div>
                                <h4 class="font-weight-normal mb-3">${present === 1 ? 'ABSEN PULANG' : 'ABSEN MASUK'}</h4>
                                <h2 class="mb-5 text-uppercase">${data.name}</h2>
                                <h6 class="card-text text-capitalize">${data.satker}</h6>
                            </div>
                        `)

                        if (present === 1) {
                            $('#card-present').removeClass('bg-gradient-primary')
                            $('#card-present').addClass('bg-gradient-danger')
                        } else {
                            $('#card-present').addClass('bg-gradient-primary')
                            $('#card-present').removeClass('bg-gradient-danger')
                        }
                    })
                    .fail((err) => {
                        const errorData = err.responseJSON

                        if (err.status === 422) {
                            Swal.fire({
                                title: 'Gagal',
                                text : errorData.message,
                                icon : 'warning'
                            });
                        } else {
                            Swal.fire({
                                title: "Gagal",
                                text: "Periksa koneksi anda dan coba lagi",
                                icon: "error"
                            });
                        }
                        setLoading(false)
                    })
                }

                // Bersihkan nilai input setelah proses
                event.target.value = "";
                $('#rfid-code').prop('disabled', false)
                $('#rfid-code').focus()
            }
        }

        // Ambil elemen input
        const inputElement = document.getElementById("rfid-code"); // Gantilah "namaInput" dengan ID sesuai HTML Anda

        // Tambahkan event listener untuk mendeteksi setiap kali tombol ditekan
        inputElement.addEventListener("keydown", handleEnter);
    </script>
@endsection