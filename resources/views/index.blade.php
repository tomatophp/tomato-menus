<x-tomato-admin-layout>
    <x-slot name="header">
        {{ __('Menus') }}
    </x-slot>

    <div class="mb-4">
        <div class="relative text-center mb-6">
            <div class="flex items-center justify-center">
                <div
                    class="border w-full border-gray-300 p-6 bg-white filament-tables-empty-state dark:bg-gray-800 rounded-lg shadow-sm">
                    <x-splade-form method="GET" action="{{route('admin.menus.index')}}" :default="[
                        'menu_id' => $menu ? $menu->id : null
                    ]">
                        <div class="flex justify-start gap-4 w-full">
                            <div class="flex flex-col justify-center">
                                <label for="menu_id">{{__('Select a menu to edit:')}}</label>
                            </div>
                            <x-splade-select choices id="menu_id"  name="menu_id">
                                <option value="">{{__('Select Menu')}}</option>
                                @foreach($menus as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </x-splade-select>
                            <x-tomato-admin-submit :label="__('Apply')" spinner />
                            <div class="flex flex-col justify-center mx-2">
                                <div>
                                    {{__('or')}}
                                    <x-splade-link :href="route('admin.menus.index') . '?create_new=1'" class="text-primary-500">
                                        {{__('create new menu')}}
                                    </x-splade-link>
                                    {{__('Do not forget to save your changes!')}}
                                </div>
                            </div>
                        </div>
                    </x-splade-form>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-3">
                <h1 class="text-lg font-bold mb-4">{{__('Add menu items')}}</h1>
                <div class="border border-gray-300 bg-white w-full">
                    <div class="border-b border-gray-300">
                        <x-splade-toggle>
                            <button :class="{'bg-gray-200 text-gray-600': toggled}" class="border-b border-gray-300 font-bold p-4 w-full text-gray-400 hover:text-gray-600" @click.prevent="toggle">
                                <div class="flex justify-between">
                                    <div>
                                        {{__('Plugins')}}
                                    </div>
                                    <div class="text-right">
                                        <i class="bx " :class="{
                                        'bx-chevron-up': !toggled,
                                        'bx-chevron-down': toggled
                                    }" style="font-size:15px"></i>
                                    </div>
                                </div>
                            </button>

                            <x-splade-transition show="toggled" class="border-b border-gray-300">
                                <x-splade-form method="POST" action="{{$menu ? route('admin.menus.item.pages', [$menu->id]) : null}}">
                                    <div class="p-4 flex flex-col justify-start">
                                        @foreach($pages as $key=>$page)
                                            <x-splade-checkbox :name="$key" :label="$key" />
                                        @endforeach
                                    </div>
                                    <hr>
                                    <div class="p-4 flex justify-end">
                                        <x-tomato-admin-submit :class="(!$menu ? 'bg-gray-300 hover:bg-gray-400 w-full' : 'w-full')" :disabled="!$menu" spinner :label="__('Add To Menu')" />
                                    </div>
                                </x-splade-form>
                            </x-splade-transition>
                        </x-splade-toggle>
                        <x-splade-toggle :data="true">
                            <button :class="{'bg-gray-200 text-gray-600': toggled}" class="font-bold p-4 w-full text-gray-400 hover:text-gray-600" @click.prevent="toggle">
                                <div class="flex justify-between" >
                                    <div>
                                        {{__('Custom Links')}}
                                    </div>
                                    <div class="text-right">
                                        <i class="bx " :class="{
                                        'bx-chevron-up': !toggled,
                                        'bx-chevron-down': toggled
                                    }" style="font-size:15px"></i>
                                    </div>
                                </div>
                            </button>

                            <x-splade-transition show="toggled">
                                <x-splade-form preserve-scroll method="POST" action="{{$menu ? route('admin.menus.item', $menu['id']) : '#'}}">
                                    <div class="flex flex-col space-y-4 justify-start p-4 w-full">
                                        <x-splade-input name="url" label="{{__('URL')}}" placeholder="https://" />
                                        <x-splade-input name="name" label="{{__('Link Text')}}" placeholder="Input your text here" />
                                    </div>
                                    <hr>
                                    <div class="p-4 flex justify-end">
                                        <x-tomato-admin-submit :class="(!$menu ? 'bg-gray-300 hover:bg-gray-300 w-full' : 'w-full')" :disabled="!$menu" spinner :label="__('Add To Menu')" />
                                    </div>
                                </x-splade-form>
                            </x-splade-transition>
                        </x-splade-toggle>
                    </div>
                </div>
            </div>
            <div class="col-span-9 w-full">
                <h1 class="text-lg font-bold mb-4">{{__('Menu structure')}}</h1>
                <x-splade-form :default="$menu ? $menu->toArray() : []" class="bg-white" action="{{$menu ? route('admin.menus.update', [$menu->id]) : route('admin.menus.store') }}" method="POST">
                    <div class="border border-gray-300  w-full">
                        <div class="bg-gray-200 border-b border-gray-300 p-4">
                            <div class="flex justify-start">
                                <div class="flex flex-col justify-center">
                                    <div>
                                        {{__('Menu Name')}}
                                    </div>
                                </div>
                                <div class="mx-4">
                                    <x-splade-input type="text" name="name.{{app()->getLocale()}}" :placeholder="__('Input Your Menu Name')" required />
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="p-4 border-b border-gray-300">
                                @if(count($menusItems))
                                    <x-tomato-admin-draggable  class="flex flex-col  space-y-4" :levels="3" :options="$menusItems->toArray()" url="{{route('admin.menus.item.all', $menu->id)}}" order-by="order">
                                        <x-splade-toggle>
                                            <div class="w-full">
                                                <button :class="{'bg-gray-200 text-gray-600': toggled}" class="cursor-move w-full border border-gray-300 font-bold p-4 text-gray-400 hover:text-gray-600" @click.prevent="toggle">
                                                    <div class="flex justify-between">
                                                        <div class="flex justify-start">
                                                            <div v-if="drag.item.icon" class="flex flex-col justify-center mx-2">
                                                                <i  :class="drag.item.icon"></i>
                                                            </div>
                                                            <span>@{{ drag.item.name ? drag.item.name.@php echo app()->getLocale(); @endphp : null }}</span>
                                                        </div>
                                                        <div class="text-right">
                                                            <i class="bx " :class="{
                                                        'bx-chevron-up': !toggled,
                                                        'bx-chevron-down': toggled
                                                    }" style="font-size:15px"></i>
                                                        </div>
                                                    </div>
                                                </button>

                                                <x-splade-transition show="toggled" class="border-b border-r border-l border-gray-300">
                                                    <x-splade-form default="drag.item" preserve-scroll method="POST" action="{{route('admin.menus.item.update', $menu['id'])}}">
                                                        <div class="flex flex-col space-y-4 justify-start p-4 w-full">
                                                            <x-splade-input name="id" type="hidden"/>
                                                            <x-splade-input name="url" label="{{__('URL')}}" placeholder="https://" />
                                                            <x-splade-input name="name.ar" label="{{__('Link Text [Arabic]')}}" :placeholder="__('Input your text here')" />
                                                            <x-splade-input name="name.en" label="{{__('Link Text [English]')}}" :placeholder="__('Input your text here')" />
                                                            <x-splade-input name="icon" label="{{__('Icon')}}" :placeholder="__('Input your text here')" />
                                                            <x-splade-select name="target" label="{{__('Open On')}}" :placeholder="__('Input your text here')">
                                                                <option value="_self">{{__('Same Page')}}</option>
                                                                <option value="_blank">{{__('New Page')}}</option>
                                                            </x-splade-select>
                                                        </div>
                                                        <hr>
                                                        <div class="p-4 flex justify-between gap-4 text-center">
                                                            <x-tomato-admin-button danger confirm method="DELETE" data="{id: drag.item.id}" href="{{route('admin.menus.item.destroy', [$menu->id])}}">{{__('Delete Link')}}</x-tomato-admin-button>
                                                            <x-tomato-admin-submit :label="__('Update Link')" spinner />
                                                        </div>
                                                    </x-splade-form>
                                                </x-splade-transition>
                                            </div>

                                        </x-splade-toggle>
                                    </x-tomato-admin-draggable>
                                @else
                                    {{__('Give your menu a name, then click Create Menu.')}}
                                @endif
                            </div>
                        </div>
                        <div class="bg-gray-200 border-t border-gray-300 p-4">
                            <div class="flex justify-between">
                                @if($menu)
                                    <x-tomato-admin-button danger :label="__('Delete Menu')" confirm method="DELETE" :href="route('admin.menus.destroy',  [$menu->id])" />
                                @else
                                    <div></div>
                                @endif
                                @if($menu)
                                    <x-tomato-admin-submit :label="__('Save Menu')" spinner />
                                @else
                                    <x-tomato-admin-submit :label="__('Create Menu')" spinner />
                                @endif
                            </div>
                        </div>
                    </div>
                </x-splade-form>
            </div>
        </div>
    </div>

</x-tomato-admin-layout>
