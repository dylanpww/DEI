@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-sm p-6 md:p-8 relative">

        <div class="flex items-center justify-between border-b border-gray-100 pb-5 mb-6">
            <div class="flex items-center gap-3">
                <a href="{{ route('cart') }}"
                    class="text-gray-400 hover:text-crave-teal transition-colors text-2xl flex items-center">
                    <ion-icon name="arrow-back-outline"></ion-icon>
                </a>
                <h1 class="font-extrabold text-2xl text-crave-teal">Checkout</h1>
            </div>
        </div>

        <div class="mb-8 bg-gray-50 rounded-2xl p-5 border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-4">Ringkasan Pesanan</h3>
            <div class="flex justify-between items-center mb-2 text-sm text-gray-600">
                <span>Total Item ({{ count($cartItems) }})</span>
                <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center mb-4 text-sm text-gray-600">
                <span>Biaya Pengiriman (Ke: {{ $selectedAddress->name }})</span>
                <span>Rp 10.000</span>
            </div>
            <div class="flex justify-between items-center pt-4 border-t border-dashed border-gray-200">
                <span class="font-bold text-gray-800">Total Pembayaran</span>
                <span class="font-extrabold text-xl text-crave-darkgreen">Rp
                    {{ number_format($totalPrice + 10000, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="mt-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-800 text-lg">Pembayaran via QRIS</h3>
                <span
                    class="bg-crave-lime/20 text-crave-darkgreen text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1">
                    <ion-icon name="shield-checkmark"></ion-icon> Aman
                </span>
            </div>

            <div class="bg-gray-50 border border-gray-100 rounded-2xl p-6 text-center shadow-inner">
                <p class="text-gray-600 text-sm mb-4">Pindai kode QR di bawah menggunakan aplikasi perbankan atau e-wallet yang didukung
                    (GoPay, OVO, Dana, ShopeePay, BCA, etc.)</p>

                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 inline-block mb-4">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=CRAVE-PAYMENT-MOCKUP"
                        alt="QRIS Payment" class="w-48 h-48 mx-auto object-contain">
                </div>

                <div class="text-sm">
                    <p class="text-gray-500 mb-1">Total dibayar:</p>
                    <p class="font-extrabold text-2xl text-crave-teal">Rp
                        {{ number_format($totalPrice + 10000, 0, ',', '.') }}</p>
                </div>
            </div>

            <form action="{{ route('checkout.process') }}" method="POST" class="mt-6"
                onsubmit="return confirm('Apakah Anda telah berhasil memindai dan membayar melalui kode QR?');">
                @csrf
                <input type="hidden" name="payment_method" value="qris">

                <button type="submit"
                    class="w-full bg-crave-teal hover:bg-crave-darkgreen text-white font-bold text-lg py-4 rounded-2xl shadow-md transition-all transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
                    <ion-icon name="checkmark-circle-outline" class="text-xl"></ion-icon> Saya Sudah Bayar
                </button>
                <p class="text-xs text-center text-gray-400 mt-3">By clicking the button, you confirm that the payment has
                    been completed.</p>
            </form>
        </div>

    </div>
@endsection

