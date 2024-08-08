<?php

/**
 * @var MapasCulturais\App $app
 * @var MapasCulturais\Themes\BaseV2\Theme $this
 */

use MapasCulturais\i;

$this->import('
    home-search
');

?>
<div :class="['home-header', {'home-header--withBanner' : banner}] ">
    <div class="home-header__content">

        <div class="home-header__main">
            <label class="home-header__title">
                <?= $this->text('title', i::__('Bem-vindo ao Mapa Cultural e Turístico de Triunfo!')) ?>
            </label>
            <p class="home-header__description">
                <?= $this->text('description', i::__('Conecte-se, divulgue suas iniciativas e participe da promoção da nossa rica diversidade cultural. Vamos celebrar juntos! ')) ?>
            </p>
        </div>

        <div class="home-header__banners">
            <div v-if="banner" class="home-header__banner">
                <a v-if="bannerLink" :href="bannerLink" :download="downloadableLink ? '' : undefined" :target="!downloadableLink ? '_blank' : null">
                    <img :src="banner" />
                </a>
                <img v-if="!bannerLink" :src="banner" />
            </div>

            <div v-if="secondBanner" class="home-header__banner">
                <a v-if="secondBannerLink" :href="secondBannerLink" :download="secondDownloadableLink ? '' : undefined" :target="!secondDownloadableLink ? '_blank' : null">
                    <img :src="secondBanner" />
                </a>
                <img v-if="!secondBannerLink" :src="secondBanner" />
            </div>

            <div v-if="thirdBanner" class="home-header__banner">
                <a v-if="thirdBannerLink" :href="thirdBannerLink" :download="thirdDownloadableLink ? '' : undefined" :target="!thirdDownloadableLink ? '_blank' : null">
                    <img :src="thirdBanner" />
                </a>
                <img v-if="!thirdBannerLink" :src="thirdBanner" />
            </div>
        </div>

    </div>
    <div class="home-header__background">
        <div class="img">
            <img :src="background" />
        </div>
    </div>
    <!-- <home-search></home-search> -->
</div>