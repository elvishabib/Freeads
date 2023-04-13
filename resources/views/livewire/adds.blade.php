<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    <div class="mt-8 text-2xl">
       <div>Welcome to ADS management</div> 
        <div class="mt-8 text-2xl flex justify-between">
            <div>Items</div> 
            <div class="mr-2">
                <x-jet-button wire:click="confirmAdsAdd" class="bg-blue-500 hover:bg-blue-700">
                    Add New Ads
                </x-jet-button>
            </div>
        </div>
    
    </div>
    
    {{$query}}
    <div class="mt-6">
        <div classe="flex justify-between">
            <div class="p-2">
                <input wire:model.debounce.500ms="q" type="search" placeholder="search" class="shadow appearance-none border rounded  py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                
            </div>
            
            

           
        </div>
        <table class="table-auto-w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('id')">ID</button>
                            <x-sort-icon sortField="id" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('category')">CATEGORY</button>
                            <x-sort-icon sortField="category" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('title')">TITLE</button>
                            <x-sort-icon sortField="title" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            IMAGE

                        </div>
                    </th>

                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            DESCRIPTION

                        </div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('price')">PRICE</button>
                            <x-sort-icon sortField="price" :sort-by="$sortBy" :sort-asc="$sortAsc" />

                        </div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('location')">LOCATION</button>
                            <x-sort-icon sortField="location" :sort-by="$sortBy" :sort-asc="$sortAsc" />

                        </div>
                    </th>
                   
                    <th class="px-4 py-2">
                        <div class="flex items-center">ACTION</div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($adds as $ads)
                    
                    <tr>
                        <td class="border px-4 py-2">{{ $ads->id }}</td>
                        <td class="border px-4 py-2">{{ $ads->category}}</td>

                        <td class="border px-4 py-2">{{ $ads->title }}</td>
                        <td class="border px-4 py-2">  <img src="{{ $ads->main_image }}" style="width: 50%;"></td>

                        <td class="border px-4 py-2">{{ $ads->description }}</td>
                        <td class="border px-4 py-2">{{ $ads->price }}</td>
                        <td class="border px-4 py-2">{{ $ads->location }}</td>

                        
                     

                        
                        <td class="border px-4 py-2">
                            <x-jet-button wire:click="confirmAdsEdit( {{ $ads->id}})" class="bg-orange-500 hover:bg-orange-700">
                                Edit
                            </x-jet-button>
                            <x-jet-button wire:click="confirmAdsEdit( {{ $ads->id}})" class="bg-green-500 hover:bg-green-700">
                                view
                            </x-jet-button>
                                <x-jet-danger-button wire:click="confirmAdsDeletion( {{ $ads->id}})" wire:loading.attr="disabled">
                                    Delete
                                </x-jet-danger-button>
                            </td>
                        </td>
                    </tr>

                    
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $adds->links() }}
    </div>
    <x-jet-confirmation-modal wire:model="confirmingAdsDeletion">
        <x-slot name="title">
            {{ __('Delete Ads') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete Ads? ') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingAdsDeletion', false)" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deleteAds({{ $confirmingAdsDeletion }})" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
    <x-jet-dialog-modal wire:model="confirmingAdsAdd">
        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="title" value="{{ __('Title') }}" />
                <x-jet-input id="title" type="text" class="mt-1 block w-full" wire:model.defer="ads.title" />
                <x-jet-input-error for="ads.title" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="category" value="{{ __('Category') }}" />
                <x-jet-input id="category" type="text" class="mt-1 block w-full" wire:model.defer="ads.category" />
                <x-jet-input-error for="category" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4 mt-4">
                <x-jet-label for="description" value="{{ __('Description') }}" />
                <x-jet-input id="description" type="text" class="mt-1 block w-full" wire:model.defer="ads.description" />
                <x-jet-input-error for="ads.description" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4 mt-4">
                <x-jet-label for="location" value="{{ __('location') }}" />
                <x-jet-input id="location" type="text" class="mt-1 block w-full" wire:model.defer="ads.location" />
                <x-jet-input-error for="ads.location" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4 mt-4">
                <x-jet-label for="main_image" value="{{ __('Main Image') }}" />
                <x-jet-input id="Image" type="file" class="mt-1 block w-full"  wire:model="ads.main_image"/>
                <x-jet-input-error for="ads.main_image" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4 mt-4">
                <x-jet-label for="images" value="{{ __('Other images') }}" />
                <x-jet-input id="images" type="file" class="mt-1 block w-full"  wire:model="images" multiple/>
                <x-jet-input-error for="images" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4 mt-4">
                <x-jet-label for="price" value="{{ __('Price') }}" />
                <x-jet-input id="price" type="text" class="mt-1 block w-full" wire:model.defer="ads.price" />
                <x-jet-input-error for="ads.price" class="mt-2" />
            </div>
            


          
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingAdsAdd', false)" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="saveAds()" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>



</div>
