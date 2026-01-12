<?php

/**
 * Block Counters
 */
?>

<?php
$settings = get_field("settings");
$data = block_start("counters", $block, $settings);
$id = $data["id"];
$color_schema = $data["color_schema"];
$counters = [];
for ($i = 1; $i <= 4; $i++):
    $counters[] = get_field("counter" . $i);
endfor;
?>


<div class="c-section--counters <?= $color_schema; ?> " id="<?php echo esc_attr($id); ?>">
    <div class="container-fluid">
        <div class="row counters-js" data-decimals="<?= $settings["decimals"] ?>">

            <?php
            foreach ($counters as $i => $counter):
                $alt = ($counter["icon"]["alt"]) ? $counter["icon"]["alt"] : "icon";
            ?>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="counter-tile">

                        <img class="c__icon" src="<?= $counter["icon"]["sizes"]["medium"] ?>" alt="<?= $alt ?>">
                        <p class="c__nubmer counter-js <?= $i ?>" data-from="0" data-to="<?= $counter["number"] ?>" data-speed="2000" data-refresh="1"> </p>
                        <h4 class="c__title"> <?= $counter["title"] ?></h4>
                        <div class="c__desc wysiwyg">
                            <?= $counter["description"] ?>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
            ?>

        </div>
        <?php
        $btn = get_field("cta");
        if (isset($btn) && $btn):
        ?>
            <div class="mb-15"></div>
            <div class="u-nav">
                <?php
                $btn = get_field("cta");
                btn_from_link($btn, "std-btn-primary mx-auto")
                ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php
wp_enqueue_script('count-js', get_template_directory_uri() . '/js/jquery.countTo.js', array('jquery'), filemtime(get_template_directory() . '/js/jquery.countTo.js'), false);
wp_enqueue_script('counters-js', get_template_directory_uri() . '/blocks/counters/counters.js', array('jquery', 'count-js'), filemtime(get_template_directory() . '/blocks/counters/counters.js'), false);
?>