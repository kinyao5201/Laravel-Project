<!-- 左側邊欄 -->
<div class="w-full md:w-64 bg-white shadow-md">
    <div class="p-4 text-2xl font-bold flex items-center">
        <a href="{{ route('dashboard') }}"> <class="flex items-center">
            <img src="{{ asset('images/book-4-fix.png') }}" alt="Logo" class="w-8 h-8 mr-2">
        </a>
        管理者後台
    </div>
    <nav class="mt-4" x-data="{ open: true }">
        <div @click="open = !open" class="block py-2 px-4 text-gray-700 hover:bg-gray-200">
            <x-div.side-bar-admin>
                <span>後台管理系統</span>
                <svg :class="{ 'transform rotate-180': open }" class="w-4 h-4 transition-transform duration-200"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </x-div.side-bar-admin>
        </div>
        <div x-show="open" class="pl-4">
            <x-a.block-hover href="{{ route('admin.products.index') }}">商品管理</x-a.block-hover>
            <x-a.block-hover href="{{ route('admin.users.index') }}">用戶管理</x-a.block-hover>
            <x-a.block-hover href="{{ route('admin.messages.index') }}">留言管理</x-a.block-hover>
            <x-a.block-hover href="{{ route('admin.roles.index') }}">角色管理</x-a.block-hover>
            <x-a.block-hover href="{{ route('admin.reports.index') }}">檢舉管理</x-a.block-hover>
        </div>
    </nav>

    <nav class="mt-4" x-data="{ open: true }">
        <div @click="open = !open" class="block py-2 px-4 text-gray-700 hover:bg-gray-200">
            <x-div.side-bar-admin>
                <span>標籤與檢舉類型管理系統</span>
                <svg :class="{ 'transform rotate-180': open }" class="w-4 h-4 transition-transform duration-200"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </x-div.side-bar-admin>
        </div>
        <div x-show="open" class="pl-4">
            <x-a.block-hover href="{{ route('admin.tags.index') }}">新增與停用標籤</x-a.block-hover>
            <x-a.block-hover href="{{ route('admin.report-types.index') }}">新增與停用檢舉類型</x-a.block-hover>
        </div>
    </nav>
</div>
