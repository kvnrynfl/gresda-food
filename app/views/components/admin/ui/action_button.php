<?php
/**
 * Generic Admin Action Button Component (Usually inside tables)
 * 
 * Variables:
 * - $type: (string) 'a' for link, 'button' for submit/js action
 * - $href: (string) The URL if $type is 'a'
 * - $color: (string) The base color namespace ('blue', 'cyan', 'red', 'green', 'yellow', 'gray', 'indigo')
 * - $icon: (string) FontAwesome class (e.g., 'fas fa-edit')
 * - $title: (string) HTML title attribute for tooltips
 */

$type = $type ?? 'a';
$href = $href ?? '#';
$color = $color ?? 'indigo';
$icon = $icon ?? 'fas fa-cog';
$btn_title = $btn_title ?? '';

// Ultra refined action button color mappings
$colorMap = [
    'indigo'  => 'bg-indigo-50 text-indigo-600 hover:bg-indigo-600 ring-indigo-500/10 hover:shadow-indigo-500/30',
    'blue'    => 'bg-blue-50 text-blue-600 hover:bg-blue-600 ring-blue-500/10 hover:shadow-blue-500/30',
    'cyan'    => 'bg-cyan-50 text-cyan-600 hover:bg-cyan-600 ring-cyan-500/10 hover:shadow-cyan-500/30',
    'red'     => 'bg-rose-50 text-rose-600 hover:bg-rose-600 ring-rose-500/10 hover:shadow-rose-500/30',
    'green'   => 'bg-emerald-50 text-emerald-600 hover:bg-emerald-600 ring-emerald-500/10 hover:shadow-emerald-500/30',
    'emerald' => 'bg-emerald-50 text-emerald-600 hover:bg-emerald-600 ring-emerald-500/10 hover:shadow-emerald-500/30',
    'amber'   => 'bg-amber-50 text-amber-600 hover:bg-amber-500 ring-amber-500/10 hover:shadow-amber-500/30',
    'yellow'  => 'bg-amber-50 text-amber-600 hover:bg-amber-500 ring-amber-500/10 hover:shadow-amber-500/30',
    'gray'    => 'bg-slate-100 text-slate-600 hover:bg-slate-700 ring-slate-500/10 hover:shadow-slate-500/30'
];

$c = $colorMap[$color] ?? $colorMap['indigo'];

$btn_label = $btn_label ?? '';

$baseClasses = "rounded-xl inline-flex flex-shrink-0 items-center justify-center transition-all duration-300 ease-[cubic-bezier(0.34,1.56,0.64,1)] hover:text-white hover:-translate-y-0.5 hover:shadow-lg ring-1 ring-inset $c";

if (!empty($btn_label)) {
    // Label mode: wider padding, text size
    $finalClass = trim("px-4 py-2 $baseClasses");
} else {
    // Icon-only mode: rigid square
    $finalClass = trim("w-9 h-9 hover:scale-110 hover:-translate-y-0 text-center $baseClasses");
}
// Add explicit width control if provided
$finalClass .= isset($btn_width) ? " $btn_width" : "";
?>

<?php if ($type === 'a'): ?>
    <a href="<?= htmlspecialchars($href) ?>" class="<?= $finalClass ?>" title="<?= htmlspecialchars($btn_title) ?>" <?= $extra_attr ?? '' ?>>
        <i class="<?= htmlspecialchars($icon) ?> <?= !empty($btn_label) ? 'text-[12px] mr-1.5' : 'text-[14px]' ?>"></i>
        <?php if (!empty($btn_label)): ?>
            <span class="font-bold whitespace-nowrap text-[12px] lg:text-[13px]"><?= htmlspecialchars($btn_label) ?></span>
        <?php endif; ?>
    </a>
<?php else: ?>
    <!-- For form submits, this must be wrapped inside the <form> tags externally -->
    <button type="<?= htmlspecialchars($type) ?>" class="<?= $finalClass ?>" title="<?= htmlspecialchars($btn_title) ?>" <?= $extra_attr ?? '' ?>>
        <i class="<?= htmlspecialchars($icon) ?> <?= !empty($btn_label) ? 'text-[12px] mr-1.5' : 'text-[14px]' ?>"></i>
        <?php if (!empty($btn_label)): ?>
            <span class="font-bold whitespace-nowrap text-[12px] lg:text-[13px]"><?= htmlspecialchars($btn_label) ?></span>
        <?php endif; ?>
    </button>
<?php endif; ?>
