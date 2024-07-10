<!-- Memuat jQuery (pilih salah satu) -->
<script src="{{ url('AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->

<!-- Memuat SweetAlert (pastikan pustaka ini dimuat jika Anda menggunakan Swal.fire()) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Memuat Skrip Login -->
<script src="{{ url('AdminLTE/scripts/login.js') }}"></script>
{{-- alert from session --}}
<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>




@if (session()->has('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
        });
    </script>
@endif

@if (session()->has('failed'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Failed',
            text: "{{ session('failed') }}",
        });
    </script>
@endif
