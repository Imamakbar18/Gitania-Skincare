@if($order->status == 'completed')
    <!-- Cek apakah user sudah memberikan ulasan -->
    @if(!$order->review)
        <a href="{{ route('user.reviews.create', $order->id) }}" class="btn btn-primary">Beri Ulasan</a>
    @else
        <span class="text-success">✅ Sudah diulas</span>
    @endif
@endif
