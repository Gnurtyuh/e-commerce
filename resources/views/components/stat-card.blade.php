@props(['title', 'value', 'icon', 'color', 'url' => '#'])

<div class="small-box bg-{{ $color }}">
    <div class="inner">
        <h3>{{ is_numeric($value) && $value > 1000 ? number_format($value) : $value }}</h3>
        <p>{{ $title }}</p>
    </div>
    <div class="icon">
        <i class="fas fa-{{ $icon }}"></i>
    </div>
    <a href="{{ $url }}" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
</div>
