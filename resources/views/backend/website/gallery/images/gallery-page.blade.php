@extends('backend.layout')

@section('title')
Gallery: {{ $category->category_name }} | {{ config('app.name') }}
@endsection

<style>
   .alertify .dialog{
    top: 30% !important;
   }
   .dropzone .dz-preview .dz-image img{
    height: 120px;
    width:120px;
    object-fit: cover;
    }


</style>
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-lg-12 mt-3">
            <div class="card m-b-30">
                <div class="card-header card-header-color">
                    {{ $category->category_name }}
                </div>
                <div class="card-body">
                    <p class="sub-title">{{ $category->category_name }} images</p>

                    <div class="m-b-30">
                        <form action="{{ route('website.gallery.images.store', $category->id) }}" class="dropzone" id="dropzone" method="POST">
                            @csrf
                            <div class="fallback">
                                <input name="file" type="file" multiple="multiple">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
Dropzone.options.dropzone =
         {
	        maxFiles: null,
            maxFilesize: 4,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 50000,
            init:function() {

				// Get images
				var myDropzone = this;
                let catId = @json($category->id);
                let url = '{{ route('website.gallery.images.getImages', ':id') }}';
                url = url.replace(':id', catId);
				$.ajax({
					url: url,
					type: 'GET',
					dataType: 'json',
                    error: function(err){
                        console.log(err);
                    },
					success: function(data){
                        $.each(data, function (key, value) {
                            var file = {name: value.name, size: value.size};
                            myDropzone.options.addedfile.call(myDropzone, file);
                            myDropzone.options.thumbnail.call(myDropzone, file, value.path);
                            myDropzone.emit("complete", file);
                        });
					}
				});
			},
            removedfile: function(file)
            {
				if (this.options.dictRemoveFile) {

                alertify.confirm("Are you sure to "+this.options.dictRemoveFile, function (ev) {
                    ev.preventDefault();

                    if(file.previewElement.id != ""){
						var name = file.previewElement.id;
					}else{
						var name = file.name;
					}
					//console.log(name);
					$.ajax({
						headers: {
							  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							  },
						type: 'POST',
						url: '{{ route('website.gallery.images.destroy') }}',
						data: {
                            filename: name,
                            _token: '{{ csrf_token() }}'
                        },
						success: function (data){
							alertify.success(data.success +" File has been successfully removed!")
						},
						error: function(e) {
							console.log(e);
						}});
						var fileRef;
						return (fileRef = file.previewElement) != null ?
						fileRef.parentNode.removeChild(file.previewElement) : void 0;

                }, function(ev) {
                    ev.preventDefault();
                    return '';
                });
            }
            },

            success: function(file, response)
            {
				file.previewElement.id = response.success;
				//console.log(file);
				// set new images names in dropzone’s preview box.
                var olddatadzname = file.previewElement.querySelector("[data-dz-name]");
				file.previewElement.querySelector("img").alt = response.success;
				olddatadzname.innerHTML = response.success;
            },
            error: function(file, response)
            {
               if($.type(response) === "string")
					var message = response; //dropzone sends it's own error messages in string
				else
					var message = response.message;
				file.previewElement.classList.add("dz-error");
				_ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
				_results = [];
				for (_i = 0, _len = _ref.length; _i < _len; _i++) {
					node = _ref[_i];
					_results.push(node.textContent = message);
				}
				return _results;
            }

};    </script>
@endpush
