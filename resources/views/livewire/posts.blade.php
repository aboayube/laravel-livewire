<div>
    <div class="flex item-center justify-end  py-4 text-right ">
        
    <x-jet-button wire:click="showCreateModel">
        {{__("Create post")}}
    </x-jet-button></div>
    <table class="w-full divide-y divide-gray-200">
        <thead>
<tr>
    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-blue-500 tracking-wider">id</th>
    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-blue-500 tracking-wider">image</th>
    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-blue-500 tracking-wider">title</th>
    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-blue-500 tracking-wider">action</th>
</tr>
        </thead>
        <tbody class="bg-white divde-y divide-gray-200">
            @forelse ($posts as $post)
                
<tr>
    <td class="px-6 py-3 border-b border-gray-200">{{$post->id}}</td>
    <td class="px-6 py-3 border-b border-gray-200"><img width="80px" height="80" src="{{asset('images/'.$post->image)}}" alt="{{$post->title}}"></td>
    <td class="px-6 py-3 border-b border-gray-200"><a href="{{route('showpost',$post->slug)}}" class="text-indigo-600 hover:text-indigo-900">{{$post->title}}</a></td>
    <td class="px-6 py-3 border-b border-gray-200">
            <x-jet-button class="mr-1" wire:click="showUpdateModal({{$post->id}})"> 
                {{__("edit ")}}
            </x-jet-button>
                <x-jet-danger-button wire:click="showDeleteModal({{$post->id}})">
                    {{__("delete")}}
                </x-jet-button>


    </td>
</tr>
@empty
<tr>
    <td class="px-6 py-3 border-b border-gray-200"  colspan="4">no post found</td>
</tr>
@endforelse

        </tbody>
    </table><div class="pt-4">
        {{$posts->links()}}
    </div>
    <x-jet-dialog-modal wire:model="modalForVisable">
<x-slot name="title">
{{$modalId ? __("update Post"):__("Create Post")}} 
</x-slot>
<x-slot name="content">
    <div class="mt-4 ">
<x-jet-label for="title" value="{{__('Title')}}"></x-jet-label>
<x-jet-input id="title" type="text" wire:model.debounce.500ms="title" class="block mt-1 w-full"></x-jet-input>
@error('title')
    <span class="text-red-900 text-sm font-extrabold">{{$message}}</span>
@enderror
    </div>
    <div class="mt-4 ">
        <x-jet-label for="slug" value="{{__('Slug')}}"></x-jet-label>
       <div class="mt-1 flex rounded-md shadow-sm">
<span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
    {{config('app.url').'/'}}
</span>
<input id="slug" type="text" wire:model="slug_url" class="block  w-full form-input flex-1 rounded-none rounded-r-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="url slug">
   </div>
        @error('slug')
            <span class="text-red-900 text-xl">{{$message}}</span>
        @enderror
            </div>

<div class="mt-4">
    <x-jet-label for="body">{{__('body')}}</x-jet-label>
  
<div wire:ignore wire:key="myId"> 
    <div id="body" class="block mt-1 w-full">
{!! $body !!}
   </div>
</div>
<!--wire:model.debounce.2000ms يعني سوي تاخير في عملية-->
    <textarea id="body" class="hidden body-content" wire:model.debounce.2000ms="body">
        {!!$body!!}
    </textarea>
    @error('body')
    <span class="text-red-900 text-sm font-extrabold">{{$message}}</span>  
    @enderror
</div>
<div class="mt-4 ">
    <x-jet-label for="image" value="{{__('Image')}}"></x-jet-label>
<div class="flex py-3">

    @if($image)
    <div class="mt-1 flex rounded-md shadow-sm">
        <span class="inline-flex items-center p-3 rounded border border-gray-300 bg-gray-50 text-gray-500 text-sm">
            <img src="{{asset('images/'.$image)}}" width="100" height="100" >
        </span>
    </div>
    
    @endif  
@if($post_image)
<div class="mt-1 flex rounded-md shadow-sm">
    <span class="inline-flex items-center p-3 rounded border border-gray-300 bg-gray-50 text-gray-500 text-sm">
        <img src="{{$post_image->temporaryurl()}}" width="100" height="100" >
    </span>
</div>

@endif
</div>
    <input  type="file" wire:model="post_image" class="block  w-full form-input flex-1 rounded-none rounded-r-md transition duration-150 ease-in-out sm:text-sm sm:leading-5">
    @error('image')
        <span class="text-red-900 text-sm font-extrabold">{{$message}}</span>
    @enderror
        </div>


    </x-slot>
    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('modalForVisable')">{{__("Cansle")}}</x-jet-button>  
            @if($modalId)
     <x-jet-button class="ml-2" wire:click="update">{{__("Updte Post")}}</x-jet-button>   
     @else
     <x-jet-button class="ml-2" wire:click="store">{{__("Create Post")}}</x-jet-button>   

     @endif
        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model="confirmPostDeletion">

        <x-slot name="title">
            {{ __('Delete post') }}
        </x-slot>

        <x-slot name="content">

            {{ __('Are you sure you want to delete this post?') }}

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmPostDeletion')">{{ __('Cancel') }}</x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="destroy">{{ __('Delete post') }}</x-jet-danger-button>

        </x-slot>

    </x-jet-dialog-modal>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
<script>
    window.onload = function () {
            if (document.querySelector('#body')) {
                ClassicEditor.create(document.querySelector('#body'), {})
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        document.querySelector('#body').value = editor.getData();
                        @this.set('body', document.querySelector('#body').value);
                    });
                    Livewire.on('createNewPostEmit', function () {
                        editor.setData('')
                    });
                    Livewire.on('updatePostEmit', function () {
                        editor.setData(document.querySelector('.body-content').value)
                    });
                })
                .catch(error => {
                    console.log(error.stack);
                });
            }
        }
    </script>
@endpush