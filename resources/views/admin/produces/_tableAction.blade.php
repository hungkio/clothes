<div class="list-icons">
    @can('produces.update')
        <a href="{{ route('admin.produces.edit', $id) }}" class="item-action btn-primary" title="{{ __('Chỉnh sửa') }}"><i
                class="fal fa-pencil-alt"></i></a>
    @endcan
    @can('produces.delete')
        <a href="javascript:void(0)" data-url="{{ route('admin.produces.destroy', $id) }}"
           class="item-action js-delete btn-danger" title="{{ __('Xóa') }}"><i class="fal fa-trash-alt"></i></a>
    @endcan

</div>
