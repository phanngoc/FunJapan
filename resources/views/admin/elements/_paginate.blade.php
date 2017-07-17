@if ($results->lastPage() > 1)
    <ul class="pagination pagination-sm">
        <li class="first {{ ($results->currentPage() == 1) ? 'disabled' : '' }} pull-left">
            <a href="{{ $results->url(1) }}"><<</a>
        </li>
        <li class="previous {{ ($results->currentPage() == 1) ? 'disabled' : '' }} pull-left">
            <a href="{{ $results->url($results->currentPage() - 1) }}"><</a>
        </li>
        @for ($i = 1; $i <= $results->lastPage(); $i++)
            @php
                $halfTotalLinks = floor(config('limitation.comment.link_pagination') / 2);
                $from = $results->currentPage() - $halfTotalLinks;
                $to = $results->currentPage() + $halfTotalLinks;

                if ($results->currentPage() < $halfTotalLinks) {
                   $to += $halfTotalLinks - $results->currentPage();
                }

                if ($results->lastPage() - $results->currentPage() < $halfTotalLinks) {
                    $from -= $halfTotalLinks - ($results->lastPage() - $results->currentPage()) - 1;
                }
            @endphp
            @if ($from < $i && $i < $to)
                <li class="{{ ($results->currentPage() == $i) ? 'active' : '' }}">
                    <a href="{{ $results->url($i) }}">{{ $i }}</a>
                </li>
            @endif
        @endfor
        <li class="last {{ ($results->currentPage() == $results->lastPage()) ? 'disabled' : '' }} pull-right">
            <a href="{{ $results->url($results->lastPage()) }}">>></a>
        </li>
        <li class="next {{ ($results->currentPage() == $results->lastPage()) ? 'disabled' : '' }} pull-right">
            @if ($results->currentPage() + 1 >= $results->lastPage())
                <a href="{{ $results->url($results->lastPage()) }}">></a>
            @else
                <a href="{{ $results->url($results->currentPage() + 1) }}">></a>
            @endif
        </li>
    </ul>
@endif
