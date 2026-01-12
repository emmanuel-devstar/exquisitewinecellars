<?php

/**
 * Block FAQ
 */
?>

<?php
$content = get_field("content");
$topics = get_field("topics");
$settings = get_field("settings");

$data = block_start("FAQ", $block, $settings, "section-gray");
$id = $data["id"];
$color_schema = $data["color_schema"];
?>

<div class="c-section--faq <?= $color_schema; ?>" id="<?php echo esc_attr($id); ?>">
    <div class="container-fluid container-fluid-lg">
  
                <?php
                if ($content["headline_text"]) :
                ?>
                    <<?= $data["h_tag"]; ?> class="section__title custom-title-colour "><?= $content["headline_text"]; ?></<?= $data["h_tag"]; ?>>
                <?php
                endif;
                ?>

                <?php
                if ($content["body_text"]) :
                ?>
                    <p class="section__subtitle "><?= $content["body_text"] ?></p>
                <?php
                endif;
                ?>

                <div class="faq-wrapper">

                    <?php
                    foreach ($topics as $topic) :
                    ?>

                        <div class="faq__row faq-row-js u-no-select">
                            <div class="faq__header">
                                <div class="header__content"><?= $topic["question"] ?> </div>

                                <div class="faq__icon">
                                    <div class="expand icon__img">
                                        <?= file_get_contents(IMAGES . '/icons/expand.svg'); ?>
                                    </div>

                                    <div class="colapse icon__img">
                                        <?= file_get_contents(IMAGES . '/icons/colapse.svg'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="faq__content acc-content-js">

                                <div class="content__wrapper wysiwyg"><?= wysiwyg_clean($topic["answer"]) ?></div>
                            </div>
                        </div>

                    <?php
                    endforeach;
                    ?>

                </div>
    
    </div>

</div>



<?php
wp_enqueue_script('faq-js', get_template_directory_uri() . '/blocks/faq/faq.js', array('jquery'), filemtime(get_template_directory() . '/blocks/faq/faq.js'), false);
?>