<!--Шаблон для вывода заголовка-->
<section class="content-header">
    <div>
        <h3 class="font-light m-b-xs" style="margin-top: 5px; margin-bottom: 3px;">
            {{$title}}
            <br>
        </h3>
    </div>

    @if(isset($items))
    <ol class="breadcrumb">
        <li><a href="/control"><i class="fa fa-home pr-10"></i> Главная</a></li>
        @foreach($items as $item)
        @if ((count($item['children'])) || $item === end($items))
        <li class="active">{{ $item['item']->title }}</li>
        @else
        <li>
            <a href="{{ $item['item']->path }}">
                {{ $item['item']->title }}
            </a>
        </li>
        @endif
        @endforeach
    </ol>
    @endif
</section>