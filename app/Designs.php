<?php

namespace App;

use App\Domain\Admin\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Designs extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['name', 'progress', 'duration', 'status', 'staff_id'];
    public $guarded = [];
    const PROGRESS = [
        1 => 'Thiết kế',
        2 => 'Cắt dọc',
    ];
    const STATUS = [
        1 => "Chưa duyệt",
        2 => "Đã duyệt",
    ];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('image')
            ->singleFile()
            ->useFallbackUrl('/backend/global_assets/images/placeholders/placeholder.jpg');
        $this
            ->addMediaCollection('file')
            ->singleFile()
            ->useFallbackUrl('/backend/global_assets/images/placeholders/placeholder.jpg');
    }

    public function user()
    {
        return $this->belongsTo(Admin::class, 'staff_id');
    }
}
