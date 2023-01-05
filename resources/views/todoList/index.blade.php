<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>To do List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.1/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a23e6feb03.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
    <section class="vh-100" style="background-color: #eee;">
        <div class="container py-5 h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9 col-xl-7">
              <div class="card rounded-3">
                <div class="card-body p-4">
      
                  <div class="text-gray-600">
                    <p class="font-medium text-lg">To Do App</p>
                  </div>
      
                  <form action="{{ route('todolist.store') }}" method="POST" class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2">
                    @csrf
                    <div class="col-12">
                      <div class="form-outline">
                        <input type="text" id="content" name="content"  class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" placeholder="Enter your task here"/>
                      </div>
                    </div>
                    <div class="col-12">
                      <button type="submit" class="btn btn-outline-dark">Save</button>
                    </div>
      
                    {{--<div class="col-12">
                      <button type="submit" class="btn btn-warning">Get tasks</button>
                    </div>--}}
                  </form>
      
                  <table class="table mb-4">
                    <thead>
                      <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Todo item</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($todoLists as $todoList)
                        <tr>
                          <td> {{ $todoList->id }} </td>
                          <td> {{ $todoList->content }} </td>
                          <td> {{ $todoList->status }} </td>
                          <td>
                            <div class="inline-flex">
                              <form action="{{ route('todolist.destroy', $todoList->id) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-r">Delete</button>
                              </form>
                              <form action="{{ route('todolist.update', $todoList->id) }}" method="POST">
                                @csrf
                                @method('put')
                                <button type="submit" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-r">Finished</button>
                              </form>
                            </div>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
</body>
</html>