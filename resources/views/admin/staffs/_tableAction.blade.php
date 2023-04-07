<div class="list-icons">
    @can('staffs.update')
        <a href="{{ route('admin.staffs.edit', $id) }}" class="item-action btn-primary" title="{{ __('Chỉnh sửa') }}"><i
                class="fal fa-pencil-alt"></i></a>
    @endcan
    @can('staffs.delete')
        <a href="javascript:void(0)" data-url="{{ route('admin.staffs.destroy', $id) }}"
           class="item-action js-delete btn-danger" title="{{ __('Xóa') }}"><i class="fal fa-trash-alt"></i></a>
    @endcan

</div>
