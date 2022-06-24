@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="my-3">All Categories</h1>

        <div class="row">
            @include('partials.success')
            <div class="col-4">
                <form action="{{route('admin.categories.store')}}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="name" id="name" class="form-control" placeholder="Add a new category" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                            </svg>
                        </button>
                    </div>
                    
                </form>
            </div>
            <div class="col-12">
                <table class="table table-secondary">
                    <thead class="thead-inverse">
                      <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Posts</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                        <tr>
                            
                            <td>{{$category->id}}</td>
                            <td>
                                <div id="label-update-{{$category->id}}" class="py-2" style="min-width: 350px;">{{$category->name}}</div>
                                <form action="{{route('admin.categories.update', $category->id)}}" method="post" id="cat-update-{{$category->id}}" class="category-update">
                                    @csrf
                                    @method('PATCH')
                                    <input type="text" name="name" id="input-update-{{$category->id}}" value="{{$category->name}}" class="form-control b-none d-none bg-transparent cat-update-{{$category->id}}" placeholder="Add a new category" aria-label="Category name" aria-describedby="button-addon2">
                                </form>
                               
                            </td>
                            <td>{{$category->slug}}</td>
                            <td class="ps-3">
                                <span class="badge badge-info bg-dark">{{count($category->posts)}}</span>
                            </td>
                            <td class="d-flex">

                                <button type="submit"  form="cat_update_{{$category->id}}" onclick="checkInputUpdate(event, {{$category->id}})" class="btn btn-secondary" id="btn-update-{{$category->id}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square pe-none" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg>
                                </button>

                                <form action="{{route('admin.categories.destroy', $category->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                        </svg>
                                    </button>
                                </form>
                            </td>

                        </tr>
                        @empty
                            <td>nothing to show</td>
                            
                        @endforelse
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
@endsection

@section('page_script')
    <script type="text/javascript">
        function checkInputUpdate(event, id) {
            console.log(event.target);

            //let cat_id = event.target.id.replace("btn", "input");
            let input = document.getElementById('input-update-' + id)
            let label = document.getElementById('label-update-' + id)


            input.classList.remove('d-none')
            label.classList.add('d-none')

            console.log(id, input);

            
            

            //console.log(cat_id);

            console.log(input.defaultValue, input.value);

            let form = document.getElementById('cat-update-' + id)
            
            if (input.defaultValue === input.value) {
                input.focus()
                let inputValue = input.value
                input.value = ''
                input.value = inputValue
                //console.log(forms);
                
            }else{
                form.id = form.id.replaceAll('-', '_')
                console.log(form.id);

            }

            /* forms.forEach(form => {
                    form.id = form.id.replace('-', '_')
                    //console.log(form);
            }); */
        }
    </script>
@endsection