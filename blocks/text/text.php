<?php
/**
 * Block Name: Text
 */
?>

<?php
$banner = array();
$banner = get_field("banner");

$carousel = get_field("carousel");
$color_schema = $color_schema ?? null;

$data = block_start("text", $block, $carousel, $color_schema);
$id = $data["id"];
$color_schema = $data["color_schema"];

$mode = (trim(strtolower($carousel["mode"] ?? '')) === "carousel") ? "carousel" : "single";

if($mode==="single"){
    $banner[] = get_field("slide");
}
?>
<div class="u-relative <?= $color_schema; ?> " id="<?php echo esc_attr($id); ?>">
    <div  class=" banner-wrapper full">
        <?php
        foreach ($banner as $index => $slide) :            

            $content = $slide["content"];
            $background = $slide["background"];
            $settings = $slide["settings"];

            $heading_tag = ($index === 0  && $data["h_tag"] === "h1") ? "h1" : "h2";
            
            $ctas = $slide["ctas"];

            include("full-width.php");

            if ($mode === "single") break;

        endforeach;
        ?>

    </div>    

</div>