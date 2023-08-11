<x-validation-errors class="m-4" />
<form>
    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <x-label for="description" value="Title" />
        <x-input type="text" class="mb-4 w-full" name="title" id="title" placeholder="My awesome Project" wire:model="title" required />
        <x-label for="description" value="Description" />
        <div class="max-w-3xl">
            <div class="bg-white rounded-lg p-5">

                <div class="flex flex-col space-y-10">
                    <div wire:ignore>
                        <textarea wire:model="description"
                                  wire:ignore.self
                                  class="min-h-fit h-48 "
                                  name="description"
                                  id="description">
                        </textarea>
                    </div>

                </div>

            </div>
        </div>
        <x-label for="image" value="Image" />
        <x-input type="file" class="block w-full text-sm text-slate-500
              file:mr-4 file:py-2 file:px-4
              file:rounded-full file:border-0
              file:text-md file:font-semibold
              file:bg-violet-50 file:text-violet-700
              hover:file:bg-violet-100
            " name="image" id="image" wire:model="image" accept="image/*"
        />

        <div wire:loading wire:target="image" wire:key="image"> Uploading ...</div>


        @if ($image)
            <img src="{{ is_string($image) ? asset('images/projects').'/'.$image : $image->temporaryUrl() }}" alt=""  class="w-20">
        @endif


        <x-label for="is_public" value="Is Public ?"  />
        <x-checkbox wire:model="is_public" id="is_public" name="is_public"/>
    </div>
    <div class="ml-6 mb-4">

        @if ($project_id)
            <x-button wire:click.prevent="update()" type="button" class="mr-2">Update</x-button>
        @else
            <x-button wire:click.prevent="store()" type="button" class="mr-2">Save</x-button>
        @endif
        <x-secondary-button wire:click="closeModal()" type="button">Cancel</x-secondary-button>
    </div>
</form>


@push('scripts')

    <script>
        let editorInstance;
        createEditor();
        window.addEventListener('editProject', (e) => {
            editorInstance.setData(e.detail.description)
        });
        window.addEventListener('createCKEditor', event => {
            //document.querySelector('.ck-editor__editable').ckeditorInstance.destroy()
            createEditor()
        })
        function createEditor () {
            if (nockEditorsOpen()) {
                ClassicEditor
                    .create(document.querySelector('#description'))
                    .then(editor => {
                        editorInstance = editor
                        editor.model.document.on('change:data', () => {
                        @this.set('description', editor.getData())
                        })
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        }
        function nockEditorsOpen() {
            var ckEditors = document.querySelectorAll(".ck-editor")
            for (var i = 0; i < ckEditors.length; i++) {
                var computedStyle = getComputedStyle(ckEditors[i])
                if (computedStyle.display !== "none") {
                    return false
                }
            }
            return true
        }

    </script>



@endpush
