<div id="homepage-hero" class="row">




    <?php $cacheKey = 'homepage-nav-'.$sf_user->getCulture() ?>
  <?php if (!cache($cacheKey)): ?>
    <div class="span6" id="homepage-nav" style="float:left;margin-left: 50px;">
      <p><?php echo __('Browse by') ?></p>
      <ul>
        <?php $icons = array(
          'browseInformationObjects' => '/images/icons-large/icon-archival.png',
          'browseActors' => '/images/icons-large/icon-people.png',
          'browseRepositories' => '/images/icons-large/icon-institutions.png',
          'browseSubjects' => '/images/icons-large/icon-subjects.png',
          'browseFunctions' => '/images/icons-large/icon-functions.png',
          'browsePlaces' => '/images/icons-large/icon-places.png',
          'browseDigitalObjects' => '/images/icons-large/icon-media.png') ?>
        <?php $browseMenu = QubitMenu::getById(QubitMenu::BROWSE_ID) ?>
        <?php if ($browseMenu->hasChildren()): ?>
          <?php foreach ($browseMenu->getChildren() as $item): ?>
            <li>
              <a href="<?php echo url_for($item->getPath(array('getUrl' => true, 'resolveAlias' => true))) ?>">
                <?php if (isset($icons[$item->name])): ?>
                  <?php echo image_tag($icons[$item->name], array('width' => 42, 'height' => 42, 'alt' => '')) ?>
                <?php endif; ?>
                <?php echo esc_specialchars($item->getLabel(array('cultureFallback' => true))) ?>
              </a>
            </li>
          <?php endforeach; ?>
        <?php endif; ?>
      </ul>
    </div>
    <?php cache_save($cacheKey) ?>
  <?php endif; ?>


  <div class="span4" id="intro" style="float: left;box-sizing: border-box;color: black;background-color: rgba(0,0,0,0.6);padding:5px;">
    <?php if ('fr' == $sf_user->getCulture()): ?>
      <h2>
        <span class="title">Jaringan Informasi KEARSIPAN Nasional </span>
        Votre accès à l’histoire du Canada
      </h2>
      <p>ARCHIVESCANADA.ca est un portail vous donnant accès à des ressources archivistiques à travers le Canada:<br />Par l'entremise de ce portail, vous pouvez faire une recherche dans les descriptions de documents d'archives, visionner des photographies, des cartes, ou d’autres documents numérisés ainsi que visiter des expositions virtuelles, et découvrir les dépôts d’archives qui détient l’information dont vous avez besoin. ARCHIVESCANADA.ca est votre portail archivistique national pour découvrir le patrimoine documentaire du Canada que l’on retrouve dans plus de 800 dépôts d'archives.</p>
    <?php else: ?>
      <h2>
        <span class="title">Jaringan Informasi KEARSIPAN Nasional </span>
      </h2>
      <p>Aplikasi SISTEM INFORMASI KEARSIPAN NASIONAL (SIKN) merupakan aplikasi antar-muka yang dapat digunakan oleh Simpul Jaringan memasukkan informasi kearsipan miliknya untuk selanjutnya dipublikasikan pada website JARINGAN INFORMASI KEARSIPAN NASIONAL (JIKN).Disamping itu, aplikasi ini dapat juga digunakan oleh Simpul Jaringan mengolah informasi kearsipan yang dimiliki dalam rangka membantu temu balik baik dalam format digital maupun lokasi fisik arsip di tempat penyimpanannya. Pencarian informasi kearsipan dapat dilakukan dengan berbagai kategori, meliputi: deskripsi arsip, pencipta arsip, fungsi, repositori (tempat penyimpanan), subjek, tempat, serta objek digitalnya. Disamping itu, aplikasi ini memungkinkan juga instansi mengetahui arsip mana yang paling sering diakses oleh pengguna..</p>

      <br />
      <strong>

Deputi Bidang Informasi dan Pengembangan Sistem Kearsipan - ARSIP NASIONAL REPUBLIK INDONESIA
      </strong>
    <?php endif; ?>
  </div>


</div>
</div>
<div class="row" style="background: #e6e6e6;margin-top: 30px;">
<div id="homepage" class="row">

  <div class="span4">
    <?php echo get_component('default', 'popular', array('limit' => 10, 'sf_cache_key' => $sf_user->getCulture())) ?>
  </div>

  <div class="span8" id="">
    <a href="#">
      <h3>
        <span class="title">Peta Simpul Jaringan</span>
        <span class="small">Jaringan Informasi Kearsipan Nasional </span>
      </h3>
      <div>
        <p>  <iframe src="https://www.google.com/maps/d/embed?mid=1ho6rT58tYnPdWKmeDrSJML1cT3I&ll=1.1718695496205245%2C120.9784149539156&z=4" width="800" height="480"></iframe></p>

      </div>
    </a>
  </div>

</div>
</div>