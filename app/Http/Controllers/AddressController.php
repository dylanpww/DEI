<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        // Mengambil alamat milik user yang sedang login
        $addresses = Address::where('user_ID', Auth::id())->get();
        return view('addresses.myAddress', compact('addresses'));
    }

    public function create()
    {
        return view('addresses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'telephoneNumber' => 'required|string|max:20',
            'completeAddress' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        // Tambahkan user_ID secara manual
        $validated['user_ID'] = Auth::id();

        Address::create($validated);

        return redirect()->route('cart')->with('success', 'Alamat berhasil ditambahkan!');
    }

    public function edit(Address $address)
    {
        if ($address->user_ID !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('addresses.edit', compact('address'));
    }

    public function update(Request $request, Address $address)
    {
        if ($address->user_ID !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'telephoneNumber' => 'required|string|max:20',
            'completeAddress' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $address->update($validated);

        return redirect()->route('addresses.index')->with('success', 'Alamat berhasil diperbarui!');
    }

    public function destroy(Address $address)
    {
        if ($address->user_ID !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $address->delete();

        return redirect()->route('addresses.index')->with('success', 'Alamat berhasil dihapus!');
    }
}
