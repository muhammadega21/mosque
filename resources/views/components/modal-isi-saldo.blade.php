<div x-data="{
    step: 1,
    saldo: {{ old('saldo', 0) }},
    metode_pembayaran: '{{ old('metode_pembayaran', '') }}',
    dataRekening: {
        'bank': 'Bank ABC - 1234567890 a.n DokuMosque',
        'gopay': '081234567890 a.n DokuMosque',
        'ovo': '081234567890 a.n DokuMosque',
        'dana': '081234567890 a.n DokuMosque'
    },
    get detailRekening() {
        return this.dataRekening[this.metode_pembayaran] || '';
    }
}">
    <!-- Modal Trigger -->
    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addSaldo">
        Isi saldo <span class="fw-semibold">+</span>
    </button>

    <!-- Modal -->
    <div class="modal fade" id="addSaldo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" x-text="step === 1 ? 'Isi Saldo' : 'Upload Bukti Pembayaran'"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ url('donasi/saldo') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Step 1: Pilih Metode Pembayaran -->
                    <div class="modal-body" x-show="step === 1" x-transition>
                        <div class="row mb-3">
                            <span><strong>Saldo saat ini</strong> : Rp
                                {{ number_format(Auth::user()->user_data->saldo, 2, ',', '.') }}</span>
                            <div class="mt-3">
                                <div class="input-box col-sm-12">
                                    <label for="saldo" class="mb-2 required">Jumlah</label>
                                    <input type="number" x-model="saldo" id="saldo"
                                        class="form-control @error('saldo') is-invalid @enderror" name="saldo"
                                        placeholder="Masukkan Jumlah Saldo" required>
                                    @error('saldo')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="input-box col-sm-12">
                                    <label for="metode_pembayaran" class="mb-2 required">Metode Pembayaran</label>
                                    <select x-model="metode_pembayaran" id="metode_pembayaran"
                                        class="form-select @error('metode_pembayaran') is-invalid @enderror"
                                        name="metode_pembayaran" required>
                                        <option value="" selected disabled>Pilih Metode Pembayaran</option>
                                        <option value="bank">Bank</option>
                                        <option value="gopay">Gopay</option>
                                        <option value="ovo">Ovo</option>
                                        <option value="dana">Dana</option>
                                    </select>
                                    @error('metode_pembayaran')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- Info Rekening -->
                                <div x-show="metode_pembayaran" class="mt-2 p-3 bg-light rounded">
                                    <strong>Nomor Rekening/Tujuan:</strong>
                                    <div x-text="detailRekening"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Upload Bukti Pembayaran -->
                    <div class="modal-body" x-show="step === 2" x-transition>
                        <div class="row mb-3">
                            <div class="col-12">
                                <p><strong>Metode Pembayaran:</strong>
                                    <span
                                        x-text="metode_pembayaran.charAt(0).toUpperCase() + metode_pembayaran.slice(1)"></span>
                                </p>
                                <p><strong>Nomor Rekening/Tujuan:</strong>
                                    <span x-text="detailRekening"></span>
                                </p>
                                <p><strong>Jumlah:</strong>
                                    Rp <span x-text="new Intl.NumberFormat('id-ID').format(saldo)"></span>
                                </p>
                            </div>
                            <div class="mt-3">
                                <div class="input-box col-sm-12">
                                    <label for="bukti_pembayaran" class="mb-2 required">Upload Bukti Pembayaran</label>
                                    <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                                        id="bukti_pembayaran" name="gambar" accept="image/*,.pdf" required>
                                    <small class="text-muted">Format: JPG, PNG, JPEG (Maks: 2MB)</small>
                                    @error('gambar')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <!-- Step 1 Buttons -->
                        <template x-if="step === 1">
                            <div>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="button" class="btn btn-primary"
                                    x-bind:disabled="!saldo || !metode_pembayaran" @click="step = 2">
                                    Lanjut
                                </button>
                            </div>
                        </template>

                        <!-- Step 2 Buttons -->
                        <template x-if="step === 2">
                            <div>
                                <button type="button" class="btn btn-secondary" @click="step = 1">Kembali</button>
                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </div>
                        </template>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Reset modal state when closed
            $('#addSaldo').on('hidden.bs.modal', function() {
                Alpine.data('modalIsiSaldo').step = 1;
            });

            // Show modal with errors if any
            @if ($errors->has('saldo') || $errors->has('metode_pembayaran') || $errors->has('gambar'))
                $(document).ready(function() {
                    $('#addSaldo').modal('show');
                    @if ($errors->has('gambar'))
                        Alpine.data('modalIsiSaldo').step = 2;
                    @endif
                });
            @endif
        });
    </script>
@endpush
