<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Structures') }}
        </h2>
    </x-slot>

    <x-alert />
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container mt-3">
                <a href="{{ route('troubleshoots.create') }}" style="margin-bottom: 20px" class="btn btn-primary">+ Create Troubleshoot</a>

                @foreach ($troubleshoots as $tb)
                    <table class="table table-striped" style="margin-bottom: 45px;">
                        <thead>
                            <tr>
                                <th scope="col">
                                    @livewire('edit-troubleshoot',['troubleshootId'=>$tb->id])
                                </th>
                                <th scope="col">
                                    <div class="btn-group">
                                    <form method="GET" action="{{ route('troubleshootstructures.create') }}">
                                        @csrf
                                        <input type="hidden" value="{{ $tb->id }}" name="troubleshoot">
                                        <button type="submit" class="btn btn-outline-success">Add Structure</button>
                                    </form>
                                    <a style="margin-left: 5px" href="{{ route('troubleshoot.delete',$tb->id) }}" class="btn btn-outline-danger">Delete</a>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="sortable-list" id="sortable-{{ $tb->id }}">
                            @foreach ($tb->troubleshoot_structures as $structure)
                                <tr class="sortable-item" data-id="{{ $structure->id }}">
                                    <td colspan=""><a href="{{ route('troubleshootstructures.show',$structure->id) }}">{{ $structure->name }}</a></td>
                                    <td colspan="">
                                        <a href="{{ route('troubleshootstructuresdesc.edit',$structure->id) }}"><span class="material-symbols-outlined">edit</span></a>
                                        <a href="{{ route('troubleshootStructure.delete',$structure->id) }}"><span class="material-symbols-outlined">delete</span></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <script>
                        // Initialize Sortable for each list
                        new Sortable(document.getElementById('sortable-{{ $tb->id }}'), {
                            group: 'shared', // set both lists to the same group
                            animation: 150,
                            onEnd: function (evt) {
                                // Handle the event when the item is dropped
                                var structureId = evt.item.getAttribute('data-id');
                                var newPosition = evt.newIndex;

                                // Perform an AJAX request to update the order in the backend
                                // You may need to define a route and controller method to handle this update
                                // Example using jQuery for simplicity, you may use Axios or Fetch API
                                $.ajax({
                                    // url: '/update-structure-order/' + structureId,
                                    url: '{{ route('update-structure-order', ['structure' => '__structureId__']) }}'.replace('__structureId__', structureId),
                                    method: 'POST',
                                    data: { newPosition: newPosition, _token: '{{ csrf_token() }}' },
                                    success: function (response) {
                                        // Handle the success response if needed
                                        console.log(response.message);
                                    },
                                    error: function (xhr, status, error) {
                                        // Handle the error if needed
                                        console.error('Error updating structure order:', error);
                                    }
                                });
                            }
                        });
                    </script>
                @endforeach
                {{ $troubleshoots->withQueryString()->links() }}
            </div>
        </div>
    </div>

</x-app-layout>

