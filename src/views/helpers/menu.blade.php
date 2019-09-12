<!--Шаблон для вывода меню с использованием рекурсии-->

@foreach($items as $item)
    <!--Добавляем класс active для активного пункта меню-->
    <li class="{{ ($item['active']) ? 'active' : '' }} {{count($item['children'])?'treeview':''}}">
        <a href="{{ count($item['children'])?'#':$item['item']->path }}" {{ $item['item']->target?'target="'.$item['item']->target.'"':'' }} >
        
        @if($item['item']->icon)
        <i class="{{ $item['item']->icon }}"></i>
        @endif

        <span>{{ $item['item']->title }}</span>
        @if(count($item['children']))
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        @endif
        </a>
        <!--Формируем дочерние пункты меню-->
        @if(count($item['children']))
            <ul class="treeview-menu">
                @include('control::helpers.menu', ['items'=>$item['children']])
            </ul>
        @endif
    </li>
@endforeach