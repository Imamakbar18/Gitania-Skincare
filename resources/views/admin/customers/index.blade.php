@extends('layouts.admin')

@section('title', 'Kelola Pelanggan - Gitania Skincare')

@section('content')
<div style="margin-bottom: 24px;">
    <h2 style="color: #1e293b; font-size: 20px; font-weight: 700; margin: 0 0 4px 0; font-family: 'Poppins', sans-serif;">👥 Kelola Daftar Pelanggan</h2>
    <p style="color: #64748b; font-size: 13px; margin: 0;">Pantau data akun pengguna yang terdaftar di toko.</p>
</div>

<!-- Kotak Konten Tabel Pelanggan -->
<div class="admin-card">

    <div class="admin-table-container">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px; min-width: 600px;">
            <thead>
                <tr style="background: #f8fafc; color: #475569; text-align: left; border-bottom: 1px solid #f1f5f9;">
                    <th style="padding: 12px 14px; font-weight: 600; width: 50px;">No</th>
                    <th style="padding: 12px 14px; font-weight: 600;">Nama Pelanggan</th>
                    <th style="padding: 12px 14px; font-weight: 600;">Email</th>
                    <th style="padding: 12px 14px; font-weight: 600;">Status Akun</th>
                    <th style="padding: 12px 14px; font-weight: 600;">Tanggal Bergabung</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers ?? [] as $index => $customer)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 12px 14px; color: #64748b;">{{ $customers->firstItem() + $index }}</td>
                    <td style="padding: 12px 14px; font-weight: 600; color: #1e293b;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 32px; height: 32px; background: #f3e8ff; color: var(--admin-purple); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px; flex-shrink: 0;">
                                {{ substr($customer->name, 0, 1) }}
                            </div>
                            <span>{{ $customer->name }}</span>
                        </div>
                    </td>
                    <td style="padding: 12px 14px; color: #475569;">{{ $customer->email }}</td>
                    <td style="padding: 12px 14px;">
                        <span style="background: #dcfce7; color: #16a34a; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block;">
                            Aktif
                        </span>
                    </td>
                    <td style="padding: 12px 14px; color: #64748b; font-size: 12px;">{{ $customer->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: #94a3b8;">
                        <div style="font-size: 32px; margin-bottom: 10px;">👥</div>
                        Belum ada pelanggan terdaftar di database.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginasi -->
    <div style="margin-top: 20px; overflow-x: auto;">
        {{ $customers->links() }}
    </div>
</div>
@endsection
