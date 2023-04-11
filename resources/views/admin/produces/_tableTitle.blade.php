<div class="d-flex align-items-center">
    <div class="mr-3">
        <a href="" target="_blank">
            <img src="{{ $produce->getFirstMediaUrl('image') }}" class="rounded-circle" width="50" height="50" alt="">
        </a>
    </div>
    <div>
        <a href="" data-toggle="tooltip" data-html="true"  title="{{ $produce->name }}" class="text-default font-weight-semibold" target="_blank">{{ \Str::limit($produce->name, 20) }}</a>
    </div>
</div>
