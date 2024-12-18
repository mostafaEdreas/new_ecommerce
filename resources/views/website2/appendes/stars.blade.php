<?php $rate_index = 0; ?>
@while($rate_index < 5)
    @if ($rate > $rate_index && $rate < $rate_index + 1)
        <!-- Display half star -->
        <i class="fas fa-star-half-alt"></i>
    @elseif($rate > $rate_index)
        <!-- Display filled star -->
        <i class="fas fa-star"></i>
    @else
        <!-- Display empty star -->
        <i class="fas fa-star" style="color: rgba(0, 0, 0, 0.551);"></i>
    @endif
    <?php $rate_index++; ?>
@endwhile


