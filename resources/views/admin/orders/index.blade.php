@extends('layouts.admin')

@section('title', 'Kelola Pesanan Masuk - Gitania Skincare')

@section('content')
<div style="margin-bottom: 24px;">
    <h2 style="color: #1e293b; font-size: 20px; font-weight: 700; margin: 0 0 4px 0; font-family: 'Poppins', sans-serif;">🛍️ Kelola Pesanan Masuk</h2>
    <p style="color: #64748b; font-size: 13px; margin: 0;">Perbarui status pengiriman dan cari data pesanan pelanggan.</p>
</div>

@if(session('success'))
    <div style="background: #f0fdf4; color: #16a34a; padding: 12px 18px; border-radius: 12px; margin-bottom: 20px; border: 1px solid #dcfce7; font-size: 13px; font-weight: 600;">
        ✨ {{ session('success') }}
    </div>
@endif

<div class="admin-card">

    <!-- Form Pencarian Pesanan Responsif -->
    <form action="{{ route('admin.orders.index') }}" method="GET" class="admin-search-bar">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Invoice atau Nama Pelanggan..." style="padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 13px; outline: none; font-family: inherit;">
        <button type="submit" style="background: var(--admin-purple); color: white; border: none; padding: 10px 18px; border-radius: 10px; font-weight: 600; font-size: 13px; cursor: pointer; white-space: nowrap;">Cari</button>
        @if(request('search'))
            <a href="{{ route('admin.orders.index') }}" style="background: #f1f5f9; color: #475569; padding: 10px 14px; border-radius: 10px; font-size: 13px; text-decoration: none; display: flex; align-items: center; white-space: nowrap;">Reset</a>
        @endif
    </form>

    <div class="admin-table-container">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px; min-width: 700px;">
            <thead>
                <tr style="background: #f8fafc; color: #475569; text-align: left; border-bottom: 1px solid #f1f5f9;">
                    <th style="padding: 12px 14px; font-weight: 600;">No. Invoice</th>
                    <th style="padding: 12px 14px; font-weight: 600;">Pelanggan</th>
                    <th style="padding: 12px 14px; font-weight: 600;">Total Harga</th>
                    <th style="padding: 12px 14px; font-weight: 600;">Status Saat Ini</th>
                    <th style="padding: 12px 14px; font-weight: 600; text-align: center;">Aksi & Update Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders ?? [] as $order)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 12px 14px; font-weight: 600; color: var(--admin-purple);">{{ $order->invoice_number }}</td>
                    <td style="padding: 12px 14px; color: #334155;">{{ $order->customer_name }}</td>
                    <td style="padding: 12px 14px; font-weight: 700; color: #1e293b;">IDR {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td style="padding: 12px 14px;">
                        @php
                            $statusColors = [
                                'pending' => ['bg' => '#fef3c7', 'text' => '#d97706'],
                                'paid' => ['bg' => '#dbeafe', 'text' => '#1d4ed8'],
                                'packed' => ['bg' => '#fae8ff', 'text' => '#c084fc'],
                                'shipping' => ['bg' => '#e0f2fe', 'text' => '#0284c7'],
                                'completed' => ['bg' => '#dcfce7', 'text' => '#16a34a'],
                                'cancelled' => ['bg' => '#fee2e2', 'text' => '#dc2626'],
                            ];
                            $sc = $statusColors[$order->status] ?? ['bg' => '#f1f5f9', 'text' => '#475569'];
                        @endphp
                        <span style="background: {{ $sc['bg'] }}; color: {{ $sc['text'] }}; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block;">
                            {{ ucfirst($order->status) }}
                        </span>
                        @if($order->payment_type)
                            <div style="font-size: 10px; color: #64748b; margin-top: 3px; font-weight: 600;">
                                💳 {{ strtoupper(str_replace('_', ' ', $order->payment_type)) }}
                            </div>
                        @endif
                    </td>
                    <td style="padding: 12px 14px; text-align: center;">
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" style="display: inline-flex; gap: 6px; justify-content: center; align-items: center; flex-wrap: wrap;">
                            @csrf
                            @method('PATCH')

                            <select name="status" style="padding: 6px 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 12px; background: #fff; font-family: inherit;">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="packed" {{ $order->status == 'packed' ? 'selected' : '' }}>Packed</option>
                                <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>Shipping</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>

                            <input type="text" name="tracking_number" value="{{ $order->tracking_number }}" placeholder="No. Resi" style="padding: 6px 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 12px; width: 100px; font-family: inherit;">

                            <button type="submit" style="background: var(--admin-purple); color: white; border: none; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; white-space: nowrap;">
                                Simpan
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: #94a3b8;">
                        <div style="font-size: 32px; margin-bottom: 10px;">🔍</div>
                        Tidak ada data pesanan yang cocok dengan pencarian Anda.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginasi Pesanan -->
    <div style="margin-top: 20px; overflow-x: auto;">
        {{ $orders->links() }}
    </div>
</div>
@endsection
