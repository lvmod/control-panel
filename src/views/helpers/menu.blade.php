<!--Шаблон для вывода меню с использованием рекурсии-->

@foreach($items as $item)
{{var_dump($item['active'])}}
    <!--Добавляем класс active для активного пункта меню-->
    <li class="{{ ('/'.Request::path() == $item['item']->path) ? 'active' : '' }} {{count($item['children'])?'treeview':''}}">
        <!-- метод url() получает ссылку на пункт меню (указана вторым параметром
        при создании объекта LavMenu)-->
        <a href="{{ count($item['children'])?'#':$item['item']->path }}" {{ $item['item']->target?'target="'.$item['item']->target.'"':'' }} >
        
        @if($item['item']->icon)
        <i class="{{ $item['item']->icon }}"></i>
        @endif

        {{ $item['item']->title }}
        @if(count($item['children']))
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        @endif
        </a>
        <!--Формируем дочерние пункты меню
        метод haschildren() проверяет наличие дочерних пунктов меню-->
        @if(count($item['children']))
        
            <ul class="treeview-menu">
                <!--метод children() возвращает дочерние пункты меню для текущего пункта-->
                @include('control::helpers.menu', ['items'=>$item['children']])
            </ul>
        @endif
    </li>
@endforeach