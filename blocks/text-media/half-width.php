<div class="banner__start">
    <?php
    $data = block_start("tm_slide_" . $index, $block, $settings);
    $id = $data["id"];
    $color_schema = (empty($data["color_schema"])) ? "section-bright" : $data["color_schema"];
    ?>
    <div id="<?= esc_attr($id); ?>" class="c-banner <?= $banner_class; ?> l-half <?= $color_schema ?>">

        <div class="container-fluid ">

            <div class="row  u-w-1350-100 <?= $carousel["image_aligment"]; ?> ">
                <div class="col-12 col-xl-6 col__content pl-xl-0">
                    <div class="banner__content">
                        <?php if ($content["title"]) : ?>

                            <<?= $heading_tag; ?> class="banner__title custom-title-colour">
                                <?= $content["title"] ?>
                            </<?= $heading_tag; ?>>

                        <?php endif; ?>

                        <?php if ($content["description"]) : ?>

                            <div class="banner__desc wysiwyg u-br-none">
                                <?= $content["description"] ?>
                            </div>

                        <?php endif; ?>

                        <?php
                        if (isset($ctas["button_cta_left"]) && $ctas["button_cta_left"] || isset($ctas["button_cta_right"]) && $ctas["button_cta_right"]) :
                        ?>
                            <div class="desc__bottom"></div>
                        <?php
                        endif;
                        ?>

                        <?php
                        $btn_class = isset($ctas["button_cta_right"]) ? "std-btn-primary mr-3 mb-3" : "std-btn-primary mr-3 mb-0";
                        echo btn_from_link($ctas["button_cta_left"], $btn_class);
                        ?>
                        <?php
                        echo btn_from_link($ctas["button_cta_right"], "std-btn-secondary mb-0");
                        ?>

                    </div>
                </div>
                <div class="col-12 col-xl-6 pr-xl-0">
                    <?php
                    if ($background["image"]) :
                    ?>
                        <img class="banner__image" src="<?= $background["image"]["sizes"]["extra_large"]; ?>" alt="<?= $background["image"]["alt"] ?>">
                    <?php
                    endif;
                    ?>
                </div>

            </div>

        </div>

    </div>
</div>