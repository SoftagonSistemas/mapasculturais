<?php

/**
 * @var MapasCulturais\App $app
 * @var MapasCulturais\Themes\BaseV2\Theme $this
 */

use MapasCulturais\i;

$this->import('
    theme-logo
');
$config = $app->config['social-media'];
?>
<?php $this->applyTemplateHook("main-footer", "before") ?>
<div v-if="globalState.visibleFooter" class="main-footer">
    <?php $this->applyTemplateHook("main-footer", "begin") ?>
    <div class="main-footer__content">
        <?php $this->applyTemplateHook("main-footer-logo", "before") ?>
        <div class="main-footer__support">
            <?php $this->part('footer-support-message') ?>
        </div>
        <div class="main-footer__content--logo">
            <div class="main-footer__content--logo-img">
                <?php
                // Obtenha a instância do AssetManager
                $assetManager = $this->getAssetManager();

                // Obtenha o URL do asset usando o método assetUrl do AssetManager
                $assetUrl = $assetManager->assetUrl('/img/fundajg.png');
                ?>

                <!-- Link da imagem para o site com atributos de acessibilidade -->
                <a href="https://www.fundajg.com.br/" target="_blank" rel="noopener noreferrer" aria-label="Visite o site da Fundação Cultural Guararapes" title="Fundação Cultural Guararapes">
                    <img src="<?= $assetUrl ?>" alt="Logo da Fundação Cultural Guararapes" width="200" height="80">
                </a>
            </div>


            <div class="main-footer__content--logo-share">
                <?php foreach ($config as $conf) : ?>
                    <a target="_blank" href="<?= $conf['link'] ?>">
                        <mc-icon name='<?= $conf['title'] ?>'></mc-icon>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php $this->applyTemplateHook("main-footer-logo", "after") ?>



        <?php $this->applyTemplateHook("main-footer-links", "before") ?>
        <div class="main-footer__content--links">
            <?php $this->applyTemplateHook("main-footer-links", "begin") ?>

            <ul class="main-footer__content--links-group">
                <li>
                    <a><?php i::_e("Acesse"); ?></a>
                </li>
                <li v-if="global.enabledEntities.opportunities">
                    <a href="<?= $app->createUrl('search', 'opportunities') ?>">
                        <mc-icon name="opportunity"></mc-icon> <?php i::_e('editais e oportunidades'); ?>
                    </a>
                </li>
                <li v-if="global.enabledEntities.events">
                    <a href="<?= $app->createUrl('search', 'events') ?>">
                        <mc-icon name="event"></mc-icon> <?php i::_e('eventos'); ?>
                    </a>
                </li>
                <li v-if="global.enabledEntities.agents">
                    <a href="<?= $app->createUrl('search', 'agents') ?>">
                        <mc-icon name="agent"></mc-icon> <?php i::_e('agentes'); ?>
                    </a>
                </li>
                <li v-if="global.enabledEntities.spaces">
                    <a href="<?= $app->createUrl('search', 'spaces') ?>">
                        <mc-icon name="space"></mc-icon> <?php i::_e('espaços'); ?>
                    </a>
                </li>
                <li v-if="global.enabledEntities.projects">
                    <a href="<?= $app->createUrl('search', 'projects') ?>">
                        <mc-icon name="project"></mc-icon> <?php i::_e('projetos'); ?>
                    </a>
                </li>
            </ul>

            <ul class="main-footer__content--links-group">
                <li>
                    <a href="<?= $app->createUrl('panel', 'index') ?>"><?php i::_e('Painel'); ?></a>
                </li>
                <li v-if="global.enabledEntities.opportunities">
                    <a href="<?= $app->createUrl('panel', 'opportunities') ?>"><?php i::_e('Editais e oportunidades'); ?></a>
                </li>
                <li v-if="global.enabledEntities.events">
                    <a href="<?= $app->createUrl('panel', 'events') ?>"><?php i::_e('Meus eventos'); ?></a>
                </li>
                <li v-if="global.enabledEntities.agents">
                    <a href="<?= $app->createUrl('panel', 'agents') ?>"><?php i::_e('Meus agentes'); ?></a>
                </li>
                <li v-if="global.enabledEntities.spaces">
                    <a href="<?= $app->createUrl('panel', 'spaces') ?>"><?php i::_e('Meus espaços'); ?></a>
                </li>
                <?php if (!($app->user->is('guest'))) : ?>
                    <li>
                        <a href="<?= $app->createUrl('auth', 'logout') ?>"><?php i::_e('Sair') ?></a>
                    </li>
                <?php endif; ?>
            </ul>

            <ul class="main-footer__content--links-group">
                <li>
                    <a><?php i::_e('Ajuda e privacidade'); ?></a>
                </li>

                <li>
                    <a href="<?= $app->createUrl('faq') ?>"><?php i::_e('Dúvidas frequentes'); ?></a>
                </li>

                <?php if (count($app->config['module.LGPD']) > 0) : ?>
                    <?php foreach ($app->config['module.LGPD'] as $slug => $cfg) : ?>
                        <li>
                            <a href="<?= $app->createUrl('lgpd', 'view', [$slug]) ?>"><?= $cfg['title'] ?></a>
                        </li>
                    <?php endforeach ?>
                <?php endif; ?>
            </ul>
            <?php $this->applyTemplateHook("main-footer-links", "end") ?>
        </div>
        <?php $this->applyTemplateHook("main-footer-links", "after") ?>
    </div>
    <?php $this->applyTemplateHook("main-footer-reg", "before") ?>
    <div class="main-footer__reg">
        <?php $this->applyTemplateHook("main-footer-reg", "begin") ?>
        <div class="main-footer__reg-content">
            <p>
                plataforma da comunidade
                <strong><a href="https://github.com/mapasculturais/mapasculturais/releases/tag/v7.3.58" target="_blank"> mapas culturais</a> </strong>
                instalado <strong><a href="https://governo.app">por governo.app</a> </strong>
            </p>

            <a class="link" href="https://desenvolvimento.jaboatao.pe.gov.br/">
                Jaboatão dos Guararapes
            </a>
        </div>
        <?php $this->applyTemplateHook("main-footer-reg", "end") ?>
    </div>
    <?php $this->applyTemplateHook("main-footer-reg", "after") ?>
    <?php $this->applyTemplateHook("main-footer", "end") ?>
</div>
<?php $this->applyTemplateHook("main-footer", "after") ?>