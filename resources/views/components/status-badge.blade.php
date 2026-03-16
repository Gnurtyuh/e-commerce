@props(['status'])

@php
    $color = 'secondary';
    $s = strtolower($status);
    
    if (in_array($s, ['active', 'delivered', 'shipped', 'paid', 'success', 'completed'])) {
        $color = 'success';
    } elseif (in_array($s, ['pending', 'processing'])) {
        $color = 'warning';
    } elseif (in_array($s, ['cancelled', 'failed', 'inactive'])) {
        $color = 'danger';
    } elseif (in_array($s, ['admin'])) {
        $color = 'info';
    } elseif (in_array($s, ['user'])) {
        $color = 'primary';
    }
@endphp

<span class="badge badge-status badge-{{ $color }}">{{ ucfirst($status) }}</span>
