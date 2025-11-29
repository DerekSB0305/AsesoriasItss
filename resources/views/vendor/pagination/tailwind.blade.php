@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="mt-6 flex justify-center">

        <ul class="flex items-center gap-2 px-1 py-2
                   overflow-x-auto max-w-full
                   scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-transparent">

            {{-- ANTERIOR --}}
            @if ($paginator->onFirstPage())
                <span class="w-9 h-9 flex items-center justify-center
                             bg-gray-200 text-gray-400 rounded-lg cursor-not-allowed">‹</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="w-9 h-9 flex items-center justify-center
                          bg-gray-200 text-[#0B3D7E] font-bold rounded-lg hover:bg-gray-300">‹</a>
            @endif


            {{-- NÚMEROS RESPONSIVOS --}}
            @foreach ($elements as $element)

                {{-- SEPARADOR --}}
                @if (is_string($element))
                    <span class="px-3 py-2 text-gray-400">{{ $element }}</span>
                @endif

                {{-- LISTA DE PÁGINAS --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)

                        {{-- 📱 MODO MÓVIL: mostrar solo:
                            - página actual
                            - anterior inmediata
                            - siguiente inmediata
                        --}}
                        @php
                            $current = $paginator->currentPage();
                            $isMobile = request()->header('User-Agent') &&
                                        preg_match('/Mobile|Android|iPhone/', request()->header('User-Agent'));

                            $showPage =
                                !$isMobile ||          // mostrar todo en escritorio
                                $page == $current ||   // página actual
                                $page == $current - 1 ||
                                $page == $current + 1;
                        @endphp


                        @if ($showPage)
                            {{-- Página Actual --}}
                            @if ($page == $current)
                                <span class="min-w-[40px] h-10 flex items-center justify-center
                                             rounded-lg bg-[#0B3D7E] text-white font-bold shadow">
                                    {{ $page }}
                                </span>

                            {{-- Página Normal --}}
                            @else
                                <a href="{{ $url }}"
                                   class="min-w-[40px] h-10 flex items-center justify-center
                                          rounded-lg bg-[#1ABC9C] text-white font-semibold
                                          hover:bg-[#28A745] transition shadow">
                                    {{ $page }}
                                </a>
                            @endif

                        @elseif($isMobile && ($page == 1 || $page == $paginator->lastPage()))
                            {{-- Mostrar primero y último como "…" si está lejos --}}
                            <span class="px-3 py-2">…</span>
                        @endif

                    @endforeach
                @endif

            @endforeach


            {{-- SIGUIENTE --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="w-9 h-9 flex items-center justify-center
                          bg-gray-200 text-[#0B3D7E] font-bold rounded-lg hover:bg-gray-300">›</a>
            @else
                <span class="w-9 h-9 flex items-center justify-center
                             bg-gray-200 text-gray-400 rounded-lg cursor-not-allowed">›</span>
            @endif

        </ul>

    </nav>
@endif


