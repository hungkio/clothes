<div class="list-icons">
    @can('designs.update')
        @if($design->status == 1)
            <a href="javascript:void(0)" data-url="{{ route('admin.designs.updateStatus', $design) }}"
               class="item-action updateStatus btn-success" title="{{ __('Xóa') }}">Duyệt</a>
        @endif
        <a href="{{ route('admin.designs.edit', $design) }}" class="item-action btn-primary" title="{{ __('Chỉnh sửa') }}"><i
                class="fal fa-pencil-alt"></i></a>
    @endcan
    @can('designs.delete')
        <a href="javascript:void(0)" data-url="{{ route('admin.designs.destroy', $design) }}"
           class="item-action js-delete btn-danger" title="{{ __('Xóa') }}"><i class="fal fa-trash-alt"></i></a>
    @endcan

</div>
