<?php
$data  = $args['data'];
$items = $data['items'] ?? [];
$count = count($items);

// Alle etwa gleich gross, leicht unterschiedlich gedreht und versetzt
$widths    = [15, 14, 15.5, 14.5, 15, 14, 15.5, 14.5];
$rotations = [-7, 5, -3, 8, -6, 4, -9, 6];
$jitterX   = [0, 1.5, -1, 2, -1.5, 1, -2, 0.5];
$jitterY   = [1, -1, 2, 0, -1.5, 1.5, 0, -1];

// Abstand zwischen den Polaroids: etwas kleiner als ihre Breite, damit sie sich leicht überlappen.
// Bei vielen Bildern rücken sie enger zusammen, damit der Haufen nicht breiter als die Seite wird.
$step  = $count > 1 ? min(11.5, 64 / ($count - 1)) : 0;
$lower = 12;  // wie viel tiefer jedes zweite Polaroid liegt

$layout = [];
$height = 0;
foreach ($items as $i => $item) {
    $w = $widths[$i % 8];
    $y = ($i % 2 ? $lower : 0) + $jitterY[$i % 8] + 2;
    $layout[$i] = [
            'dx' => round(($i - ($count - 1) / 2) * $step + $jitterX[$i % 8], 1),   // Abstand zur Mitte
            'y'  => $y,
            'w'  => $w,
            'r'  => $rotations[$i % 8],
    ];
    $height = max($height, $y + $w * 1.22);
}
$height = round($height + 3, 1);
?>

<section data-module="hobbies">
    <h2 class="module-title"><?= esc_html($data['title']) ?></h2>

    <?php if ($count): ?>
        <div class="collage" style="--h: <?= $height ?>;">
            <?php foreach ($items as $i => $item): $l = $layout[$i]; ?>
                <button class="polaroid" type="button" aria-pressed="false"
                        aria-label="<?= esc_attr($item['label']) ?>, umdrehen"
                        style="--dx: <?= $l['dx'] ?>; --y: <?= $l['y'] ?>; --w: <?= $l['w'] ?>; --r: <?= $l['r'] ?>deg;">
                    <span class="polaroid-inner">
                        <span class="polaroid-front">
                            <?php if (!empty($item['image'])): ?>
                                <img src="<?= $item['image']['src'] ?>" alt="<?= esc_attr($item['image']['alt']) ?>" loading="lazy" decoding="async" draggable="false">
                            <?php endif; ?>
                            <span class="polaroid-label"><?= esc_html($item['label']) ?></span>
                        </span>
                        <span class="polaroid-back">
                            <span class="polaroid-back-label"><?= esc_html($item['label']) ?></span>
                            <?php if (!empty($item['note'])): ?>
                                <span class="polaroid-note"><?= esc_html($item['note']) ?></span>
                            <?php endif; ?>
                        </span>
                    </span>
                </button>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>