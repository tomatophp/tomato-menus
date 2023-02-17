<x-tomato-admin-layout>
    <x-slot name="header">
        {{ __('Menus') }}
    </x-slot>

    <div class="mb-4">
        @if(!count($menus))
            <div class="relative text-center mb-6">
                <div class="flex items-center justify-center">
                    <div
                        class="border border-gray-300 flex flex-col items-center justify-center flex-1 p-6 mx-auto space-y-6 text-center bg-white filament-tables-empty-state dark:bg-gray-800 rounded-lg shadow-sm">

                        <div
                            class="flex items-center justify-center w-16 h-16 rounded-full text-primary-500 bg-primary-50 dark:bg-gray-700">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                 stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>

                        <div class="max-w-md space-y-1">
                            <h2 class="text-xl font-bold tracking-tight filament-tables-empty-state-heading dark:text-white">
                                {{ trans('tomato-admin::global.empty') }}
                            </h2>

                            <p
                                class="text-sm font-medium text-gray-500 whitespace-normal filament-tables-empty-state-description dark:text-gray-400">
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        @else
            <div class="relative text-center mb-6">
                <div class="flex items-center justify-center">
                    <div
                        class="border w-full border-gray-300 p-6 bg-white filament-tables-empty-state dark:bg-gray-800 rounded-lg shadow-sm">
                        <x-splade-form method="GET" action="{{route('admin.menus.index')}}" :default="[
                        'menu_id' => $menu ? $menu->id : null
                    ]">
                            <div class="flex justify-start">
                                <div class="flex flex-col justify-center">
                                    <label for="menu_id">Select a menu to edit:</label>
                                </div>
                                <x-splade-select choices id="menu_id" class="mx-4 w-60" name="menu_id">
                                    <option value="">{{__('Select Menu')}}</option>
                                    @foreach($menus as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </x-splade-select>
                                <x-splade-submit>
                                    Select
                                </x-splade-submit>
                                <div class="flex flex-col justify-center mx-2">
                                    <div>
                                        or
                                        <Link href="{{route('admin.menus.index') ."?create_new=1"}}" class="text-primary-500">
                                        create new menu
                                        </Link>
                                        Do not forget to save your changes!
                                    </div>
                                </div>
                            </div>
                        </x-splade-form>
                    </div>
                </div>
            </div>
        @endif
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
                                        @foreach($pages['dashboard'] as $key=>$page)
                                            <x-splade-checkbox :name="$key" :label="$key" />
                                        @endforeach
                                    </div>
                                    <hr>
                                    <div class="p-4 flex justify-end">
                                        <x-splade-submit :class="(!$menu ? 'bg-gray-300 hover:bg-gray-400 w-full' : 'w-full')" :disabled="!$menu">{{__('Add To Menu')}}</x-splade-submit>
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
                                        <x-splade-submit :class="(!$menu ? 'bg-gray-300 hover:bg-gray-400 w-full' : 'w-full')" :disabled="!$menu">{{__('Add To Menu')}}</x-splade-submit>
                                    </div>
                                </x-splade-form>
                            </x-splade-transition>
                        </x-splade-toggle>
                    </div>
                </div>
            </div>
            <div class="col-span-9 w-full">
                <h1 class="text-lg font-bold mb-4">Menu structure</h1>
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
                                    <x-splade-input type="text" name="name" placeholder="Input Your Menu Name" required />
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="p-4 border-b border-gray-300">
                                @if(count($menusItems))
                                    <x-tomato-draggable  class="flex flex-col  space-y-4" :levels="3" :options="$menusItems->toArray()" url="{{route('admin.menus.item.all', $menu->id)}}" order-by="order">
                                        <x-splade-toggle>
                                            <div class="w-full">
                                                <button :class="{'bg-gray-200 text-gray-600': toggled}" class="cursor-move w-full border border-gray-300 font-bold p-4 text-gray-400 hover:text-gray-600" @click.prevent="toggle">
                                                    <div class="flex justify-between">
                                                        <div class="flex justify-start">
                                                            <div v-if="darg.item.icon" class="flex flex-col justify-center mx-2">
                                                                <i  :class="darg.item.icon"></i>
                                                            </div>
                                                            <span>@{{ darg.item.name ? darg.item.name.@php echo app()->getLocale(); @endphp : null }}</span>
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
                                                    <x-splade-form default="darg.item" preserve-scroll method="POST" action="{{route('admin.menus.item.update', $menu['id'])}}">
                                                        <div class="flex flex-col space-y-4 justify-start p-4 w-full">
                                                            <x-splade-input name="id" type="hidden"/>
                                                            <x-splade-input name="url" label="{{__('URL')}}" placeholder="https://" />
                                                            <x-splade-input name="name.ar" label="{{__('Link Text [Arabic]')}}" placeholder="Input your text here" />
                                                            <x-splade-input name="name.en" label="{{__('Link Text [English]')}}" placeholder="Input your text here" />
                                                            <x-splade-input name="icon" label="{{__('Icon')}}" placeholder="Input your text here" />
                                                            <x-splade-select name="target" label="{{__('Open On')}}" placeholder="Input your text here">
                                                                <option value="_self">{{__('Same Page')}}</option>
                                                                <option value="_blank">{{__('New Page')}}</option>
                                                            </x-splade-select>
                                                        </div>
                                                        <hr>
                                                        <div class="p-4 flex justify-between space-x-2 text-center">
                                                            <x-splade-link confirm method="DELETE" data="{id: darg.item.id}" href="{{route('admin.menus.item.destroy', [$menu->id])}}" class="w-full rounded-md shadow-sm bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 focus:outline-none focus:shadow-outline">{{__('Delete Link')}}</x-splade-link>
                                                            <x-splade-submit class="w-full">{{__('Update Link')}}</x-splade-submit>
                                                        </div>
                                                    </x-splade-form>
                                                </x-splade-transition>
                                            </div>

                                        </x-splade-toggle>
                                    </x-tomato-draggable>
                                @else
                                    Give your menu a name, then click Create Menu.
                                @endif
                            </div>
                            <div class="p-4">
                                <h1 class="text-lg font-bold  my-4">Menu Settings</h1>
                                <div class="flex justify-between">
                                    <div class="w-60">
                                        Auto add pages
                                    </div>
                                    <div class="flex justify-start w-full">
                                        <x-splade-checkbox name="auto_add_pages" label="Automatically add new top-level pages to this menu" />
                                    </div>
                                </div>
                                <div class="flex justify-between my-4">
                                    <div class="w-60">
                                        Display location
                                    </div>
                                    <div class="flex justify-start  w-full">
                                        <div class="flex flex-col justify-center">
                                            @foreach(config('tomato-menus.locations') as $key=>$location)
                                                <x-splade-checkbox :name="'locations.'.$key" :label="$location" />
                                            @endforeach
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="bg-gray-200 border-t border-gray-300 p-4">
                            <div class="flex justify-between">
                                @if($menu)
                                    <x-splade-form confirm method="DELETE" action="{{route('admin.menus.destroy',  [$menu->id])}}">
                                        <x-splade-submit class="bg-red-500 hover:bg-red-600">{{__('Delete Menu')}}</x-splade-submit>
                                    </x-splade-form>
                                @else
                                    <div></div>
                                @endif
                                @if($menu)
                                    <x-splade-submit>{{__('Save Menu')}}</x-splade-submit>
                                @else
                                    <x-splade-submit>{{__('Create Menu')}}</x-splade-submit>
                                @endif
                            </div>
                        </div>
                    </div>
                </x-splade-form>
            </div>
        </div>
    </div>

</x-tomato-admin-layout>
