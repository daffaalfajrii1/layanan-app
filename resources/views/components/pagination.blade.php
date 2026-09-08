@props(['items'])

@if ($items->total() > 0)
    <div class="row g-0 align-items-center mt-3">
        <div class="col-sm-12 col-md-5 mb-2 mb-md-0">
            Menampilkan {{ $items->firstItem() }} sampai {{ $items->lastItem() }} dari {{ $items->total() }} data
        </div>
        <div class="col-sm-12 col-md-7">
            @if ($items->hasPages())
                <nav aria-label="Navigasi halaman">
                    <ul class="pagination justify-content-center justify-content-md-end mb-0">
                        @foreach ($items->linkCollection() as $link)
                            @php
                                parse_str(parse_url((string) $link['url'], PHP_URL_QUERY) ?? '', $query);
                                $page = $query[$items->getPageName()] ?? null;
                            @endphp

                            @if ($link['url'] === null)
                                <li class="page-item disabled">
                                    <span class="page-link">{!! $link['label'] !!}</span>
                                </li>
                            @elseif ($link['active'])
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">{!! $link['label'] !!}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <button
                                        type="button"
                                        class="page-link"
                                        wire:click="gotoPage({{ (int) $page }}, '{{ $items->getPageName() }}')"
                                    >
                                        {!! $link['label'] !!}
                                    </button>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </nav>
            @endif
        </div>
    </div>
@endif
