@if ($paginator->lastPage() > 1)
    <ul class="pagination pagination-sm">
        <li class="previous {{ ($paginator->currentPage() == 1) ? 'disabled' : '' }} pull-left">
            <a href="{{ $paginator->url($paginator->currentPage() - 1) }}">{{ trans('web/comment.button.prev') }}</a>
         </li>
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            @php
                $halfTotalLinks = floor(config('limitation.comment.link_pagination') / 2);
                $from = $paginator->currentPage() - $halfTotalLinks;
                $to = $paginator->currentPage() + $halfTotalLinks;

                if ($paginator->currentPage() < $halfTotalLinks) {
                   $to += $halfTotalLinks - $paginator->currentPage();
                }

                if ($paginator->lastPage() - $paginator->currentPage() < $halfTotalLinks) {
                    $from -= $halfTotalLinks - ($paginator->lastPage() - $paginator->currentPage()) - 1;
                }
            @endphp
            @if ($from < $i && $i < $to)
                <li class="{{ ($paginator->currentPage() == $i) ? 'active' : '' }}">
                    <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endif
        @endfor
        <li class="next {{ ($paginator->currentPage() == $paginator->lastPage()) ? 'disabled' : '' }} pull-right">
            @if ($paginator->currentPage() + 1 >= $paginator->lastPage())
                <a href="{{ $paginator->url($paginator->lastPage()) }}">{{ trans('web/comment.button.next') }}</a>
            @else
                <a href="{{ $paginator->url($paginator->currentPage() + 1) }}">{{ trans('web/comment.button.next') }}</a>
            @endif
        </li>
    </ul>
@endif
