<?php
// No direct access
defined('_JEXEC') or die;

//JHtml::_('jquery.framework');

function getImgSizeUrl($url, $width = 'L')
{
    //width : XL, L, M, S, XS
    $all_sizes = array('_2000', '_1500', '_762', '_277', '_50');

    switch ($width) {
        case 'XL':
            return str_replace($all_sizes, '_2000', $url);
            break;
        case 'L':
            return str_replace($all_sizes, '_1500', $url);
            break;
        case 'M':
            return str_replace($all_sizes, '_762', $url);
            break;
        case 'S':
            return str_replace($all_sizes, '_277', $url);
            break;
        case 'XS':
            return str_replace($all_sizes, '_50', $url);
            break;
    }
    return false;
}
?>
<style>

    .free_promo_container_wrapper {
        max-width: none;
    }

    .free_promo_container_wrapper #free_promo {
        padding-top: 39.9%;
    }

</style>
<div class="container">
    <div class="free_promo_container_wrapper">
        <div id="free_promo" class="carousel slide carousel-fade" data-ride="carousel">
            <div class="carousel_btns_wrapper">
                <div class="carousel_btns">
                    <a href="#">
                        <div class="read_more">Read More</div>
                    </a>
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#free_promo" data-slide-to="0" class="active"></li>
                        <li data-target="#free_promo" data-slide-to="1"></li>
                        <li data-target="#free_promo" data-slide-to="2"></li>
                        <li data-target="#free_promo" data-slide-to="3"></li>
                    </ol><!-- Wrapper for slides -->
                </div>
            </div>
            <div class="carousel-inner">
                <div class="item active"><img class="lazyload carousel_1" data-src="/images/page/edupacks/gallery/06-eduPack-promo_1_1500.jpg" alt="" /></div>
                <div class="item"><img class="lazyload" data-src="/images/page/edupacks/gallery/06-eduPack-promo_2_1500.jpg" alt="" /></div>
                <div class="item"><img class="lazyload" data-src="/images/page/edupacks/gallery/06-eduPack-promo_3_1500.jpg" alt="" /></div>
                <div class="item"><img class="lazyload" data-src="/images/page/edupacks/gallery/06-eduPack-promo_4_1500.jpg" alt="" /></div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix" style="margin-bottom:15px;"></div>
<?php
$freebie1 = array(
    'title' => 'Cat Edupack',
    'archor' => 'cat_edupack',
    'main_thumb' => '/images/poster/edupack/cat/Edupack_cats_762.jpg',
    'main_thumb_alt' => 'cat',
    'additional_images' =>
    array('/images/poster/edupack/cat/P12001_762.jpg', '/images/poster/edupack/cat/P12002_762.jpg'),
    'additional_images_alt' =>
    array('', '', ''),
    'file' => 'handbook_w_watermarks/cat.zip',
    'introtext' =>
    '<ul class="a-unordered-list a-vertical a-spacing-none">
        <li><span class="a-list-item">【テーブルサイズ】幅60奥行40×高さ28cm、重量2.6kg、耐荷重：40kg</span></li>
        <li><span class="a-list-item">【素材＆材質】天板/プリント紙化粧パーティクルボード、天板側面/合成樹脂(PVC)、脚部/アルミ。</span></li>
        <li><span class="a-list-item">【持ち運び・収納も簡単】折りたたみから収納するまで2つのステップしかない！アルミニウム製の足を折りたためばベッドやソファー下、隙間への収納が可能。インストールする必要はありません。インドアやアウトドア活動に適用です。</span></li>
        <li><span class="a-list-item">【ヒューマナイズドデザイン】いつでもどこでも快適さをもたらします。 スペースアルミで作られたU型脚部、軽くてしっかり立てます。 脚部保護パッド、滑り止めで磨滅に耐える。 お腹にフィットする人間工学弧線設計で、もっと快適、凹溝付きで、タブレット/スマホが簡単に置けます。</span></li>
        <li><span class="a-list-item">【ノートパソコンに最適なミニデスク】11-17インチのノートPCの使用に最適な折り畳み式テーブル、ベッド・ソファーの上でも勉強や仕事、読書、執筆、ゲームなどの作業が快適に。お茶を飲んだり、お菓子を食べたり、お子さんの勉強机にも手頃な大きさで役立ちます。食事、勉強、ゲームなどの際にぴったりのちゃぶ台です。</span></li>
        </ul>'
);
$freebies = array(
    $freebie1
);
$freebie2 = array(
    'title' => 'Dog Edupack',
    'archor' => 'dog_handbook',
    'main_thumb' => '/images/poster/edupack/dog/Edupack_dogs_762.jpg',
    'main_thumb_alt' => 'dog',
    'additional_images' =>
    array('/images/poster/edupack/dog/P12003_762.jpg', '/images/poster/edupack/dog/P12004_762.jpg', '/images/poster/edupack/dog/P12005_762.jpg'),
    'additional_images_alt' =>
    array('', '', ''),
    'file' => 'handbook_w_watermarks/dog.zip',
    'introtext' =>
    '<ul class="a-unordered-list a-vertical a-spacing-none">
        <li><span class="a-list-item">【テーブルサイズ】幅60奥行40×高さ28cm、重量2.6kg、耐荷重：40kg</span></li>
        <li><span class="a-list-item">【素材＆材質】天板/プリント紙化粧パーティクルボード、天板側面/合成樹脂(PVC)、脚部/アルミ。</span></li>
        <li><span class="a-list-item">【持ち運び・収納も簡単】折りたたみから収納するまで2つのステップしかない！アルミニウム製の足を折りたためばベッドやソファー下、隙間への収納が可能。インストールする必要はありません。インドアやアウトドア活動に適用です。</span></li>
        <li><span class="a-list-item">【ヒューマナイズドデザイン】いつでもどこでも快適さをもたらします。 スペースアルミで作られたU型脚部、軽くてしっかり立てます。 脚部保護パッド、滑り止めで磨滅に耐える。 お腹にフィットする人間工学弧線設計で、もっと快適、凹溝付きで、タブレット/スマホが簡単に置けます。</span></li>
        <li><span class="a-list-item">【ノートパソコンに最適なミニデスク】11-17インチのノートPCの使用に最適な折り畳み式テーブル、ベッド・ソファーの上でも勉強や仕事、読書、執筆、ゲームなどの作業が快適に。お茶を飲んだり、お菓子を食べたり、お子さんの勉強机にも手頃な大きさで役立ちます。食事、勉強、ゲームなどの際にぴったりのちゃぶ台です。</span></li>
        </ul>'
);
array_push($freebies, $freebie2);

function has_next(array $_array)
{
    return next($_array) !== false ?: key($_array) !== null;
}

function getImageAlt(&$images_alts, $i)
{
    if ($images_alts != null) {
        if ($i == 0) {
            return reset($images_alts);
        } else if (has_next($images_alts)) {
            return next($images_alts);
        }
    }
    return '';
}

?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 pull-right sidebar_right">
    <div class="promotional_banner">
        <div class="promotional_banner_wrapper">
            <h3>EduPack Series</h3>
            <img src="/images/poster/edupack/dog/dog_edupack.jpg" />
            <p>Buy 1 Bundle <br />Get 1 EduPack + 1 Handbook</p>
            <a href="#">Click to learn more</a>
        </div>
    </div>
    <div class="promotional_banner">
        <div class="promotional_banner_wrapper">
            <h3>Chart Posters</h3>
            <img src="/images/page/edupacks/side_irish_terrier.png" />
            <p>Full Color, Organised, Informative</p>
            <a href="#">Click to learn more</a>
        </div>
    </div>
    <div class="promotional_banner">
        <div class="promotional_banner_wrapper">
            <h3>Get Access To Interactive Learning Materials</h3>
            <img src="/images/page/edupacks/qrcode.png" style="margin-bottom: 0;"/>
            <img src="/images/page/edupacks/interactive-table.png" />
            <p>Scan the QR code and learn more online</p>
            <a href="#">Click to learn more</a>
        </div>
    </div>
    <div class="promotional_banner">
        <div class="promotional_banner_wrapper">
            <h3>Excellent Quality Control</h3>
            <img src="/images/page/edupacks/promo-icons-printer.png" />
            <p>Printed in Japan by Reputable Japanese Printer</p>
            <a href="#">Click to learn more</a>
        </div>
    </div>
    <div class="promotional_banner">
        <div class="promotional_banner_wrapper">
            <h3>Our Poster uses High-Quality Paper</h3>
            <img src="/images/page/edupacks/promo-icons-quality.png" />
            <p>Premium Japanese paper '金藤',<br />180kg with gloss PP lamination</p>
            <a href="#">Click to learn more</a>
        </div>
    </div>
    <div class="promotional_banner">
        <div class="promotional_banner_wrapper">
            <h3>Our Poster is hard to tear</h3>
            <img src="/images/page/edupacks/promo-icons-strong.png" />
            <p>gloss laminated: 引っ張り、折り曲げなどに強く、紙のレベルをはるかに上回る破れにくさで、繰り返しの張り替えにも対応します。</p>
            <a href="#">Click to learn more</a>
        </div>
    </div>
    <div class="promotional_banner">
        <div class="promotional_banner_wrapper">
            <h3>Our Poster is Water Resistant</h3>
            <img src="/images/page/edupacks/promo-icons-water-repel.png" />
            <a href="#">Click to learn more</a>
        </div>
    </div>
    <div class="promotional_banner">
        <div class="promotional_banner_wrapper">
            <h3>Carefully Packaged</h3>
            <img src="/images/page/edupacks/promo-icons-packing-tube-sqpng.png" />
            <p>bulk rolled and put into a plastic tube then inserted into a tube</p>
            <a href="#">Click to learn more</a>
        </div>
    </div>
</div>

<div class="free_items col-sm-12 col-md-12 col-lg-10">
    <div class="free_items_wrapper">
        <?php $j = 0;
        foreach ($freebies as $freebie) { ?>
            <div class="free_item"><a id="<?php echo $freebie['archor'] ?>"></a>
                <div class="col-sm-12 hidden-md hidden-lg">
                    <h1 itemprop="name" class="product-title"><?php echo $freebie['title']; ?></h1>
                </div>

                <div class="col-sm-12 col-md-4 col-lg-4">

                    <div class="slider_sm_wrapper hidden-md hidden-lg">
                        <div class="sm_slider" data-id="<?php echo $j ?>">

                            <div><img class="tns-lazy-img" data-src="<?php echo $freebie['main_thumb'] ?>" alt="<?php echo $freebie['main_thumb_alt'] ?>" /></div>

                            <?php
                            $i = 0;
                            foreach ($freebie['additional_images'] as $additional_image) {

                                $image_alt = getImageAlt($freebie['additional_images_alt'], $i);

                            ?>
                                <div><img class="tns-lazy-img" data-src="<?php echo $additional_image ?>" alt="<?php echo $image_alt; ?>" /></div>
                            <?php
                                $i++;
                            } ?>
                        </div>
                    </div>

                    <div class="slider_md_whole_wrapper hidden-sm hidden-xs">

                        <div class="slider_md_thumbnails_wrapper">
                            <ul class="thumbnails slider_md_thumbnails" data-id="<?php echo $j ?>">
                                <li>
                                    <div class="image-wrapper">
                                        <div class="a-image-wrapper"><img class="lazyload" data-src="<?php echo getImgSizeUrl($freebie['main_thumb'], 'XS') ?>" alt="<?php echo $freebie['main_thumb_alt'] ?>" /></div>
                                    </div>
                                </li>

                                <?php $i = 0;
                                foreach ($freebie['additional_images'] as $additional_image) {
                                    $image_alt = getImageAlt($freebie['additional_images_alt'], $i);
                                ?>
                                    <li>
                                        <div class="image-wrapper">
                                            <div class="a-image-wrapper"><img class="lazyload" data-src="<?php echo getImgSizeUrl($additional_image, 'XS') ?>" alt="<?php echo $image_alt; ?>" /></div>
                                        </div>
                                    </li>
                                <?php
                                    $i++;
                                } ?>
                            </ul>
                        </div>

                        <div class="slider_md_wrapper">
                            <div class="md_slider" data-id="<?php echo $j; ?>">

                                <div class="image-wrapper">
                                    <div class="a-image-wrapper">
                                        <img data-id="main" class="tns-lazy-img" data-src="<?php echo $freebie['main_thumb'] ?>" data-zoomsrc="<?php echo getImgSizeUrl($freebie['main_thumb'], 'L'); ?>" alt="<?php echo $freebie['main_thumb_alt'] ?>" />
                                    </div>
                                </div>

                                <?php
                                $i = 0;
                                foreach ($freebie['additional_images'] as $additional_image) {
                                    $image_alt = getImageAlt($freebie['additional_images_alt'], $i);
                                ?>
                                    <div class="image-wrapper">
                                        <div class="a-image-wrapper"><img data-id="additional-<?php echo $i ?>" class="tns-lazy-img" data-src="<?php echo $additional_image ?>" data-zoomsrc="<?php echo getImgSizeUrl($additional_image, 'L'); ?>" alt="<?php echo $image_alt; ?>" /></div>
                                    </div>
                                <?php
                                    $i++;
                                } ?>
                            </div>

                            <div class="image_canvas_caption">
                                <div class="image_canvas_caption_wrapper">
                                    <span class="default_caption" style="display:none;">画像にマウスを合わせると拡大されます</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-xs-12 col-md-8 main_content_col">
                    <div class="buy_box pull-right">
                        <div class="buy_box_inner">
                            <div class="price_delivery_intro">
                                <p class="price_inside_buybox">無料</p>
                                <p>ご注文を検討している方を対象に、無料でサンプルを提供いたします。</p>
                                <p id="ddmDeliveryMessage" class="a-section a-spacing-mini">このサンプルは、印刷物以外の電子データです。</p>
                            </div>
                            <form name="info_request<?php echo $j; ?>" class="info_request" data-id="<?php echo $j; ?>">
                                <div class="email_input_wrapper">
                                    <input type="hidden" name="file" value="<?php echo $freebie['file'] ?>" />
                                    <input type="text" class="form_name" name="name" placeholder="お名前" />
                                    <input type="email" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" class="email" name="email" placeholder="メールアドレス" />
                                </div>
                                <div class="success" style="display:none;">
                                    Thank you for your interest. A download link will be sent to your specified email address.
                                </div>
                                <div class="fail" style="display:none;">
                                    Errors occured. Please try again later.
                                </div>
                                <div class="btn_to_amazon to_single">
                                    <span class="a-button-inner">
                                        <i class="a-icon a-icon-buynow"></i>
                                        <input title="無料サンプル請求" class="a-button-input" type="submit" value="Submit" aria-labelledby="a-autoid-1-announce">
                                        <span class="a-button-text" aria-hidden="true" id="a-autoid-1-announce">
                                            無料サンプル請求
                                        </span>
                                    </span>
                                </div>
                            </form>

                            <div class="product_delivery_intro">
                                <p style="margin-bottom: 0;">このサンプルのダウンロードリンクは、こちらが<span class="a-text-bold">メール</span>でお送りいただきます。</p>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix hidden-md hidden-lg"></div>
                    <div class="main_content_md hidden-md hidden-lg">
                        <h3>この商品について</h3>
                        <?php echo $freebie['introtext']; ?>
                    </div>
                    <div class="hidden-sm hidden-xs main_content">
                        <h1 itemprop="name" class="product-title"><?php echo $freebie['title']; ?></h1>
                        <?php echo $freebie['introtext']; ?>
                    </div>
                    <div class="image_zoom_preview" data-id="<?php echo $j ?>"></div>
                </div>

                <div class="clearfix"></div>
            </div>


            <!-- Modal -->
            <div class="modal productGallery" data-id="<?php echo $j ?>" tabindex="-1" role="dialog" aria-labelledby="productGalleryLabel" data-backdrop="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="back_btn_wrapper">
                                <button type="button" class="btn btn-default back" data-dismiss="modal"></button>
                                <div class="back_btn_text">
                                    <span>戻る</span>
                                </div>
                            </div>

                            <div class="productGallery_slider" data-id="<?php echo $j ?>">
                                <div><img class="tns-lazy-img" data-src="<?php echo getImgSizeUrl($freebie['main_thumb'], 'L') ?>" alt="<?php echo $freebie['main_thumb_alt'] ?>" /></div>

                                <?php
                                $i = 0;
                                foreach ($freebie['additional_images'] as $additional_image) {

                                    $image_alt = getImageAlt($freebie['additional_images_alt'], $i);

                                ?>
                                    <div><img class="tns-lazy-img" data-src="<?php echo getImgSizeUrl($additional_image, 'L') ?>" alt="<?php echo $image_alt; ?>" /></div>
                                <?php
                                    $i++;
                                } ?>
                            </div>
                            <ul class="thumbnails slider_sm_thumbnails" data-id="<?php echo $j ?>">
                                <li>
                                    <div class="image-wrapper">
                                        <div class="a-image-wrapper"><img class="tns-lazy-img" data-src="<?php echo getImgSizeUrl($freebie['main_thumb'], 'M'); ?>" alt="<?php echo $freebie['main_thumb_alt'] ?>" /></div>
                                    </div>
                                </li>

                                <?php
                                $i = 0;
                                foreach ($freebie['additional_images'] as $additional_image) {

                                    $image_alt = getImageAlt($freebie['additional_images_alt'], $i);
                                ?>
                                    <li>
                                        <div class="image-wrapper">
                                            <div class="a-image-wrapper"><img class="tns-lazy-img" data-src="<?php echo getImgSizeUrl($additional_image, 'M'); ?>" alt="<?php echo $image_alt; ?>" /></div>
                                        </div>
                                    </li>
                                <?php
                                    $i++;
                                } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal productGallery_m" data-id="<?php echo $j ?>" tabindex="-1" role="dialog" aria-labelledby="productGalleryLabel_m">
                <div class="vertical_alignment_helper">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="close_btn_wrapper">
                                <button type="button" class="btn btn-default close" data-dismiss="modal"><i class="fas fa-times"></i></button>
                            </div>
                            <div class="modal-body">
                                <div class="main_wrapper">
                                    <div class="thumbnails_column">
                                        <div class="title"><?php echo $freebie['title']; ?></div>
                                        <div class="thumbnails_wrapper">
                                            <div class="thumbnails_row_wrapper">
                                                <div class="image_wrapper">
                                                    <img data-id="main" class="thumbnail_image lazyload" data-src="<?php echo getImgSizeUrl($freebie['main_thumb'], 'XS'); ?>" data-zoomsrc="<?php echo getImgSizeUrl($freebie['main_thumb'], 'L'); ?>" title="<?php echo $freebie['main_thumb_alt'] ?>" />
                                                </div>
                                                <?php
                                                $i = 0;
                                                foreach ($freebie['additional_images'] as $additional_image) {
                                                    $image_alt = getImageAlt($freebie['additional_images_alt'], $i); ?>
                                                    <div class="image_wrapper">
                                                        <img data-id="additional-<?php echo $i ?>" class="thumbnail_image lazyload" data-src="<?php echo getImgSizeUrl($additional_image, 'XS'); ?>" data-zoomsrc="<?php echo getImgSizeUrl($additional_image, 'L'); ?>" title="<?php echo $image_alt; ?>" />
                                                    </div>
                                                    <?php if (($i == 2) && count($freebie['additional_images']) > 3) { ?>
                                            </div>
                                            <div class="thumbnails_row_wrapper">
                                            <?php } ?>

                                        <?php $i++;
                                                } ?>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="enlarged_image_wrapper">
                                        <div class="table_wrapper">
                                            <div class="enlarged_image">
                                                <img class="lazyload" data-src="<?php echo getImgSizeUrl($freebie['main_thumb'], 'L'); ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
            $j++;
        }
        ?>
    </div>
</div>
<div class="clearfix"></div>