@if($breadcrumb)
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @foreach($breadcrumb as $item)
                @if($item['href'])
                    <li class="breadcrumb-item"><a href="{{$item['href']}}">{{$item['title']}}</a></li>
                @else
                    <li class="breadcrumb-item active" aria-current="page">{{$item['title']}}</li>
                @endif
            @endforeach
        </ol>
    </nav>
@endif

