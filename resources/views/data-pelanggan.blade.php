@extends('layouts.app')
@section('content')
<style>
    .input-group .form-control {
        position: relative;
        padding-right: 30px; /* Ruang untuk ikon */
    }

    .input-group .form-control:invalid {
        border-color: red;
        background-image: url('data:image/svg+xml;charset=UTF8,<svg xmlns="http://www.w3.org/2000/svg" fill="red" viewBox="0 0 16 16"><path d="M8 1a7 7 0 1 1 0 14A7 7 0 0 1 8 1zm0 1a6 6 0 1 0 0 12A6 6 0 0 0 8 2zM5.292 4.708a1 1 0 0 1 1.414 0L8 6.293l1.293-1.585a1 1 0 1 1 1.414 1.415L9.414 7.708l1.293 1.585a1 1 0 0 1-1.414 1.414L8 9.414l-1.293 1.585a1 1 0 0 1-1.414-1.414L6.586 7.708 5.293 6.293a1 1 0 0 1 0-1.585z"/></svg>');
        background-repeat: no-repeat;
        background-position: right 8px center;
        background-size: 16px;
    }

    .input-group .form-control:valid {
        border-color: green;
        background-image: url('data:image/svg+xml;charset=UTF8,<svg xmlns="http://www.w3.org/2000/svg" fill="green" viewBox="0 0 16 16"><path d="M16 8a8 8 0 1 1-16 0A8 8 0 0 1 16 8zM7.35 11.62L3.27 7.54a.8.8 0 0 1 1.15-1.15l2.77 2.77 5.43-5.43a.8.8 0 1 1 1.15 1.15L7.35 11.62z"/></svg>');
        background-position: right 8px center;
        background-size: 16px;
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title" style="font-size: 25px;">Data Pelanggan</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body pt-0">
                <h4 class="header-title mt-2">Cari Data Pelanggan</h4>
                <div dir="ltr">
                    <div class="row">
                        <div class="col-12">
                            <form class="needs-validation" novalidate>
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label" for="customer_id">Nomor Konsumen</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control numeric-customer-id" id="customer_id" name="customer_id" maxlength="10" required/>
                                        <div class="invalid-feedback">
                                            Mohon isi nomor konsumen.
                                        </div>
                                        <div class="invalid-tooltip">
                                            Data konsumen tidak ditemukan.
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" id="btn-search" class="btn btn-primary btn-sm">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="result-container" style="display: none;">
                            <div class="row mb-3">
                                <label class="col-md-3 col-form-label" for="customer_name">Nama Konsumen</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="customer_name" name="customer_name"/>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 col-form-label" for="address">Alamat Konsumen</label>
                                <div class="col-md-3">
                                    <textarea type="text" class="form-control" id="address" name="address" cols="3"></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 col-form-label" for="postal_code">Kode Pos</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="postal_code" name="postal_code"/>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 col-form-label" for="tarif_cd">Kode Tarif</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="tarif_cd" name="tarif_cd"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@section('js-page')
<script>
    document.getElementById('btn-search').addEventListener('click', function (event) {
        event.preventDefault();

        const custimerIdInput = document.getElementById('customer_id');
        const customerId = custimerIdInput.value.trim(); // Trim untuk menghilangkan whitespace
        const invalidFeedback = document.querySelector('.invalid-feedback');
        const invalidTooltip = document.querySelector('.invalid-tooltip');
        const resultContainer = document.getElementById('result-container');

        // Reset tampilan validasi awal
        invalidFeedback.style.display = 'none';
        invalidTooltip.style.display = 'none';
        custimerIdInput.classList.remove('is-invalid');

        // Validasi input kosong
        if (!customerId) {
            custimerIdInput.classList.add('is-invalid');
            invalidFeedback.style.display = 'block';
            return;
        }

        // Fetch data pelanggan berdasarkan input
        fetch('/search-data-pelanggan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ customer_id: customerId }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === 'success') {
                    // Jika data ditemukan
                    custimerIdInput.classList.remove('is-invalid');
                    invalidTooltip.style.display = 'none';
                    resultContainer.style.display = 'block';

                    // Menampilkan data ke input yang relevan
                    document.getElementById('customer_name').value = data.data.customer_name;
                    document.getElementById('address').value = data.data.address;
                    document.getElementById('postal_code').value = data.data.postal_code;
                    document.getElementById('tarif_cd').value = data.data.tarif_cd;
                } else {
                    // Jika data tidak ditemukan
                    custimerIdInput.classList.add('is-invalid');
                    invalidTooltip.style.display = 'block';
                    resultContainer.style.display = 'none';
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                custimerIdInput.classList.add('is-invalid');
                invalidTooltip.style.display = 'block';
                resultContainer.style.display = 'none';
            });
    });
</script>
@endsection
@endsection