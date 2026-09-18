@extends('layouts.app')

@section('title', 'ผู้ใช้งานและช่างซ่อม')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">จัดการผู้ใช้งานและช่างซ่อม</h2>
            <p class="text-xs text-slate-500 mt-1">รายชื่อผู้ดูแลระบบ, เจ้าหน้าที่รับเครื่อง, และช่างผู้ชำนาญการ</p>
        </div>

        <x-button variant="primary" icon="bi-plus-lg" onclick="document.getElementById('createUserModal').classList.remove('hidden')">
            เพิ่มผู้ใช้งาน / ช่าง
        </x-button>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs text-slate-500 uppercase font-semibold border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">ชื่อ-นามสกุล</th>
                        <th class="px-6 py-3.5">อีเมล (บัญชีเข้าสู่ระบบ)</th>
                        <th class="px-6 py-3.5">เบอร์โทรศัพท์</th>
                        <th class="px-6 py-3.5">บทบาท (Role)</th>
                        <th class="px-6 py-3.5">งานที่รับผิดชอบ</th>
                        <th class="px-6 py-3.5">สถานะ</th>
                        <th class="px-6 py-3.5 text-right">การจัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-800 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    @if($user->avatar_url)
                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-9 h-9 rounded-full object-cover border border-slate-200 shadow-2xs flex-shrink-0">
                                    @else
                                        <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-xs flex-shrink-0">
                                            {{ mb_substr($user->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <span>{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                                {{ $user->phone ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $roleBadges = [
                                        'admin' => 'bg-purple-50 text-purple-700 border-purple-200',
                                        'technician' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'staff' => 'bg-slate-100 text-slate-700 border-slate-200',
                                    ];
                                    $roleLabels = [
                                        'admin' => 'ผู้ดูแลระบบ (Admin)',
                                        'technician' => 'ช่างซ่อม (Technician)',
                                        'staff' => 'เจ้าหน้าที่ (Staff)',
                                    ];
                                @endphp
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $roleBadges[$user->role] ?? '' }}">
                                    {{ $roleLabels[$user->role] ?? $user->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-slate-600 text-xs">
                                {{ $user->repairs_count }} งาน
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->is_active)
                                    <span class="inline-flex items-center gap-1.5 text-xs text-emerald-700 font-medium">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> ใช้งานอยู่
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs text-slate-400 font-medium">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> ปิดใช้งาน
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('ต้องการลบผู้ใช้งานนี้ใช่หรือไม่?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-rose-600 hover:text-rose-800 font-medium">
                                        ลบ
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                                ไม่พบข้อมูลผู้ใช้งาน
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal: Add User -->
<div id="createUserModal" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xl max-w-md w-full p-6">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
            <h3 class="font-bold text-slate-800 text-base">เพิ่มผู้ใช้งาน / ช่างใหม่</h3>
            <button onclick="document.getElementById('createUserModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">&times;</button>
        </div>

        <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Avatar Upload with Live Preview -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">รูปโปรไฟล์ (Avatar)</label>
                <div class="flex items-center gap-3">
                    <div id="avatarPreviewContainer" class="w-12 h-12 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center overflow-hidden flex-shrink-0 shadow-2xs">
                        <img id="avatarPreviewImg" src="" class="w-full h-full object-cover hidden">
                        <i id="avatarPlaceholderIcon" class="bi bi-person text-slate-400 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <input type="file" name="avatar" accept="image/*" onchange="previewUserAvatar(event)"
                               class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                        <p class="text-[11px] text-slate-400 mt-0.5">รองรับ JPG, PNG, WEBP (ไม่เกิน 2MB)</p>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">ชื่อ-นามสกุล <span class="text-rose-500">*</span></label>
                <input type="text" name="name" required class="w-full px-3 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">อีเมล <span class="text-rose-500">*</span></label>
                <input type="email" name="email" required class="w-full px-3 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">รหัสผ่าน <span class="text-rose-500">*</span></label>
                <input type="password" name="password" required class="w-full px-3 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">บทบาท <span class="text-rose-500">*</span></label>
                    <select name="role" required class="w-full px-3 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500">
                        <option value="technician">ช่างซ่อม (Technician)</option>
                        <option value="staff">พนักงาน (Staff)</option>
                        <option value="admin">ผู้ดูแลระบบ (Admin)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">เบอร์โทรศัพท์</label>
                    <input type="text" name="phone" class="w-full px-3 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500">
                </div>
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                <x-button variant="secondary" size="sm" type="button" onclick="document.getElementById('createUserModal').classList.add('hidden')">
                    ยกเลิก
                </x-button>
                <x-button variant="primary" size="sm" type="submit">
                    บันทึก
                </x-button>
            </div>
        </form>
    </div>
</div>

<script>
function previewUserAvatar(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('avatarPreviewImg');
            const icon = document.getElementById('avatarPlaceholderIcon');
            img.src = e.target.result;
            img.classList.remove('hidden');
            if (icon) icon.classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
