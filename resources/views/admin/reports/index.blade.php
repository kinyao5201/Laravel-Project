@php
    use App\Enums\ReportType;
@endphp

<x-template-admin-layout>
    <!-- 主要內容 -->
    <x-flex-container>
        <x-div.container>
            <x-h.h3>檢舉詳情</x-h.h3>

            <div class="mb-8">
                <x-div.flex-container class="flex-col sm:flex-row space-y-4 sm:space-y-0">
                    <x-h.h2 id="reviews-title">Reviews</x-h.h2>
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                        <form action="{{ route('admin.reports.index') }}" method="GET"
                            class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                            <div class="w-full sm:w-auto">
                                <select name="filter[type]" class="w-full sm:w-auto bg-gray text-primary-foreground px-4 py-2 rounded-md mb-2 sm:mb-0">
                                    @foreach ([ReportType::Product->value(), ReportType::Message->value()] as $reportType)
                                        <option value="{{ $reportType }}"
                                            {{ request('filter.type') === $reportType ? 'selected' : '' }}>
                                            {{ $reportType }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-full sm:w-auto">
                                <x-input.search type="text" name="filter[name]" placeholder="搜尋商品名稱或訊息..."
                                    value="{{ request('filter.name') }}" class="w-full">
                                </x-input.search>
                            </div>
                            <x-button.search class="w-full sm:w-auto">
                                搜尋
                            </x-button.search>
                        </form>
                    </div>
                </x-div.flex-container>
            </div>

            <!-- 商品檢舉詳情內容 -->
            @if (request('filter.type') === ReportType::Product->value())
                <div id="product-content" class="mb-8 mt-4">
                    <x-div.bg-white>
                        <div class="overflow-x-auto -mx-4 sm:mx-0">
                            <x-table.gray-200>
                                <x-thead.reportable />
                                <x-gray-200>
                                    @foreach ($reportables as $reportable)
                                        <tr>
                                            <x-gray-900>{{ $reportable->reportable ? $reportable->reportable->name : 'N/A' }}</x-gray-900>
                                            <x-gray-900>{{ $reportable->report->reportType->name }}</x-gray-900>
                                            <x-gray-900>{{ $reportable->report->description }}</x-gray-900>
                                            <x-gray-900>{{ $reportable->report->user->email }}</x-gray-900>
                                            <x-gray-900>{{ $reportable->report->updated_at->format('Y-m-d') }}</x-gray-900>
                                        </tr>
                                    @endforeach
                                </x-gray-200>
                            </x-table.gray-200>
                        </div>

                        <!-- 分頁導航 -->
                        <x-div.gray-200>
                            {{ $reportables->links() }}
                        </x-div.gray-200>
                    </x-div.bg-white>
                </div>
            @endif

            <!-- 留言檢舉詳情內容 -->
            @if (request('filter.type') === ReportType::Message->value())
                <div id="message-content" class="mb-8 mt-4">
                    <x-div.bg-white>
                        <div class="overflow-x-auto -mx-4 sm:mx-0">
                            <x-table.gray-200>
                                <x-thead.reportable />
                                <x-gray-200>
                                    @foreach ($reportables as $reportable)
                                        <tr>
                                            <x-gray-900>{{ $reportable->reportable ? $reportable->reportable->message : 'N/A' }}</x-gray-900>
                                            <x-gray-900>{{ $reportable->report->reportType->name }}</x-gray-900>
                                            <x-gray-900>{{ $reportable->report->description }}</x-gray-900>
                                            <x-gray-900>{{ $reportable->report->user->email }}</x-gray-900>
                                            <x-gray-900>{{ $reportable->report->updated_at->format('Y-m-d') }}</x-gray-900>
                                        </tr>
                                    @endforeach
                                </x-gray-200>
                            </x-table.gray-200>
                        </div>

                        <!-- 分頁導航 -->
                        <x-div.gray-200>
                            {{ $reportables->links() }}
                        </x-div.gray-200>
                    </x-div.bg-white>
                </div>
            @endif
        </x-div.container>
    </x-flex-container>
</x-template-admin-layout>
