<li class="mx-auto">
    <a class="btn btn-primary btn-sm mb-1" onClick="createChild({{$children->id}})">
        <i class="fas fa-plus"></i>
    </a>
    <a class="btn btn-primary btn-sm mb-1" onClick="editChild({{$children->id}})">
        <i class="fas fa-pencil-alt"></i>
    </a>
    <a class="btn btn-danger btn-sm mb-1" onClick="deleteChild({{$children->id}})">
        <i class="fas fa-trash"></i>
    </a>
    <div class="member-view-box" id="children-{{$children->id}}">
        <div class="member-image">
            @if($children->image)
            <div>
                <img src="{{ $children->image }}" class="dialogue-img" />
            </div>
            @else
            <div>
                <h4>narrator</h4>
            </div>
            @endif
            <div class="member-details text-center">
            <strong>{!! $children->displayname !!}</strong>
            
            <p class="mb-0" style="overflow-wrap: break-word;">
                {{ Illuminate\Support\Str::limit($children->dialogue, 20, $end='...') }}
               <br>
            </p>

            </div>
        </div>
    </div>

@if($children->children->count())
<a href="javascript:void(0);">
    <i class="fas fa-sort-down" style="margin-left:1px"></i>
</a>
    <ul class="active">
        @foreach($children->children as $child)
            @include('admin.dialogue._dialogue_children', ['children' => $child])
        @endforeach
    </ul>
@endif
<script>
    function createChild(id) {
        loadModal("{{ url('admin/dialogue/create/child') }}/" + id, 'Create Child');
    }
    function editChild(id) {
        loadModal("{{ url('admin/dialogue/edit/child') }}/" + id, 'Edit Child');
    }
    function deleteChild(id) {
        loadModal("{{ url('admin/dialogue/delete') }}/" + id, 'Delete Child');
    }
</script>
</li>
